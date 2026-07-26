# 🚀 Panduan Deploy GymFit ke Railway

## 📋 Prasyarat
1. Akun GitHub (https://github.com)
2. Akun Railway (https://railway.app) — daftar pake GitHub

---

## 📦 Step 1: Push Project ke GitHub

```bash
# Di terminal, jalankan:
cd gymfit-app
git init
git add .
git commit -m "Initial commit - GymFit Laravel"
git branch -M main
git remote add origin https://github.com/username-kamu/gymfit-app.git
git push -u origin main
```

> Ganti `username-kamu` dengan username GitHub Anda.

---

## 🚄 Step 2: Deploy ke Railway

1. Buka https://railway.app dan login pake GitHub
2. Klik **"New Project"** → **"Deploy from GitHub repo"**
3. Pilih repo `gymfit-app` yang baru di-push
4. Railway akan otomatis mendeteksi Laravel dan mulai build

---

## 🗄️ Step 3: Tambah Database MySQL

1. Di dashboard Railway project, klik **"New"** → **"Database"** → **"MySQL"**
2. Tunggu sampai MySQL selesai di-provision (≈30 detik)
3. Railway otomatis akan menambahkan environment variables:
   - `MYSQL_ROOT_PASSWORD`
   - `RAILWAY_TCP_PROXY_HOSTNAME_MYSQL`
   - `RAILWAY_TCP_PROXY_PORT_MYSQL`

---

## ⚙️ Step 4: Set Environment Variables

Di dashboard Railway:
1. Buka tab **"Variables"**
2. Tambahkan variable berikut:

| Variable | Value |
|----------|-------|
| `APP_KEY` | (isi dengan `base64:...` — lihat cara dapat di bawah) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://gymfit-app.up.railway.app` (ganti dengan URL project kamu) |
| `DB_CONNECTION` | `mysql` |

### Cara Dapat APP_KEY:

Jalankan di terminal lokal:
```bash
php artisan key:generate --show
```
Copy hasilnya (misal: `base64:abc123...`) dan paste ke Railway Variables sebagai `APP_KEY`

---

## 🔄 Step 5: Jalankan Migration

1. Buka tab **"Deployments"**
2. Klik **"Generate URL"** untuk dapat domain (misal: `gymfit-app.up.railway.app`)
3. Di dashboard Railway, buka tab **"Shell"**
4. Jalankan:
```bash
php artisan migrate --force
php artisan storage:link
php artisan optimize
```

---

## ✅ Selesai!

Aplikasi GymFit Anda sudah live di: `https://gymfit-app.up.railway.app`

---

## 🔧 Troubleshooting

**Error: 500 Server Error**
- Pastikan `APP_KEY` sudah di-set dengan benar
- Cek log: buka tab "Deployments" → klik deployment → lihat logs

**Error: Database Connection**
- Pastikan MySQL service sudah running
- Cek environment variables database sudah benar

**Error: 404 Not Found**
- Pastikan `.env` punya `APP_URL` yang benar
- Jalankan `php artisan route:cache` di Railway Shell

---

## 💰 Biaya

Railway memberikan **$5 credit gratis** setiap bulan — cukup untuk menjalankan Laravel + MySQL selama sebulan penuh tanpa biaya.
