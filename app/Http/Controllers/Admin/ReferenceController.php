<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferenceController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $references = Reference::orderBy('sort_order')->get();

        return view('admin.references.index', compact('references'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.references.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $file = $request->file('image');
        $uploadPath = 'upload/references';
        $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

        $fullPath = public_path($uploadPath);
        if (! file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $file->move($fullPath, $fileName);
        $image = $uploadPath.'/'.$fileName;

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Reference::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        Reference::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'image' => $image,
            'client_name' => $validated['client_name'],
            'project_type' => $validated['project_type'],
            'completion_date' => $validated['completion_date'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.references.index')
            ->with('success', 'Referans başarıyla oluşturuldu.');
    }

    public function show(Reference $reference): \Illuminate\Contracts\View\View
    {
        return view('admin.references.show', compact('reference'));
    }

    public function edit(Reference $reference): \Illuminate\Contracts\View\View
    {
        return view('admin.references.edit', compact('reference'));
    }

    public function update(Request $request, Reference $reference): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'client_name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Reference::where('slug', $slug)->where('id', '!=', $reference->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'client_name' => $validated['client_name'],
            'project_type' => $validated['project_type'],
            'completion_date' => $validated['completion_date'],
            'sort_order' => $validated['sort_order'] ?? $reference->sort_order,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/references';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            if ($reference->image && file_exists(public_path($reference->image))) {
                @unlink(public_path($reference->image));
            }

            $updateData['image'] = $uploadPath.'/'.$fileName;
        }

        $reference->update($updateData);

        return redirect()->route('admin.references.index')
            ->with('success', 'Referans başarıyla güncellendi.');
    }

    public function destroy(Reference $reference): RedirectResponse
    {
        if ($reference->image && file_exists(public_path($reference->image))) {
            @unlink(public_path($reference->image));
        }

        $reference->delete();

        return redirect()->route('admin.references.index')
            ->with('success', 'Referans başarıyla silindi.');
    }
}
