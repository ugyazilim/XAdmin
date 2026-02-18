<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $projects = Project::with('category')
            ->orderBy('sort_order')
            ->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|max:2048',
            'location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'client_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/projects';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);
            $image = $uploadPath.'/'.$fileName;
        }

        $gallery = [];
        if ($request->hasFile('gallery')) {
            $uploadPath = 'upload/projects/gallery';
            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            foreach ($request->file('gallery') as $file) {
                $fileName = Str::slug($validated['title']).'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($fullPath, $fileName);
                $gallery[] = $uploadPath.'/'.$fileName;
            }
        }

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        Project::create([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'content' => $validated['content'],
            'image' => $image,
            'gallery' => $gallery,
            'location' => $validated['location'],
            'project_date' => $validated['project_date'],
            'client_name' => $validated['client_name'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proje başarıyla oluşturuldu.');
    }

    public function show(Project $project): \Illuminate\Contracts\View\View
    {
        $project->load('category');

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project): \Illuminate\Contracts\View\View
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|max:2048',
            'location' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'client_name' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Slug'ı otomatik oluştur ve unique olduğundan emin ol
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $updateData = [
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'content' => $validated['content'],
            'location' => $validated['location'],
            'project_date' => $validated['project_date'],
            'client_name' => $validated['client_name'],
            'sort_order' => $validated['sort_order'] ?? $project->sort_order,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadPath = 'upload/projects';
            $fileName = Str::slug($validated['title']).'-'.time().'.'.$file->getClientOriginalExtension();

            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $file->move($fullPath, $fileName);

            if ($project->image && file_exists(public_path($project->image))) {
                @unlink(public_path($project->image));
            }

            $updateData['image'] = $uploadPath.'/'.$fileName;
        }

        if ($request->hasFile('gallery')) {
            $uploadPath = 'upload/projects/gallery';
            $fullPath = public_path($uploadPath);
            if (! file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $gallery = $project->gallery ?? [];
            foreach ($request->file('gallery') as $file) {
                $fileName = Str::slug($validated['title']).'-'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($fullPath, $fileName);
                $gallery[] = $uploadPath.'/'.$fileName;
            }
            $updateData['gallery'] = $gallery;
        }

        $project->update($updateData);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proje başarıyla güncellendi.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image && file_exists(public_path($project->image))) {
            @unlink(public_path($project->image));
        }

        if ($project->gallery) {
            foreach ($project->gallery as $image) {
                if (file_exists(public_path($image))) {
                    @unlink(public_path($image));
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Proje başarıyla silindi.');
    }
}
