<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI'lar
        $kpis = [
            'total_categories' => Category::count(),
            'total_projects' => Project::count(),
            'total_references' => Reference::count(),
            'total_news' => News::count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'published_projects' => Project::where('is_published', true)->count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
            'new_contacts' => Contact::where('status', 'new')->count(),
            'total_contacts' => Contact::count(),
        ];

        // Son projeler
        $recentProjects = Project::with('category')
            ->latest()
            ->take(10)
            ->get();

        // Son referanslar
        $recentReferences = Reference::latest()
            ->take(5)
            ->get();

        // Son haberler/duyurular
        $recentNews = News::latest()
            ->take(5)
            ->get();

        // Son iletişim mesajları
        $recentContacts = Contact::latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'kpis',
            'recentProjects',
            'recentReferences',
            'recentNews',
            'recentContacts'
        ));
    }
}
