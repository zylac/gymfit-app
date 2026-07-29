# 🚀 Panduan Deploy GymFit ke Wasmer Edge (GRATIS, Tanpa Kartu Kredit)

## 📋 Prasyarat
- ✅ GitHub repo: `https://github.com/zylac/gymfit-app`
- ✅ File konfigurasi Wasmer sudah di-push
- ✅ Semua asset sudah dibuild
- ✅ Routes helper sudah ditambahkan

---

## 📝 Langkah 1: Buat Akun Wasmer

1. Buka https://wasmer.io
2. Klik **"Get Started"** atau **"Sign Up"**
3. Daftar pake **GitHub** (paling gampang)
4. ✅ Akun gratis, **tanpa kartu kredit!**

---

## 🔗 Langkah 2: Deploy dari GitHub

1. Login ke https://wasmer.io
2. Klik **"New App"** → **"Deploy from GitHub"**
3. Authorize Wasmer ke GitHub kamu
4. Pilih repo: **`zylac/gymfit-app`** → branch: **`main`**
5. Klik **"Deploy"**
6. Tunggu build selesai (~2-5 menit)
7. Catat URL aplikasi (contoh: `https://gymfit-zylac.wasmer.app`)

---

## ⚙️ Langkah 3: Set Environment Variables (Secrets)

Buka **Settings > Secrets** di dashboard Wasmer, tambahkan:

```
APP_ENV=production
APP_DEBUG=false  
APP_KEY=base64:LOyiosKumzwgOLk4YHYZQYGBrFp+ZmfRs9oJeRk0SsI=
APP_URL=https://gymfit-zylac.wasmer.app    (GANTI dengan URL asli!)
DB_CONNECTION=mysql
DB_HOST=isi-dari-langkah-4
DB_PORT=3306
DB_DATABASE=gymfit
DB_USERNAME=gymfit_user
DB_PASSWORD=isi-dari-langkah-4
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
LOG_CHANNEL=stderr
PHP_CLI_SERVER_WORKERS=4
```

---

## 🗄️ Langkah 4: Buat Database

Di dashboard Wasmer:
1. Buka **Settings > Databases**
2. Klik **"Create Database"** → pilih **MySQL**
3. Catat credentials-nya
4. Masukkan ke **Secrets** (langkah 3)

### Jalanin Migration:
Buka URL di browser:
```
https://gymfit-zylac.wasmer.app/wasmer/migrate/gymfit-secret-TOKEN
```
> Tunggu sampai muncul `{"status":"ok","message":"Migration completed"}`

---

## ⏰ Langkah 5: Setup Cron (Cek Expired Member)

Buat akun gratis di **cron-job.org**, lalu buat job:
- **URL:** `https://gymfit-zylac.wasmer.app/wasmer/scheduler`
- **Schedule:** Setiap 1 jam

Ini bakal jalanin `php artisan schedule:run` yang otomatis cek member expired.

---

## ✅ Langkah 6: Verifikasi

1. Buka `https://gymfit-zylac.wasmer.app`
2. Login: `admin@gymfit.com` / `password`
3. Coba booking, upload bukti bayar, dll.

---

## 🔧 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| 500 Error | Cek Secrets dashboard → pastikan APP_KEY & DB benar |
| DB error | Migration belum jalan → akses `/wasmer/migrate/...` |
| File upload 404 | File tersimpan tapi belum bisa diakses via URL → cek route `/storage/...` |
| CSS broken | Pastikan APP_URL sesuai dengan domain Wasmer |

---

## 📁 File Konfigurasi

| File | Fungsi |
|------|--------|
| `wasmer.toml` | Konfigurasi runtime PHP di Wasmer |
| `app.yaml` | Instaboot + cron config |
| `config/php.ini` | PHP production settings |
| `.env.wasmer` | Template environment variables (jangan upload langsung!) |

---

## 🎉 Selesai!

GymFit sudah online di Wasmer Edge — GRATIS, tanpa kartu kredit! 🚀
