<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $news = News::orderBy('sort_order')->orderBy('published_at', 'desc')->get();

        return view('admin.news.index', compact('news'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'type' => 'required|in:news,announcement',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        $image = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/news';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);
            $image = $uploadPath.'/'.$fileName;
        }

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        News::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $image,
            'type' => $validated['type'],
            'published_at' => $validated['published_at'] ?? now(),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Haber/Duyuru başarıyla oluşturuldu.');
    }

    public function show(News $news): \Illuminate\Contracts\View\View
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news): \Illuminate\Contracts\View\View
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'type' => 'required|in:news,announcement',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (News::where('slug', $slug)->where('id', '!=', $news->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'published_at' => $validated['published_at'] ?? $news->published_at,
            'sort_order' => $validated['sort_order'] ?? $news->sort_order,
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/news';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            if ($news->featured_image && file_exists(public_path($news->featured_image))) {
                @unlink(public_path($news->featured_image));
            }

            $updateData['featured_image'] = $uploadPath.'/'.$fileName;
        }

        $news->update($updateData);

        return redirect()->route('admin.news.index')
            ->with('success', 'Haber/Duyuru başarıyla güncellendi.');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->featured_image && file_exists(public_path($news->featured_image))) {
            @unlink(public_path($news->featured_image));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Haber/Duyuru başarıyla silindi.');
    }

    public function updateImage(Request $request, News $news): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/news';
            $fileName = Str::slug($news->title).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            // Eski resmi sil
            if ($news->featured_image && file_exists(public_path($news->featured_image))) {
                @unlink(public_path($news->featured_image));
            }

            $news->update(['featured_image' => $uploadPath.'/'.$fileName]);

            return response()->json([
                'success' => true,
                'message' => 'Haber fotoğrafı başarıyla güncellendi.',
                'image_url' => $news->featured_image,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Fotoğraf yüklenemedi.',
        ], 400);
    }
}
