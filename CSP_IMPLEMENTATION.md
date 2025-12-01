# Content Security Policy (CSP) Implementation

## ✅ Sudah Terpasang

CSP middleware telah terpasang di aplikasi untuk melindungi dari serangan XSS, data injection, dan clickjacking.

## 🔒 Proteksi Yang Aktif

1. **XSS Protection** - Script berbahaya akan diblokir
2. **Data Injection Prevention** - Hanya resource dari domain sendiri yang bisa dimuat
3. **Clickjacking Protection** - Aplikasi tidak bisa di-embed di iframe eksternal
4. **SQL Injection Protection** - PDO menggunakan prepared statements

## 🛠️ PDO Security Options

Database MySQL sudah dikonfigurasi dengan:
```php
PDO::ATTR_EMULATE_PREPARES => false      // Real prepared statements
PDO::ATTR_STRINGIFY_FETCHES => false     // Keep data types
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // Exception on errors
```

## 📝 Cara Menggunakan Inline Scripts

### ❌ SALAH (akan diblokir CSP):
```blade
<script>
    console.log('Hello World');
</script>
```

### ✅ BENAR (gunakan @nonce directive):
```blade
<script @nonce>
    console.log('Hello World');
</script>
```

## 🔧 Konfigurasi Environment

### Development (Local):
```env
APP_ENV=local
```
- Vite dev server (localhost:5173) diizinkan
- `unsafe-eval` aktif untuk Alpine.js

### Production (Shared Hosting):
```env
APP_ENV=production
```
- Hanya resource dari domain sendiri
- Lebih strict security

## 📋 CSP Headers Yang Aktif

| Directive | Value | Fungsi |
|-----------|-------|--------|
| default-src | 'self' | Default: hanya dari domain sendiri |
| script-src | 'self' 'nonce-xxx' | Script dengan nonce atau dari domain sendiri |
| style-src | 'self' 'unsafe-inline' | Styling (Tailwind perlu unsafe-inline) |
| img-src | 'self' data: https: | Gambar dari domain sendiri atau data URI |
| connect-src | 'self' | Fetch/AJAX hanya ke domain sendiri |
| frame-ancestors | 'self' | Tidak bisa di-iframe eksternal |
| form-action | 'self' | Form submit hanya ke domain sendiri |

## 🚀 Testing CSP

### Cek di Browser Console:
Jika CSP memblokir sesuatu, akan muncul error:
```
Refused to execute inline script because it violates the following 
Content Security Policy directive: "script-src 'self' 'nonce-xxx'"
```

### Solusi:
Tambahkan `@nonce` ke script yang diblokir.

## 📄 File Yang Dimodifikasi

1. **app/Http/Middleware/ContentSecurityPolicy.php** - CSP Middleware
2. **bootstrap/app.php** - Register middleware
3. **app/Providers/AppServiceProvider.php** - Blade @nonce directive
4. **config/database.php** - PDO security options
5. **resources/views/layouts/app.blade.php** - Contoh penggunaan

## ⚠️ Important Notes

- File JavaScript eksternal seperti `public/js/adjudicator-reviews.js` **tidak perlu nonce** karena dimuat via `<script src>`
- Hanya **inline scripts** (`<script>...</script>`) yang perlu `@nonce`
- Alpine.js perlu `unsafe-eval` (sudah dikonfigurasi)
- Tailwind perlu `unsafe-inline` untuk styles (sudah dikonfigurasi)

## 🔄 Deploy ke Production

```bash
# Di local
npm run build

# Upload ke server:
# - Semua file aplikasi
# - Folder public/build/
# - Set .env: APP_ENV=production
```

CSP akan otomatis lebih ketat di production (tanpa localhost:5173).
