<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Oba Ticaret - Kurumsal Web Sitesi
 * Merkezi Veritabanı Yapısı
 *
 * Foreign Key kullanılmadan, ID referansları ile tasarlanmıştır.
 * Tüm tablolar bu tek migration dosyasında yönetilir.
 */
return new class extends Migration
{
    public function up(): void
    {
        // =====================================================================
        // 2.1 PROJE KATEGORİLERİ
        // =====================================================================

        // Categories - Proje Kategorileri
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index('slug');
            $table->index('parent_id');
            $table->index(['status', 'sort_order']);
        });

        // =====================================================================
        // 2.2 KULLANICI YÖNETİMİ
        // =====================================================================

        // Users - Tüm Kullanıcılar (Admin, Staff, Customer)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'staff', 'customer'])->default('customer');
            $table->boolean('is_active')->default(true);

            // Sosyal Giriş (Google, Facebook)
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();

            // Müşteri Bilgileri
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->index(['email', 'role']);
            $table->index('phone');
            $table->index(['provider', 'provider_id']);
        });

        // Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // =====================================================================
        // 2.3 KURUMSAL VE İÇERİK YÖNETİMİ
        // =====================================================================

        // Pages - Sayfalar (Hakkımızda, İletişim vb.)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('template')->default('default'); // default, contact
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
        });

        // FAQs - Sıkça Sorulan Sorular
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->nullable(); // sipariş, teslimat, ödeme, genel
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
        });

        // Certificates - Sertifikalar / Partner Logoları
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // Sliders - Ana Sayfa Slider
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image');
            $table->string('mobile_image')->nullable();
            $table->string('link')->nullable();
            $table->string('button_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // =====================================================================
        // 2.4 SİSTEM VE LOG YÖNETİMİ
        // =====================================================================

        // Settings - Genel Sistem Ayarları
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['group', 'key']);
        });

        // Logs - Sistem Logları
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action'); // create, update, delete, login, logout, vb.
            $table->string('model')->nullable(); // Model adı
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at');

            $table->index('user_id');
            $table->index(['model', 'model_id']);
            $table->index('action');
            $table->index('created_at');
        });

        // Notifications - Bildirimler
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // order, promotion, system
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index(['user_id', 'read_at']);
        });

        // =====================================================================
        // LARAVEL CORE TABLOLAR
        // =====================================================================

        // Cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // Jobs Queue
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        // Laravel Core
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');

        // Sistem
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('settings');

        // İçerik
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('pages');

        // Kullanıcı
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');

        // Kategori
        Schema::dropIfExists('categories');
    }
};
