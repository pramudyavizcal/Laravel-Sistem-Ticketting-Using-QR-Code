QR E-Ticket Multifungsi - Panduan Setup Awal
============================================

Dokumen ini berisi langkah setup project dari awal sampai fitur utama berjalan:
landing page event, admin panel, CRUD event, upload banner, pendaftaran peserta,
approval tiket, email, pembayaran manual/Xendit, QR ticket, scanner, dan scan log.


1. Requirement
--------------

Pastikan komputer/server sudah memiliki:

- PHP 8.2 atau lebih baru
- Composer
- MySQL/MariaDB atau SQLite
- Git
- Web server lokal seperti Laragon/XAMPP, atau gunakan `php artisan serve`

Ekstensi PHP yang disarankan aktif:

- openssl
- pdo_mysql atau pdo_sqlite
- mbstring
- tokenizer
- xml
- ctype
- json
- fileinfo
- gd
- zip

Cek versi:

    php -v
    composer -V
3. Install Dependency Backend
-----------------------------

Jalankan:

    composer install


4. Buat File .env
-----------------
Lalu edit `.env`.

Contoh konfigurasi lokal dengan MySQL/Laragon:

    APP_NAME="QR E-Ticket"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://localhost:8000
    APP_LOCALE=id
    APP_FALLBACK_LOCALE=id

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=qr_eticket
    DB_USERNAME=root
    DB_PASSWORD=

    SESSION_DRIVER=database
    CACHE_STORE=database
    QUEUE_CONNECTION=database
    FILESYSTEM_DISK=public

    MAIL_MAILER=log
    MAIL_FROM_ADDRESS="no-reply@qreticket.local"
    MAIL_FROM_NAME="${APP_NAME}"

    XENDIT_SECRET_KEY=
    XENDIT_CALLBACK_TOKEN=

Catatan:

- Jangan commit file `.env` ke repository.
- Untuk local pertama kali, `MAIL_MAILER=log` cukup. Email akan masuk ke `storage/logs/laravel.log`.
- Jika memakai SQLite, gunakan `DB_CONNECTION=sqlite` dan buat file `database/database.sqlite`.


5. Buat Database
----------------

Jika memakai MySQL/Laragon:

1. Buka phpMyAdmin atau HeidiSQL.
2. Buat database baru:

       qr_eticket

3. Pastikan nama database sama dengan `DB_DATABASE` di `.env`. lalu import db .sql nya


6. Generate APP_KEY
-------------------

Jalankan:

    php artisan key:generate


7. Migrasi Database dan Seeder
------------------------------

Untuk setup awal bersih:

    php artisan migrate:fresh --seed

Seeder akan membuat akun:

    Admin:
    email    : admin@qreticket.id
    password : admin123

    Staff:
    email    : staff@qreticket.id
    password : staff123

Jika tidak ingin menghapus data lama, gunakan:

    php artisan migrate
    php artisan db:seed


8. Buat Storage Link
--------------------

Wajib untuk upload banner event, logo event, dan bukti pembayaran.

    php artisan storage:link

Setelah itu file upload di `storage/app/public` bisa diakses lewat URL `/storage/...`.

Jika gambar tidak tampil, cek:

- `FILESYSTEM_DISK=public`
- folder `public/storage` sudah ada
- file benar-benar tersimpan di `storage/app/public`


9. Bersihkan Cache Konfigurasi
-------------------------------

Setelah mengubah `.env`, jalankan:

    php artisan optimize:clear

Untuk production setelah konfigurasi final:

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache


10. Jalankan Project Lokal
--------------------------

Terminal 1:

    php artisan serve

Buka:

    http://localhost:8000

Jika memakai queue database, jalankan terminal 3:

    php artisan queue:work

11. Login Admin
---------------

Buka:

    http://localhost:8000/login

Gunakan:

    admin@qreticket.id
    admin123

Setelah masuk, admin bisa mengakses:

- Dashboard
- Data Event
- Data Peserta
- Scanner QR
- Scan Log
- Profile


12. Buat Event dari Admin Panel
-------------------------------

Masuk ke:

    Admin Panel -> Event -> Tambah Event

Isi data minimal:

- Nama event
- Tipe event: wisuda, seminar, konser, atau workshop
- Deskripsi
- Venue/lokasi
- Tanggal event
- Jam event
- Kuota
- Organizer
- Theme color
- Status aktif
- Banner event

Jika event gratis:

- Matikan opsi event berbayar.

Jika event berbayar:

- Aktifkan event berbayar.
- Isi harga.
- Jika pakai transfer manual, isi:
  - Nama bank
  - Nomor rekening
  - Nama pemilik rekening
- Jika pakai Xendit, aktifkan opsi Xendit dan isi konfigurasi Xendit di `.env`.

Pastikan event aktif dan tanggal event belum lewat. Landing page hanya menampilkan event aktif yang tanggalnya masih berjalan/akan datang.


13. Cek Landing Page
--------------------

Buka:

    http://localhost:8000

Yang perlu dicek:

