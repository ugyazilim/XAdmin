<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $pages = Page::orderBy('sort_order')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $templates = [
            'default' => 'Standart Sayfa',
            'contact' => 'İletişim',
        ];

        return view('admin.pages.create', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'template' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $image = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/pages';
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
        while (Page::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'featured_image' => $image,
            'template' => $validated['template'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    public function show(Page $page): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): \Illuminate\Contracts\View\View
    {
        $templates = [
            'default' => 'Standart Sayfa',
            'contact' => 'İletişim',
        ];

        return view('admin.pages.edit', compact('page', 'templates'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'template' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'template' => $validated['template'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? $page->sort_order,
        ];

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/pages';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            // Eski resmi sil
            if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                @unlink(public_path($page->featured_image));
            }

            $updateData['featured_image'] = $uploadPath.'/'.$fileName;
        }

        $page->update($updateData);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->featured_image && file_exists(public_path($page->featured_image))) {
            @unlink(public_path($page->featured_image));
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla silindi.');
    }

    public function togglePublish(Page $page): RedirectResponse
    {
        $page->update(['is_published' => ! $page->is_published]);

        $message = $page->is_published ? 'Sayfa yayınlandı.' : 'Sayfa yayından kaldırıldı.';

        return back()->with('success', $message);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:pages,id',
        ]);

        $pages = Page::whereIn('id', $validated['ids'])->get();

        foreach ($pages as $page) {
            if ($page->featured_image && file_exists(public_path($page->featured_image))) {
                @unlink(public_path($page->featured_image));
            }
            $page->delete();
        }

        $count = count($validated['ids']);

        return redirect()->route('admin.pages.index')
            ->with('success', "{$count} sayfa başarıyla silindi.");
    }
}
