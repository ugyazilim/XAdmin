<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $services = Service::with('images')
            ->orderBy('sort_order')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $categories = \App\Models\Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'image_alt_texts' => 'nullable|array',
            'image_alt_texts.*' => 'nullable|string|max:255',
        ]);

        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/services';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);
            $featuredImage = $uploadPath.'/'.$fileName;
        }

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $service = Service::create([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'content' => $validated['content'],
            'icon' => $validated['icon'],
            'featured_image' => $featuredImage,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
        ]);

        // Service Images
        if ($request->hasFile('images')) {
            $uploadPath = 'upload/services/gallery';
            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            foreach ($request->file('images') as $index => $file) {
                $fileName = Str::slug($validated['title']).'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($fullPath, $fileName);

                ServiceImage::create([
                    'service_id' => $service->id,
                    'image' => $uploadPath.'/'.$fileName,
                    'alt_text' => $validated['image_alt_texts'][$index] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla oluşturuldu.');
    }

    public function show(Service $service): \Illuminate\Contracts\View\View
    {
        $service->load('images');

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service): \Illuminate\Contracts\View\View
    {
        $service->load('images');
        $categories = \App\Models\Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'image_alt_texts' => 'nullable|array',
            'image_alt_texts.*' => 'nullable|string|max:255',
            'existing_image_ids' => 'nullable|array',
            'existing_image_alt_texts' => 'nullable|array',
            'existing_image_alt_texts.*' => 'nullable|string|max:255',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'content' => $validated['content'],
            'icon' => $validated['icon'],
            'sort_order' => $validated['sort_order'] ?? $service->sort_order,
            'is_active' => $request->boolean('is_active'),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
        ];

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $uploadPath = 'upload/services';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            if ($service->featured_image && file_exists(public_path($service->featured_image))) {
                @unlink(public_path($service->featured_image));
            }

            $updateData['featured_image'] = $uploadPath.'/'.$fileName;
        }

        $service->update($updateData);

        // Update existing images
        if ($request->has('existing_image_ids')) {
            $existingIds = $request->input('existing_image_ids', []);
            $existingAltTexts = $request->input('existing_image_alt_texts', []);

            foreach ($existingIds as $index => $imageId) {
                $image = ServiceImage::find($imageId);
                if ($image && $image->service_id === $service->id) {
                    $image->update([
                        'alt_text' => $existingAltTexts[$index] ?? null,
                        'sort_order' => $index,
                    ]);
                }
            }

            // Delete removed images
            $service->images()->whereNotIn('id', $existingIds)->each(function ($image) {
                if (file_exists(public_path($image->image))) {
                    @unlink(public_path($image->image));
                }
                $image->delete();
            });
        }

        // Add new images
        if ($request->hasFile('images')) {
            $uploadPath = 'upload/services/gallery';
            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $maxSortOrder = $service->images()->max('sort_order') ?? -1;

            foreach ($request->file('images') as $index => $file) {
                $fileName = Str::slug($validated['title']).'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($fullPath, $fileName);

                ServiceImage::create([
                    'service_id' => $service->id,
                    'image' => $uploadPath.'/'.$fileName,
                    'alt_text' => $validated['image_alt_texts'][$index] ?? null,
                    'sort_order' => $maxSortOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla güncellendi.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->featured_image && file_exists(public_path($service->featured_image))) {
            @unlink(public_path($service->featured_image));
        }

        foreach ($service->images as $image) {
            if (file_exists(public_path($image->image))) {
                @unlink(public_path($image->image));
            }
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Hizmet başarıyla silindi.');
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:services,id',
        ]);

        foreach ($validated['order'] as $index => $serviceId) {
            Service::where('id', $serviceId)->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Sıralama güncellendi.');
    }

    public function updateImage(Request $request, Service $service): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/services';
            $fileName = Str::slug($service->title).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            // Eski resmi sil
            if ($service->featured_image && file_exists(public_path($service->featured_image))) {
                @unlink(public_path($service->featured_image));
            }

            $service->update(['featured_image' => $uploadPath.'/'.$fileName]);

            return response()->json([
                'success' => true,
                'message' => 'Hizmet fotoğrafı başarıyla güncellendi.',
                'image_url' => $service->featured_image,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Fotoğraf yüklenemedi.',
        ], 400);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:services,id',
        ]);

        $services = Service::whereIn('id', $validated['ids'])->get();

        foreach ($services as $service) {
            if ($service->featured_image && file_exists(public_path($service->featured_image))) {
                @unlink(public_path($service->featured_image));
            }

            foreach ($service->images as $image) {
                if (file_exists(public_path($image->image))) {
                    @unlink(public_path($image->image));
                }
            }

            $service->delete();
        }

        $count = count($validated['ids']);

        return redirect()->route('admin.services.index')
            ->with('success', "{$count} hizmet başarıyla silindi.");
    }
}