- Slider hero mengambil event aktif dari admin.
- Banner event tampil dari upload admin.
- Event terbaru tampil 3 kolom x 3 baris per halaman.
- Jika ada lebih dari 9 event, event lama bergeser ke halaman berikutnya.
- Search event bekerja lewat kolom pencarian navbar.
- Tombol pagination dan panah halaman bekerja.


14. Alur Pendaftaran Peserta
----------------------------

Dari landing page:

1. Klik salah satu event.
2. Isi form pendaftaran.
3. Submit pendaftaran.

Jika event gratis:

- Peserta diarahkan ke halaman menunggu konfirmasi.
- Admin harus approve dari menu Peserta.
- Setelah approve, tiket QR dibuat dan email tiket dikirim.

Jika event berbayar manual:

- Peserta diarahkan ke halaman instruksi pembayaran.
- Peserta upload bukti pembayaran.
- Admin cek bukti dari menu Peserta.
- Admin approve peserta.
- Status pembayaran menjadi paid.
- Tiket QR dibuat dan email tiket dikirim.

Jika event berbayar Xendit:

- Peserta diarahkan ke invoice/payment link Xendit.
- Setelah pembayaran sukses, webhook Xendit mengubah status menjadi approved dan paid.
- Tiket QR dikirim otomatis jika email aktif.


15. Setup Email
---------------

Fitur email dipakai untuk:

- konfirmasi pendaftaran
- pengiriman tiket QR setelah approval
- notifikasi penolakan atau status pendaftaran

Mode paling aman untuk local development adalah `log`.

    MAIL_MAILER=log

Kalau memakai mode ini, email tidak benar-benar dikirim ke inbox. Isi email akan masuk ke:

    storage/logs/laravel.log

Ini cocok untuk testing tanpa takut mengirim email asli.

Kalau ingin email benar-benar terkirim, ganti ke SMTP. Contoh jika menggunakan Mailtrap:

    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=ISI_USERNAME_MAILTRAP
    MAIL_PASSWORD=ISI_PASSWORD_MAILTRAP
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="no-reply@qreticket.local"
    MAIL_FROM_NAME="${APP_NAME}"

Contoh SMTP Gmail:

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=alamat@gmail.com
    MAIL_PASSWORD=APP_PASSWORD_GMAIL
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="alamat@gmail.com"
    MAIL_FROM_NAME="${APP_NAME}"

Cara pakai:

1. Isi konfigurasi mail di `.env`.
2. Jalankan `php artisan optimize:clear`.
3. Buat pendaftaran peserta.
4. Approve dari admin.
5. Cek apakah email tiket masuk ke inbox atau ke log.

Catatan penting:

- Jika pakai Gmail, gunakan App Password, bukan password akun biasa.
- Pastikan `MAIL_FROM_ADDRESS` valid agar mail tidak ditolak provider.

Setelah mengubah konfigurasi email:

    php artisan optimize:clear

16. Setup Xendit
----------------

Xendit dipakai untuk event berbayar kalau ingin peserta membayar lewat invoice/payment link.

Isi `.env`:

    XENDIT_SECRET_KEY=xnd_development_...
    XENDIT_CALLBACK_TOKEN=token_rahasia_yang_sama_dengan_dashboard_xendit

Pastikan `config/services.php` membaca key:

    xendit.key
    xendit.callback_token

Alur pakai:

1. Aktifkan event berbayar.
2. Aktifkan opsi Xendit di form event.
3. Isi `XENDIT_SECRET_KEY` dan `XENDIT_CALLBACK_TOKEN`.
4. Peserta daftar event dan klik bayar via Xendit.
5. Xendit membuat invoice/payment link.
6. Setelah pembayaran sukses, webhook akan mengubah status peserta menjadi `approved` dan `paid`.
7. Tiket QR bisa dikirim otomatis jika email aktif.

Setelah mengubah `.env`:

    php artisan optimize:clear

Untuk testing webhook lokal, gunakan tunnel seperti ngrok:

    ngrok http 8000

Ambil URL HTTPS dari ngrok, lalu set webhook invoice di dashboard Xendit ke:

    https://URL-NGROK/api/webhooks/xendit

Header callback token di Xendit harus sama persis dengan `XENDIT_CALLBACK_TOKEN`.

Alur uji:

1. Buat event berbayar.
2. Aktifkan opsi Xendit.
3. Daftar sebagai peserta.
4. Klik bayar via Xendit.
5. Selesaikan simulasi pembayaran.
6. Pastikan peserta menjadi approved dan paid.
7. Pastikan tiket muncul/terkirim.


17. QR Ticket dan Scanner
-------------------------

Setelah peserta approved:

- Sistem membuat kode tiket.
- Halaman tiket menampilkan QR code.
- Email tiket berisi informasi tiket.

Untuk scan:

1. Login admin/staff.
2. Buka:

       Admin Panel -> Scanner QR

3. Pilih event jika diperlukan.
4. Izinkan akses kamera browser.
5. Arahkan kamera ke QR tiket.
6. Jika valid, peserta ditandai check-in.
7. Hasil scan tersimpan di Scan Log.

Catatan:

