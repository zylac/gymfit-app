# GymFit App

Sistem Manajemen Booking Gym & Membership berbasis **Laravel 13** dengan **Filament Admin Panel**.

## Fitur

- **Manajemen User & Role** — Admin, Personal Trainer (PT), Member via Spatie Permission
- **Manajemen Membership Plan** — CRUD paket membership dengan harga dan durasi
- **Booking Sesi PT** — Pilih paket, PT, dan jadwal dengan proteksi double booking
- **Pembayaran & Verifikasi** — Upload bukti bayar, diverifikasi Admin/PT via Filament Panel
- **Cron Job** — Pengecekan otomatis membership expired tiap jam
- **Filament Admin Panel** — Kelola booking, user, dan membership plan

## Teknologi

| Teknologi | Versi | Kegunaan |
|-----------|:-----:|----------|
| Laravel | 13.x | Framework PHP utama |
| Filament | 3.x | Admin panel |
| MariaDB | 10.x | Database |
| Tailwind CSS | 4.x | Styling UI |
| Vite | 6.x | Asset bundler |
| Alpine.js | 3.x | Interaktivitas frontend |
| Spatie Permission | 6.x | Manajemen role & permission |

## Status Booking

| Status | Keterangan |
|--------|-----------|
| `PENDING_PAYMENT` | Menunggu pembayaran |
| `AWAITING_VERIFICATION` | Bukti bayar diupload, menunggu verifikasi |
| `APPROVED` | Booking disetujui |
| `REJECTED` | Booking ditolak/dibatalkan |
| `COMPLETED` | Sesi selesai |
| `EXPIRED` | Booking kadaluarsa |

## User Roles & Hak Akses

| Fitur | Admin | PT | Member | Guest |
|:------|:-----:|:--:|:------:|:-----:|
| Registrasi & Login | ✅ | ✅ | ✅ | ✅ |
| Dashboard Member | ✅ | ✅ | ✅ | ❌ |
| Booking Sesi PT | ❌ | ❌ | ✅ | ❌ |
| Upload Pembayaran | ❌ | ❌ | ✅ | ❌ |
| Filament Admin Panel | ✅ | ✅ | ❌ | ❌ |
| Kelola User (CRUD) | ✅ | ❌ | ❌ | ❌ |
| Kelola Membership Plan | ✅ | ❌ | ❌ | ❌ |
| Verifikasi Pembayaran | ✅ | ✅ | ❌ | ❌ |

## Flowchart Aplikasi

```mermaid
flowchart TD
    Start([Mulai]) --> Home[Halaman Utama / Welcome]
    Home --> Login{Sudah Punya Akun?}
    Login -- Tidak --> Register[Halaman Registrasi]
    Register --> RegForm[Isi Nama, Email, Password]
    RegForm --> Login
    Login -- Ya --> LoginForm[Halaman Login]
    LoginForm --> InputLogin[Isi Email & Password]
    InputLogin --> Auth{Validasi Login}
    Auth -- Gagal --> LoginForm
    Auth -- Berhasil --> Dashboard[Dashboard Member]
    Dashboard --> PilihMenu{Pilih Menu}
    PilihMenu --> BookingPT[Booking Sesi PT]
    PilihMenu --> Riwayat[Riwayat Booking]
    PilihMenu --> Profile[Edit Profil]
    PilihMenu --> Logout[Logout]
    BookingPT --> PilihPlan[Pilih Paket Membership]
    PilihPlan --> PilihPT[Pilih Personal Trainer]
    PilihPT --> PilihJadwal[Pilih Jadwal/Waktu]
    PilihJadwal --> CekBooking{Cek: Ada booking aktif?}
    CekBooking -- Ya --> BookingPT
    CekBooking -- Tidak --> CekJadwal{Cek: Jadwal PT tersedia?}
    CekJadwal -- Tidak --> BookingPT
    CekJadwal -- Ya --> SimpanBooking[Booking Tersimpan]
    SimpanBooking --> StatusPending[Status: PENDING_PAYMENT]
    StatusPending --> UploadBayar[Halaman Upload Pembayaran]
    UploadBayar --> UploadBukti[Upload Foto Bukti Bayar]
    UploadBukti --> ValidasiUpload{File Valid?}
    ValidasiUpload -- Tidak --> UploadBayar
    ValidasiUpload -- Ya --> SimpanPayment[Payment Tersimpan]
    SimpanPayment --> StatusAwait[Status: AWAITING_VERIFICATION]
    StatusAwait --> AdminPanel[Admin/PT Login ke Filament Panel]
    AdminPanel --> LihatBooking[Lihat Daftar Booking]
    LihatBooking --> VerifPilih{Pilih Aksi}
    VerifPilih -- Approve --> ApproveBooking[Status: APPROVED]
    ApproveBooking --> PerpanjangMember[Perpanjang Masa Aktif Membership]
    PerpanjangMember --> SelesaiBooking[Booking Selesai]
    VerifPilih -- Reject --> RejectBooking[Status: REJECTED]
    RejectBooking --> SelesaiBooking
    UploadBayar --> BatalBooking[Batal Booking]
    BatalBooking --> StatusReject[Status: REJECTED]
    CronJob[Cron Job Setiap Jam] --> CekExpired{Cek Member Expired?}
    CekExpired -- Ya --> CatatLog[Catat di Log]
    CekExpired -- Tidak --> CronJob
    Logout --> LogoutProses[Hapus Session]
    LogoutProses --> Home
```

## Struktur Database

```
users ──┬── bookings (member_id)
         └── bookings (pt_id)
membership_plans ──┬── bookings
                    └── users
bookings ──── payments
```

Relasi: Satu member bisa punya banyak booking, satu PT bisa menangani banyak booking, satu booking punya satu pembayaran.

## Deployment

**URL:** [https://gymfit.my.id](https://gymfit.my.id)

**Akun Login (Seeder):**

| Role | Email | Password |
|:----|:------|:--------:|
| Admin | `admin@gymfit.com` | `password` |
| Trainer | `trainer@gymfit.com` | `password` |
| Member | `agung@student.com` | `password` |

**Menjalankan Lokal:**
```bash
cd gymfit-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
