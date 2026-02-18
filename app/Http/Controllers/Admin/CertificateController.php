<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::ordered()->get();

        return view('admin.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png,gif,svg,webp',
                'max:2048',
            ],
        ], [
            'images.*.mimes' => 'Sadece JPEG, JPG, PNG, GIF, SVG ve WEBP formatları desteklenir.',
        ]);

        $uploadPath = 'upload/certificates';
        if (! File::exists(public_path($uploadPath))) {
            File::makeDirectory(public_path($uploadPath), 0755, true);
        }

        $maxOrder = Certificate::max('sort_order') ?? 0;
        $uploaded = 0;

        foreach ($request->file('images') as $image) {
            $extension = strtolower($image->getClientOriginalExtension());

            // SVG dosyaları için özel kontrol
            if ($extension === 'svg') {
                // SVG dosyasının içeriğini kontrol et (güvenlik için)
                $content = file_get_contents($image->getRealPath());
                if (strpos($content, '<svg') === false && strpos($content, '<?xml') === false) {
                    continue; // Geçersiz SVG dosyası
                }
            }

            $filename = time().'_'.uniqid().'.'.$extension;
            $image->move(public_path($uploadPath), $filename);

            Certificate::create([
                'image' => $uploadPath.'/'.$filename,
                'sort_order' => ++$maxOrder,
                'is_active' => true,
            ]);
            $uploaded++;
        }

        return redirect()->route('admin.certificates.index')
            ->with('success', $uploaded.' sertifika başarıyla yüklendi.');
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => [
                    'file',
                    'mimes:jpeg,jpg,png,gif,svg,webp',
                    'max:2048',
                ],
            ], [
                'image.mimes' => 'Sadece JPEG, JPG, PNG, GIF, SVG ve WEBP formatları desteklenir.',
            ]);

            // Eski resmi sil
            if ($certificate->image && File::exists(public_path($certificate->image))) {
                File::delete(public_path($certificate->image));
            }

            $uploadPath = 'upload/certificates';
            $extension = strtolower($request->file('image')->getClientOriginalExtension());

            // SVG dosyaları için özel kontrol
            if ($extension === 'svg') {
                $content = file_get_contents($request->file('image')->getRealPath());
                if (strpos($content, '<svg') === false && strpos($content, '<?xml') === false) {
                    return back()->withErrors(['image' => 'Geçersiz SVG dosyası.'])->withInput();
                }
            }

            $filename = time().'_'.uniqid().'.'.$extension;
            $request->file('image')->move(public_path($uploadPath), $filename);
            $validated['image'] = $uploadPath.'/'.$filename;
        }

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Sertifika güncellendi.');
    }

    public function destroy(Certificate $certificate)
    {
        // Resmi sil
        if ($certificate->image && File::exists(public_path($certificate->image))) {
            File::delete(public_path($certificate->image));
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Sertifika silindi.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:certificates,id',
        ]);

        $certificates = Certificate::whereIn('id', $request->ids)->get();

        foreach ($certificates as $certificate) {
            if ($certificate->image && File::exists(public_path($certificate->image))) {
                File::delete(public_path($certificate->image));
            }
            $certificate->delete();
        }

        return response()->json(['success' => true, 'message' => count($request->ids).' sertifika silindi.']);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:certificates,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Certificate::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Certificate $certificate)
    {
        $certificate->update(['is_active' => ! $certificate->is_active]);

        return back()->with('success', 'Durum güncellendi.');
    }
}
