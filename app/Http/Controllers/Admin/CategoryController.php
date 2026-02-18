<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $categories = Category::with('parent')
            ->withCount('projects')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $image = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $uploadPath = 'upload/categories';
            $fileName = Str::slug($validated['name']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);
            $image = $uploadPath.'/'.$fileName;
        }

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $image,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'parent_id' => $validated['parent_id'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function show(Category $category): \Illuminate\Contracts\View\View
    {
        $category->load(['parent', 'children', 'projects']);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): \Illuminate\Contracts\View\View
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'parent_id' => $validated['parent_id'],
            'sort_order' => $validated['sort_order'] ?? $category->sort_order,
        ];

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $uploadPath = 'upload/categories';
            $fileName = Str::slug($validated['name']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            // Eski resmi sil
            if ($category->image && file_exists(public_path($category->image))) {
                @unlink(public_path($category->image));
            }

            $updateData['image'] = $uploadPath.'/'.$fileName;
        }

        $category->update($updateData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->projects()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Projeleri olan kategori silinemez.');
        }

        if ($category->image && file_exists(public_path($category->image))) {
            @unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }

    public function updateOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->categories as $item) {
            Category::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    public function quickUpdate(Request $request, Category $category): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'field' => 'required|in:name,status',
            'value' => 'required',
        ]);

        if ($request->field === 'name') {
            $category->update([
                'name' => $request->value,
                'slug' => Str::slug($request->value),
            ]);
        } else {
            $category->update([$request->field => $request->value]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori güncellendi.',
        ]);
    }

    public function updateImage(Request $request, Category $category): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/categories';
            $fileName = Str::slug($category->name).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            // Eski resmi sil
            if ($category->image && file_exists(public_path($category->image))) {
                @unlink(public_path($category->image));
            }

            $category->update(['image' => $uploadPath.'/'.$fileName]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori fotoğrafı başarıyla güncellendi.',
                'image_url' => $category->image,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Fotoğraf yüklenemedi.',
        ], 400);
    }
}
