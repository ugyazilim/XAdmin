<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $sliders = Slider::orderBy('sort_order')->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'media_type' => 'required|in:image,video',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ];

        if ($request->input('media_type') === 'image') {
            $rules['image'] = 'required|image|max:2048';
            $rules['mobile_image'] = 'nullable|image|max:2048';
        } else {
            $rules['video'] = 'required|mimes:mp4,webm,ogg|max:10240';
        }

        $validated = $request->validate($rules);

        $image = null;
        $mobileImage = null;
        $video = null;

        if ($validated['media_type'] === 'image') {
            $image = $this->uploadImage($request->file('image'));
            $mobileImage = $request->hasFile('mobile_image')
                ? $this->uploadImage($request->file('mobile_image'))
                : null;
        } else {
            $video = $this->uploadVideo($request->file('video'));
        }

        $maxOrder = Slider::max('sort_order') ?? 0;

        Slider::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'image' => $image,
            'mobile_image' => $mobileImage,
            'video' => $video,
            'media_type' => $validated['media_type'],
            'link' => $validated['link'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'sort_order' => $maxOrder + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla oluşturuldu.');
    }

    public function show(Slider $slider): \Illuminate\Contracts\View\View
    {
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider): \Illuminate\Contracts\View\View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'media_type' => 'required|in:image,video',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ];

        if ($request->input('media_type') === 'image') {
            // Media type değiştiyse veya yeni resim yükleniyorsa required
            if ($slider->media_type !== 'image' || $request->hasFile('image')) {
                $rules['image'] = 'required|image|max:2048';
            } else {
                $rules['image'] = 'nullable|image|max:2048';
            }
            $rules['mobile_image'] = 'nullable|image|max:2048';
        } else {
            // Media type değiştiyse veya yeni video yükleniyorsa required
            if ($slider->media_type !== 'video' || $request->hasFile('video')) {
                $rules['video'] = 'required|mimes:mp4,webm,ogg|max:10240';
            } else {
                $rules['video'] = 'nullable|mimes:mp4,webm,ogg|max:10240';
            }
        }

        $validated = $request->validate($rules);

        $updateData = [
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'media_type' => $validated['media_type'],
            'link' => $validated['link'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        // Media type değiştiyse eski medyayı sil
        if ($validated['media_type'] !== $slider->media_type) {
            if ($slider->media_type === 'image') {
                $this->deleteImage($slider->image);
                $this->deleteImage($slider->mobile_image);
                $updateData['image'] = null;
                $updateData['mobile_image'] = null;
            } else {
                $this->deleteVideo($slider->video);
                $updateData['video'] = null;
            }
        }

        if ($validated['media_type'] === 'image') {
            if ($request->hasFile('image')) {
                $this->deleteImage($slider->image);
                $updateData['image'] = $this->uploadImage($request->file('image'));
            }

            if ($request->hasFile('mobile_image')) {
                $this->deleteImage($slider->mobile_image);
                $updateData['mobile_image'] = $this->uploadImage($request->file('mobile_image'));
            }
        } else {
            if ($request->hasFile('video')) {
                $this->deleteVideo($slider->video);
                $updateData['video'] = $this->uploadVideo($request->file('video'));
            }
        }

        $slider->update($updateData);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla güncellendi.');
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $this->deleteImage($slider->image);
        $this->deleteImage($slider->mobile_image);
        $this->deleteVideo($slider->video);

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla silindi.');
    }

    public function updateOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $orders = $request->input('orders', []);

        foreach ($orders as $index => $sliderId) {
            Slider::where('id', $sliderId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Sıralama güncellendi.']);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:sliders,id',
        ]);

        $sliders = Slider::whereIn('id', $validated['ids'])->get();

        foreach ($sliders as $slider) {
            $this->deleteImage($slider->image);
            $this->deleteImage($slider->mobile_image);
            $this->deleteVideo($slider->video);
            $slider->delete();
        }

        $count = count($validated['ids']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$count} slider başarıyla silindi.",
            ]);
        }

        return redirect()->route('admin.sliders.index')
            ->with('success', "{$count} slider başarıyla silindi.");
    }

    private function uploadImage($file): string
    {
        $imageName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $imagePath = 'upload/sliders/';

        if (! File::exists(public_path($imagePath))) {
            File::makeDirectory(public_path($imagePath), 0755, true);
        }

        $file->move(public_path($imagePath), $imageName);

        return $imagePath.$imageName;
    }

    private function deleteImage(?string $imagePath): void
    {
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }

    private function uploadVideo($file): string
    {
        $videoName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $videoPath = 'upload/sliders/videos/';

        if (! File::exists(public_path($videoPath))) {
            File::makeDirectory(public_path($videoPath), 0755, true);
        }

        $file->move(public_path($videoPath), $videoName);

        return $videoPath.$videoName;
    }

    private function deleteVideo(?string $videoPath): void
    {
        if ($videoPath && File::exists(public_path($videoPath))) {
            File::delete(public_path($videoPath));
        }
    }
}