- Browser biasanya mensyaratkan HTTPS untuk kamera jika bukan localhost.
- Untuk production, pastikan website memakai HTTPS.


18. Import Peserta CSV
----------------------

Masuk:

    Admin Panel -> Peserta

Gunakan fitur import CSV.

Format kolom yang dibaca:

    name,email,phone,seat_number,ticket_type,institution,faculty,major

Contoh:

    Budi,budi@email.com,08123456789,A1,Regular,Universitas Nusantara,Fakultas Teknik,Informatika

Setelah import, peserta mendapatkan ticket_code otomatis.


19. Checklist Fitur Berfungsi
-----------------------------

Gunakan checklist ini setelah setup:

[ ] Halaman utama bisa dibuka.
[ ] Login admin berhasil.
[ ] Event bisa dibuat dari admin.
[ ] Banner event bisa diupload dan tampil di landing page.
[ ] Search event bekerja.
[ ] Pagination event bekerja 9 item per halaman.
[ ] Detail event bisa dibuka.
[ ] Peserta bisa daftar.
[ ] Peserta gratis masuk status pending.
[ ] Peserta berbayar masuk halaman instruksi pembayaran.
[ ] Upload bukti pembayaran berhasil.
[ ] Admin bisa approve/reject peserta.
[ ] Email log atau SMTP berjalan.
[ ] Tiket QR muncul setelah approve.
[ ] Scanner QR bisa membaca tiket.
[ ] Scan log tersimpan.
[ ] Xendit webhook berjalan jika payment gateway dipakai.


20. Deployment ke Hosting/cPanel
--------------------------------

Langkah umum:

1. Upload semua file project ke hosting.
2. Set document root domain/subdomain ke folder:

       public

3. Install dependency:

       composer install --no-dev --optimize-autoloader

4. Jika kamu mengubah asset frontend dan membangunnya di lokal, upload folder:

       public/build

   Catatan: untuk kondisi normal aplikasi ini tidak perlu `npm` saat dijalankan.

5. Buat `.env` production:

       APP_ENV=production
       APP_DEBUG=false
       APP_URL=https://domainanda.com

6. Isi konfigurasi database hosting.
7. Isi konfigurasi mail SMTP.
8. Isi Xendit jika digunakan.
9. Jalankan:

       php artisan key:generate
       php artisan migrate --force
       php artisan db:seed --force
       php artisan storage:link
       php artisan config:cache
       php artisan route:cache
       php artisan view:cache

10. Pastikan permission folder ini bisa ditulis:

       storage
       bootstrap/cache

11. Jika memakai queue, jalankan worker melalui supervisor/cron sesuai fasilitas hosting:

       php artisan queue:work --tries=3


21. Troubleshooting
-------------------

Masalah: `php` tidak dikenali.
Solusi:

- Pastikan PHP masuk PATH.
- Di Laragon, pilih versi PHP dari menu Laragon.
- Di Git Bash, gunakan command PATH pada bagian requirement.

Masalah: Composer error versi PHP.
Solusi:

- Gunakan PHP 8.2 atau lebih baru.
- Jalankan `php -v` dan pastikan Composer memakai versi yang sama.

Masalah: Database connection refused.
Solusi:

- Pastikan MySQL jalan.
- Cek `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Jalankan `php artisan optimize:clear`.

Masalah: Tabel tidak ada.
Solusi:

    php artisan migrate

Atau untuk reset total:

    php artisan migrate:fresh --seed

Masalah: Gambar banner/bukti pembayaran tidak tampil.
Solusi:

    php artisan storage:link

Lalu cek `FILESYSTEM_DISK=public`.

Masalah: Email tidak terkirim.
Solusi:

- Jika `MAIL_MAILER=log`, cek `storage/logs/laravel.log`.
- Jika SMTP, cek host, port, username, password, encryption.
- Jalankan `php artisan optimize:clear`.

Masalah: Kamera scanner tidak muncul.
Solusi:

- Izinkan permission kamera di browser.
- Gunakan localhost atau HTTPS.
- Pastikan tidak ada browser lain yang sedang memakai kamera.

Masalah: Xendit webhook tidak masuk.
Solusi:

- Pastikan callback URL benar: `/api/webhooks/xendit`.
- Pastikan URL bisa diakses publik.
- Pastikan callback token sama dengan `.env`.
- Jalankan `php artisan optimize:clear`.
- Cek log di `storage/logs/laravel.log`.

Masalah: Perubahan `.env` tidak terbaca.
Solusi:

    php artisan optimize:clear

Masalah: Halaman blank/error 500.
Solusi:

- Local: set `APP_DEBUG=true`.
- Production: cek `storage/logs/laravel.log`.
- Pastikan folder `storage` dan `bootstrap/cache` writable.


22. Command Cepat Setup Lokal
-----------------------------

Jika database dan `.env` sudah benar:

    composer install
    php artisan key:generate
    php artisan migrate:fresh --seed
    php artisan storage:link
    php artisan optimize:clear
    php artisan serve --host=127.0.0.1 --port=8000

Buka:

    http://localhost:8000

Login admin:

    http://localhost:8000/login
    admin@qreticket.id / admin123
