<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes - Kurumsal Site (Tema eklenecek)
|--------------------------------------------------------------------------
*/

// Ana Sayfa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hakkımızda
Route::get('/hakkimizda', [HomeController::class, 'about'])->name('about');
Route::get('/vizyon', [HomeController::class, 'vision'])->name('vision');
Route::get('/misyon', [HomeController::class, 'mission'])->name('mission');

// Projelerimiz
Route::get('/projelerimiz', [HomeController::class, 'projects'])->name('projects');
Route::get('/projelerimiz/{slug}', [HomeController::class, 'showProject'])->name('projects.show');

// Referanslar
Route::get('/referanslar', [HomeController::class, 'references'])->name('references');

// İletişim
Route::get('/iletisim', [HomeController::class, 'contact'])->name('contact');
Route::post('/iletisim', [HomeController::class, 'contactStore'])->name('contact.store');
Route::post('/iletisim/submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Hizmetlerimiz Ana Sayfa
Route::get('/hizmetlerimiz', [HomeController::class, 'services'])->name('services');

// Hizmetler - Önce spesifik route'lar (backward compatibility)
Route::prefix('hizmetlerimiz')->name('services.')->group(function () {
    // Eski route'lar (spesifik route'lar önce olmalı)
    Route::get('/celik-kapi', [HomeController::class, 'steelDoors'])->name('steel-doors');
    Route::get('/pvc-kapi', [HomeController::class, 'pvcDoors'])->name('pvc-doors');
    Route::get('/aluminyum-dusakabin', [HomeController::class, 'showerCabins'])->name('shower-cabins');
    Route::get('/mobilya', [HomeController::class, 'furniture'])->name('furniture');
    Route::get('/isi-yalitim', [HomeController::class, 'insulation'])->name('insulation');
    Route::get('/izocam', [HomeController::class, 'isocam'])->name('isocam');

    // Dinamik route en sonda (catch-all)
    Route::get('/{slug}', [HomeController::class, 'showService'])->name('show');
});

// E-Catalog
Route::get('/product-catalog', [HomeController::class, 'catalog'])->name('catalog');

// Haberler/Blog
Route::get('/haberler', [HomeController::class, 'news'])->name('news');
Route::get('/haberler/{slug}', [HomeController::class, 'showNews'])->name('news.show');

// Arama
Route::get('/arama', [HomeController::class, 'search'])->name('search');

// Authentication Routes (Admin Login)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes - Yönetim Paneli
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori Yönetimi (Proje Kategorileri)
    Route::resource('categories', CategoryController::class);
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');
    Route::post('categories/{category}/quick-update', [CategoryController::class, 'quickUpdate'])->name('categories.quick-update');
    Route::post('categories/{category}/update-image', [CategoryController::class, 'updateImage'])->name('categories.update-image');

    // Proje Yönetimi
    Route::resource('projects', ProjectController::class);
    Route::post('projects/update-order', [ProjectController::class, 'updateOrder'])->name('projects.update-order');

    // Referans Yönetimi
    Route::resource('references', ReferenceController::class);
    Route::post('references/update-order', [ReferenceController::class, 'updateOrder'])->name('references.update-order');

    // Hizmet Yönetimi
    Route::resource('services', ServiceController::class);
    Route::post('services/update-order', [ServiceController::class, 'updateOrder'])->name('services.update-order');
    Route::post('services/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('services.bulk-delete');
    Route::post('services/{service}/update-image', [ServiceController::class, 'updateImage'])->name('services.update-image');

    // Haber/Duyuru Yönetimi
    Route::resource('news', NewsController::class);
    Route::post('news/{news}/update-image', [NewsController::class, 'updateImage'])->name('news.update-image');

    // Slider Yönetimi
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');
    Route::post('sliders/bulk-delete', [SliderController::class, 'bulkDelete'])->name('sliders.bulk-delete');

    // Sertifika Yönetimi
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::put('certificates/{certificate}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::delete('certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
    Route::post('certificates/bulk-delete', [CertificateController::class, 'bulkDelete'])->name('certificates.bulk-delete');
    Route::post('certificates/update-order', [CertificateController::class, 'updateOrder'])->name('certificates.update-order');
    Route::post('certificates/{certificate}/toggle-status', [CertificateController::class, 'toggleStatus'])->name('certificates.toggle-status');

    // İletişim Yönetimi
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'update', 'destroy']);

    // Sayfa Yönetimi
    Route::resource('pages', AdminPageController::class);
    Route::post('pages/{page}/toggle-publish', [AdminPageController::class, 'togglePublish'])->name('pages.toggle-publish');
    Route::post('pages/bulk-delete', [AdminPageController::class, 'bulkDelete'])->name('pages.bulk-delete');

    // SSS Yönetimi
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::post('faqs/update-order', [FaqController::class, 'updateOrder'])->name('faqs.update-order');

    // Kullanıcı Yönetimi (Admin/Staff)
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Ayarlar
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
        Route::post('/{group}', [SettingController::class, 'updateGroup'])->name('update-group');
        Route::post('/toggle-maintenance', [SettingController::class, 'toggleMaintenance'])->name('toggle-maintenance');
    });

});
