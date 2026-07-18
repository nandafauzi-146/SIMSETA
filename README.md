# SIMSETA - Sistem Informasi Manajemen Sertifikat Tanah

SIMSETA (Sistem Informasi Manajemen Sertifikat Tanah) adalah portal publik layanan informasi pertanahan resmi yang dikembangkan untuk **Pemerintah Desa Tegalmulyo**. Sistem ini berfungsi sebagai pusat data digital untuk memberikan transparansi dan kemudahan akses bagi masyarakat dalam mengecek status sertifikat atau alas hak tanah mereka secara mandiri dan _online_.

## Fitur Utama

- **Pencarian Sertifikat Mandiri**: Masyarakat dapat dengan mudah mengecek status kepemilikan tanah cukup dengan memasukkan nomor dokumen atau alas hak ke dalam kolom pencarian.
- **Verifikasi Otomatis & Real-time**: Sistem secara otomatis mencocokkan pencarian dengan basis data administrasi pemerintahan desa yang sah.
- **Layanan Informasi & Bantuan**: Menyediakan panduan penggunaan langkah demi langkah, Pertanyaan Umum (FAQ), serta informasi kontak dan operasional Kantor Desa Tegalmulyo, yang juga dilengkapi dengan integrasi lokasi peta (Google Maps).
- **Keamanan**: Dilengkapi perlindungan *anti-bot* dari Cloudflare Turnstile guna menjaga integritas pencarian publik.

## Cara Penggunaan (Portal Publik)

1. **Masukkan Nomor:** Ketik nomor sertifikat atau alas hak kepemilikan pada kolom pencarian di halaman utama SIMSETA.
2. **Sistem Memverifikasi:** Data akan divalidasi secara otomatis berdasarkan data administrasi desa.
3. **Lihat Hasil:** Informasi status sertifikat akan langsung ditampilkan dengan cepat dan aman.

## Teknologi

Aplikasi SIMSETA dibangun menggunakan beberapa teknologi web modern:
- **Backend Framework**: Laravel (PHP)
- **Frontend**: Laravel Blade Templates dipadukan dengan desain antarmuka modern menggunakan HTML5, CSS (Flexbox/Grid, Glassmorphism, Micro-animations), serta Alpine.js.
- **Integrasi Pihak Ketiga**: Google Maps Embed API & Cloudflare Turnstile.

## Sponsor & Dukungan

Pengembangan dan operasional sistem ini merupakan bentuk kolaborasi yang didukung oleh:
- **HMSI UTY** (Himpunan Mahasiswa Sistem Informasi UTY)
- **Pemdes Tegalmulyo**
- **Kominfo Daerah**

## Informasi Kontak

Apabila data sertifikat tidak ditemukan atau terdapat kesalahan informasi pada saat pencarian, silakan menghubungi Pemerintah Desa Tegalmulyo:

- **Hari & Jam Pelayanan:** Senin – Jumat, pukul 08.00 – 15.00 WIB
- **Alamat:** Kantor Balai Desa Tegal Mulyo, Kec. Kemalang, Kab. Klaten, Jawa Tengah
