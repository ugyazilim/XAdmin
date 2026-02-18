<?php

return [
    // Ana Menü
    'dashboard' => 'Kontrol Paneli',
    'categories' => 'Kategoriler',
    'products' => 'Ürünler',
    'orders' => 'Siparişler',
    'branches' => 'Şubeler',
    'customers' => 'Müşteriler',
    'promotions' => 'Kampanyalar',
    'coupons' => 'Kuponlar',
    'sliders' => 'Slider',
    'pages' => 'Sayfalar',
    'reviews' => 'Yorumlar',
    'reports' => 'Raporlar',
    'settings' => 'Ayarlar',
    'users' => 'Kullanıcılar',

    // Genel Eylemler
    'create' => 'Oluştur',
    'edit' => 'Düzenle',
    'delete' => 'Sil',
    'save' => 'Kaydet',
    'update' => 'Güncelle',
    'cancel' => 'İptal',
    'back' => 'Geri',
    'view' => 'Görüntüle',
    'search' => 'Ara',
    'filter' => 'Filtrele',
    'export' => 'Dışa Aktar',
    'import' => 'İçe Aktar',
    'print' => 'Yazdır',
    'close' => 'Kapat',
    'confirm' => 'Onayla',
    'approve' => 'Onayla',
    'reject' => 'Reddet',
    'send' => 'Gönder',
    'add' => 'Ekle',
    'remove' => 'Kaldır',

    // Genel Alanlar
    'name' => 'Ad',
    'slug' => 'URL Kodu',
    'title' => 'Başlık',
    'description' => 'Açıklama',
    'content' => 'İçerik',
    'image' => 'Görsel',
    'images' => 'Görseller',
    'status' => 'Durum',
    'active' => 'Aktif',
    'inactive' => 'Pasif',
    'enabled' => 'Açık',
    'disabled' => 'Kapalı',
    'price' => 'Fiyat',
    'stock' => 'Stok',
    'visible' => 'Görünür',
    'hidden' => 'Gizli',
    'date' => 'Tarih',
    'time' => 'Saat',
    'created_at' => 'Oluşturulma',
    'updated_at' => 'Güncellenme',
    'sort_order' => 'Sıra',
    'phone' => 'Telefon',
    'email' => 'E-posta',
    'address' => 'Adres',
    'city' => 'Şehir',
    'district' => 'İlçe',
    'note' => 'Not',
    'notes' => 'Notlar',

    // Sipariş Durumları
    'order_status' => [
        'pending' => 'Beklemede',
        'confirmed' => 'Onaylandı',
        'preparing' => 'Hazırlanıyor',
        'ready' => 'Hazır',
        'on_way' => 'Yolda',
        'delivered' => 'Teslim Edildi',
        'completed' => 'Tamamlandı',
        'cancelled' => 'İptal Edildi',
        'refunded' => 'İade Edildi',
    ],

    // Sipariş Tipleri
    'order_type' => [
        'delivery' => 'Paket Servis',
        'pickup' => 'Gel-Al',
        'dine_in' => 'Restoranda',
    ],

    // Ödeme Durumları
    'payment_status' => [
        'pending' => 'Beklemede',
        'completed' => 'Tamamlandı',
        'failed' => 'Başarısız',
        'refunded' => 'İade Edildi',
    ],

    // Ödeme Yöntemleri
    'payment_method' => [
        'cash' => 'Nakit',
        'card' => 'Kredi Kartı',
        'online' => 'Online Ödeme',
    ],

    // Başarı Mesajları
    'success' => [
        'created' => ':item başarıyla oluşturuldu.',
        'updated' => ':item başarıyla güncellendi.',
        'deleted' => ':item başarıyla silindi.',
        'saved' => 'Değişiklikler kaydedildi.',
        'status_changed' => 'Durum güncellendi.',
    ],

    // Hata Mesajları
    'error' => [
        'general' => 'Bir hata oluştu. Lütfen tekrar deneyin.',
        'not_found' => ':item bulunamadı.',
        'cannot_delete' => ':item silinemez.',
        'has_relations' => 'Bu kayda bağlı veriler bulunmaktadır.',
    ],

    // Onay Mesajları
    'confirm_delete' => 'Bu kaydı silmek istediğinize emin misiniz?',
    'confirm_cancel' => 'Bu işlemi iptal etmek istediğinize emin misiniz?',

    // Diğer
    'no_data' => 'Veri bulunamadı.',
    'loading' => 'Yükleniyor...',
    'select' => 'Seçiniz',
    'all' => 'Tümü',
    'today' => 'Bugün',
    'yesterday' => 'Dün',
    'this_week' => 'Bu Hafta',
    'this_month' => 'Bu Ay',
    'total' => 'Toplam',
    'subtotal' => 'Ara Toplam',
    'discount' => 'İndirim',
    'delivery_fee' => 'Teslimat Ücreti',
    'grand_total' => 'Genel Toplam',
];
