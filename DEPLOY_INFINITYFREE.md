# 🚀 Panduan Deploy GymFit ke InfinityFree (GRATIS, Tanpa Kartu Kredit)

## 📋 Persiapan (Udah Selesai)
- ✅ Semua asset sudah dibuild (vendor, node_modules, CSS, JS)
- ✅ File `.htaccess` untuk rewrite rule
- ✅ File `database.sql` untuk import database
- ✅ File `.env.infinityfree` (tinggal rename jadi .env)
- ✅ Semua file udah di-push ke GitHub

---

## 📝 Langkah 1: Buat Akun InfinityFree

1. Buka https://infinityfree.com
2. Klik **"Get Free Hosting"**
3. Pilih paket **Free**
4. Isi form pendaftaran (email + password)
5. Login ke control panel InfinityFree

---

## 🔗 Langkah 2: Buat Database MySQL

1. Di control panel InfinityFree, cari menu **"MySQL Databases"**
2. Klik **"Create Database"**
3. Akan muncul info:
   - **Database Name:** `epiz_XXXXX_gymfit`
   - **Username:** `epiz_XXXXX`
   - **Password:** `[password yang kamu buat]`
   - **Host:** `sqlXXX.infinityfree.com`
4. **CATAT INFO INI!** — nanti dipakai di .env

---

## ⚙️ Langkah 3: Import Database

1. Di control panel, cari **phpMyAdmin**
2. Login pake credentials database tadi
3. Klik database kamu di sebelah kiri
4. Klik tab **"Import"**
5. Klik **"Choose File"** → pilih `database.sql` (dari project ini)
6. Klik **"Go"** — tunggu sampai selesai ✅

---

## 📁 Langkah 4: Upload File via FTP

Kamu butuh **FTP Client** — misal **FileZilla** (free).

1. Di control panel InfinityFree, cari **"FTP Accounts"**
2. Catat:
   - **FTP Server:** `ftpupload.net`
   - **Username:** `epiz_XXXXX`
   - **Password:** password akun InfinityFree-mu
   - **Port:** 21

3. Buka FileZilla → isi data di atas → **Quickconnect**

4. **Upload SEMUA file dan folder** dari folder `gymfit-app/` ke folder `/htdocs/` di InfinityFree

> ⚠️ **File yang WAJIB ada:**
> - `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`, `storage/`, `vendor/`, `lang/`
> - `.env` (copy dari `.env.infinityfree`)
> - `.htaccess` (copy dari `htaccess.infinityfree.txt` → rename jadi `.htaccess`)
> - `composer.json`, `composer.lock`, `package.json`

> ⚠️ **Yang TIDAK perlu diupload:**
> - `node_modules/` (jangan upload! ribuan file, boros quota)
> - Folder `.git/`
> - File `.env.*` selain `.env`
> - `database.sql` (udah diimport via phpMyAdmin)

---

## 🔧 Langkah 5: Buat File .env

1. Copy file `.env.infinityfree` → rename jadi `.env`
2. Isi dengan credentials database dari Langkah 2:
```
DB_HOST=sqlXXX.infinityfree.com   (GANTI sesuai database kamu)
DB_DATABASE=epiz_XXXXX_gymfit     (GANTI)
DB_USERNAME=epiz_XXXXX            (GANTI)
DB_PASSWORD=password_kamu         (GANTI)
```

3. Upload file `.env` ini ke `/htdocs/`

---

## 🌐 Langkah 6: Buat .htaccess

1. Copy file `htaccess.infinityfree.txt` → rename jadi `.htaccess`
2. Upload ke `/htdocs/`

---

## ✅ Langkah 7: Verifikasi

1. Buka website kamu: `https://gymfit.epizy.com` (cek di control panel)
2. Login:
   - **Admin:** `admin@gymfit.com` / `password`
   - **Trainer:** `trainer@gymfit.com` / `password`
   - **Member:** `agung@student.com` / `password`
3. Coba booking, upload bukti bayar, dll.

---

## 🔧 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| **500 Error** | Cek file `.env` — pastikan DB credentials benar |
| **Halaman kosong putih** | Aktifkan error: tambah `ini_set('display_errors', 1);` di `public/index.php` untuk debug |
| **CSS/JS broken** | Cek `.htaccess` sudah benar di `/htdocs/` |
| **Database error** | Import ulang `database.sql` via phpMyAdmin |
| **File upload error** | Cek folder `storage/app/public` ada dan writable |

---

## 🎉 SELESAI!

GymFit kamu sudah online di InfinityFree! 🚀

📧 **Email:** admin@gymfit.com
🔑 **Password:** password
