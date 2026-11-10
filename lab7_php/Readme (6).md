# Praktikum 7: Dasar Pemrograman PHP

Proyek **lab7_php** berisi latihan dasar PHP (variabel, percabangan, perulangan, fungsi, form GET/POST, dan validasi), satu mini project, dan satu eksperimen mandiri.

- **Nama:** Zaki Ramadhan
- **NIM:** 312510100
- **Kelas:** I.25.2A
- **Mata Kuliah:** Pemrograman Web
- **Tanggal Praktikum:** 10 November 2026

## Tujuan

1. Memahami cara menyisipkan dan menjalankan kode PHP di dalam dokumen HTML.
2. Menggunakan variabel, operator aritmatika, dan struktur percabangan (`if`, `elseif`, `else`).
3. Menggunakan array dan perulangan `foreach` untuk menampilkan data.
4. Membuat dan memanggil fungsi buatan sendiri.
5. Mengolah data formulir dengan metode GET dan POST.
6. Menerapkan validasi data di sisi server serta pengamanan keluaran dengan `htmlspecialchars()`.
7. Membuat aplikasi sederhana (mini project) yang menggabungkan seluruh konsep tersebut.

## Perangkat

| No | Perangkat | Keterangan |
|----|-----------|------------|
| 1 | Laptop/PC | Sistem operasi bebas (Windows) |
| 2 | Laragon 2026 v8.8.0 | Apache 2.4.69, MySQL 8.4.3, PHP 8.3.36 |
| 3 | Text editor | VS Code / Notepad++ |
| 4 | Web browser | Chrome / Firefox |

## Cara Menjalankan Server Lokal

1. Pasang dan buka **Laragon** (atau XAMPP).
2. Letakkan folder `lab7_php` di direktori root server (`C:\laragon\www` pada Laragon, atau `htdocs` pada XAMPP).
3. Klik **Start All** hingga Apache (port 8080) dan MySQL (port 3306) berstatus berjalan.
4. Buka browser, lalu akses salah satu alamat berikut:
   - Laragon (virtual host otomatis): `http://lab7_php.test:8080/namafile.php`
   - Alamat standar: `http://localhost:8080/lab7_php/namafile.php`
5. Contoh: `http://lab7_php.test:8080/latihan2.php`.

> Berkas PHP **tidak boleh** dibuka dengan cara klik ganda (`file:///...`) karena kodenya tidak akan diproses oleh server.

## Struktur File

```
lab7_php/
├── latihan1.php            # PHP di dalam HTML + date()
├── latihan2.php            # Variabel dan percabangan (nilai akhir)
├── latihan3.php            # Array dan perulangan foreach
├── latihan4.php            # Fungsi hitungDiskon()
├── latihan5.php            # Form metode GET
├── latihan6.php            # Form metode POST + validasi sederhana
├── latihan7.php            # Validasi angka (subtotal belanja)
├── MiniProject.php         # Formulir Data Mahasiswa
├── eksperimen_mandiri.php  # formatRupiah(), pencarian GET, input nilai POST
└── README.md
```

## Ringkasan Hasil

| Berkas | Konsep | Hasil |
|--------|--------|-------|
| `latihan1.php` | PHP dalam HTML, `date()` | Menampilkan "Belajar PHP", "PHP berhasil dijalankan.", dan waktu server yang berubah setiap di-refresh. |
| `latihan2.php` | Variabel, `if/elseif/else` | Nilai akhir = (85×0,30)+(78×0,30)+(90×0,40) = **84,90**, predikat **B**. |
| `latihan3.php` | Array, `foreach` | Daftar bernomor: Alya, Bima, Citra, Doni. |
| `latihan4.php` | Fungsi `return` | Harga 150.000 diskon 10% menjadi **Rp135.000**. |
| `latihan5.php` | Form GET | Kata kunci dikirim lewat URL dan ditampilkan kembali. |
| `latihan6.php` | Form POST | Nama dan Program Studi diterima tanpa muncul di URL; kolom kosong ditolak. |
| `latihan7.php` | Validasi angka | Harga 25.000 × 3 = **Rp75.000**; masukan tidak valid ditolak dengan pesan. |
| `MiniProject.php` | Validasi lengkap, sticky form, `htmlspecialchars()` | Lima isian divalidasi; jika valid tampil kotak "Ringkasan Data Mahasiswa". |
| `eksperimen_mandiri.php` | `formatRupiah()`, `stripos()`, `preg_match` | Pencarian nama, rata-rata nilai (80, 70, 90 → **80,00**), format rupiah. |

**Temuan pada eksperimen mandiri:** aturan validasi NIM pada kode (`/^[0-9]{9}$/`, 9 digit) tidak sama dengan label dan pesan kesalahan di formulir yang menyebut "10 digit". Aturan, label, dan pesan harus disamakan. Selain itu terdapat tanda `9;` yang tertinggal setelah `{9` pada baris `if` dan perlu dihapus.

## Kode Program

Berikut isi setiap berkas PHP pada folder `lab7_php`.

### 1. `latihan1.php`

```php
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Praktikum PHP</title>
</head>
<body>
  <h1>Belajar PHP</h1>
  <?php
    echo "<p>PHP berhasil dijalankan.</p>";
    echo "<p>Waktu server: " . date("d-m-Y H:i:s") . "</p>";
  ?>
</body>
</html>
```

### 2. `latihan2.php`

```php
<?php
$nama = "ZAKI";
$tugas = 85;
$uts = 78;
$uas = 90;
$nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);
if ($nilaiAkhir >= 85) {
    $predikat = "A";
} elseif ($nilaiAkhir >= 75) {
    $predikat = "B";
} elseif ($nilaiAkhir >= 60) {
    $predikat = "C";
} else {
    $predikat = "D";
}
echo "Nama: " . htmlspecialchars($nama) . "<br>";
echo "Nilai akhir: " . number_format($nilaiAkhir, 2) . "<br>";
echo "Predikat: " . $predikat;
?>
```

### 3. `latihan3.php`

```php
<?php
$mahasiswa = ["Alya", "Bima", "Citra", "Doni"];
echo "<h3>Daftar Mahasiswa</h3><ol>";
foreach ($mahasiswa as $nama) {
    echo "<li>" . htmlspecialchars($nama) . "</li>";
}
echo "</ol>";
?>
```

### 4. `latihan4.php`

```php
<?php
function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}
$hargaAkhir = hitungDiskon(150000, 10);
echo "Harga setelah diskon: Rp" . number_format($hargaAkhir, 0, ",", ".");
```

### 5. `latihan5.php`

```php
<form method="GET" action="">
  <label for="kata">Kata kunci:</label>
  <input id="kata" name="kata" type="text">
  <button type="submit">Cari</button>
</form>
<?php
if (isset($_GET["kata"])) {
    $kata = trim($_GET["kata"]);
    echo "Kata kunci: " . htmlspecialchars($kata, ENT_QUOTES, "UTF-8");
}
?>
```

### 6. `latihan6.php`

```php
<form method="POST" action="">
  <label for="nama">Nama:</label>
  <input id="nama" name="nama" type="text" required>
  <label for="prodi">Program Studi:</label>
  <input id="prodi" name="prodi" type="text" required>
  <button type="submit" name="kirim">Kirim Data</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    if ($nama === "" || $prodi === "") {
        echo "<p>Semua kolom wajib diisi.</p>";
    } else {
        echo "<h3>Data diterima</h3>";
        echo "Nama: " . htmlspecialchars($nama, ENT_QUOTES, "UTF-8") . "<br>";
        echo "Program Studi: " . htmlspecialchars($prodi, ENT_QUOTES, "UTF-8");
    }
}
?>
```

### 7. `latihan7.php`

```php
<?php
$hasil = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $barang = trim($_POST["barang"] ?? "");
    $hargaInput = $_POST["harga"] ?? "";
    $jumlahInput = $_POST["jumlah"] ?? "";

    if ($barang === "" || !is_numeric($hargaInput) ||
        !ctype_digit((string)$jumlahInput) ||
        (float)$hargaInput < 0 || (int)$jumlahInput < 1) {
        $error = "Periksa kembali nama barang, harga, dan jumlah.";
    } else {
        $harga = (float)$hargaInput;
        $jumlah = (int)$jumlahInput;
        $subtotal = $harga * $jumlah;
    }
}
?>
<form method="POST">
  <label>Nama barang <input name="barang" required></label>
  <label>Harga <input name="harga" type="number" min="0" step="0.01" required></label>
  <label>Jumlah <input name="jumlah" type="number" min="1" step="1" required></label>
  <button type="submit">Hitung</button>
</form>
<?php
if (isset($error)) {
    echo "<p>" . htmlspecialchars($error) . "</p>";
} elseif (isset($subtotal)) {
    echo "<p>Barang: " . htmlspecialchars($barang) . "</p>";
    echo "<p>Subtotal: Rp" . number_format($subtotal, 0, ",", ".") . "</p>";
}
?>
```

### 8. `MiniProject.php`

```php
<?php
// ===== BAGIAN PEMROSESAN DATA =====
$data = null;
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    if ($nama === "") $error[] = "Nama wajib diisi.";
    if ($nim === "") $error[] = "NIM wajib diisi.";
    if ($prodi === "") $error[] = "Program studi wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }
    if (!ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1-14.";
    }

    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Formulir Data Mahasiswa</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 480px; margin: 30px auto; }
    label { display: block; margin-bottom: 10px; }
    input { display: block; width: 100%; padding: 6px; box-sizing: border-box; }
    .error { color: #b00020; }
    .hasil { background: #eef7ee; padding: 10px 16px; margin-top: 20px; }
  </style>
</head>
<body>
  <h1>Formulir Data Mahasiswa</h1>
  <form method="POST" novalidate>
    <label>Nama
      <input type="text" name="nama" value="<?= htmlspecialchars($nama ?? "") ?>">
    </label>
    <label>NIM
      <input type="text" name="nim" value="<?= htmlspecialchars($nim ?? "") ?>">
    </label>
    <label>Program Studi
      <input type="text" name="prodi" value="<?= htmlspecialchars($prodi ?? "") ?>">
    </label>
    <label>Semester
      <input type="number" name="semester" min="1" max="14" value="<?= htmlspecialchars((string)($semesterInput ?? "")) ?>">
    </label>
    <label>Email
      <input type="email" name="email" value="<?= htmlspecialchars($email ?? "") ?>">
    </label>
    <button type="submit">Kirim</button>
  </form>

  <?php if ($error): ?>
    <div class="error">
      <h2>Terdapat kesalahan:</h2>
      <ul>
        <?php foreach ($error as $pesan): ?>
          <li><?= htmlspecialchars($pesan) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php elseif ($data): ?>
    <div class="hasil">
      <h2>Ringkasan Data Mahasiswa</h2>
      <p>Nama: <?= htmlspecialchars($data["nama"]) ?></p>
      <p>NIM: <?= htmlspecialchars($data["nim"]) ?></p>
      <p>Program Studi: <?= htmlspecialchars($data["prodi"]) ?></p>
      <p>Semester: <?= htmlspecialchars((string)$data["semester"]) ?></p>
      <p>Email: <?= htmlspecialchars($data["email"]) ?></p>
    </div>
  <?php endif; ?>
</body>
</html>
```

### 9. `eksperimen_mandiri.php`

```php
<?php
function formatRupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

$dataMahasiswa = [
    "Andi Pratama",
    "Zaki Ramadhan",
    "Rizanti Vidia",
    "Bambang",
    "jaka santoso",
];

$hasilCari = [];
$kataKunci = "";
if (isset($_GET['cari'])) {
    $kataKunci = trim($_GET['cari']);
    if ($kataKunci !== "") {
        foreach ($dataMahasiswa as $nama) {
            if (stripos($nama, $kataKunci) !== false) {
                $hasilCari[] = $nama;
            }
        }
    }
}

$errors = [];
$nama = $nim = "";
$tugas = $uts = $uas = "";
$rataRata = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? "");
    $nim   = trim($_POST['nim'] ?? "");
    $tugas = $_POST['tugas'] ?? "";
    $uts   = $_POST['uts'] ?? "";
    $uas   = $_POST['uas'] ?? "";

    if ($nama === "") {
        $errors[] = "Nama wajib diisi.";
    }

    if (!preg_match('/^[0-9]{9}$/', $nim)) {9;
        $errors[] = "NIM harus berisi angka saja dan tepat 10 digit.";
    }

    foreach (['Tugas' => $tugas, 'UTS' => $uts, 'UAS' => $uas] as $label => $nilai) {
        if (!is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
            $errors[] = "Nilai $label harus berupa angka 0-100.";
        }
    }

    if (empty($errors)) {
        $rataRata = ($tugas + $uts + $uas) / 3;
    }
}
?>
<!-- Bagian HTML: fieldset pencarian (GET), fieldset input nilai (POST),
     dan fieldset demo format rupiah. Lihat berkas lengkap pada lampiran. -->
```

> Pada `eksperimen_mandiri.php`, bagian HTML (fieldset pencarian GET, input nilai POST, dan demo format rupiah) tidak ditampilkan di sini karena panjang; lihat berkas lengkapnya di folder proyek.

## Pertanyaan dan Jawaban

### 1. Apa perbedaan pemrosesan client-side dan server-side?

- **Client-side** diproses di browser pengguna (HTML, CSS, JavaScript). Kodenya terlihat oleh pengguna dan hasilnya langsung tampil tanpa meminta ulang ke server.
- **Server-side** diproses di server (PHP, dan sejenisnya) sebelum halaman dikirim. Browser hanya menerima hasil akhirnya (HTML), sedangkan kode PHP tidak terlihat oleh pengguna.
- Server-side cocok untuk pengolahan data, akses database, dan validasi yang aman. Client-side cocok untuk interaksi tampilan.

### 2. Mengapa file PHP harus dijalankan melalui web server?

Browser tidak dapat menafsirkan PHP. Web server (Apache) dengan interpreter PHP yang menjalankan kodenya dan mengirim keluaran HTML ke browser. Jika file dibuka langsung (`file:///`), kode PHP tampil sebagai teks biasa atau tidak berjalan. Server juga menyediakan variabel seperti `$_GET`, `$_POST`, dan `$_SERVER`.

### 3. Apa fungsi tanda `$` pada variabel PHP?

Tanda `$` menandai bahwa sebuah nama adalah **variabel**, misalnya `$nama = "ZAKI";`. Variabel PHP tidak perlu dideklarasikan tipenya, karena tipe ditentukan otomatis dari nilai yang disimpan.

### 4. Apa perbedaan metode GET dan POST?

| Aspek | GET | POST |
|-------|-----|------|
| Pengiriman data | Lewat URL (query string) | Di badan permintaan (tidak tampak di URL) |
| Pembacaan di PHP | `$_GET` | `$_POST` |
| Keamanan | Data terlihat, tersimpan di riwayat browser | Lebih tertutup (tetap perlu validasi) |
| Batas data | Terbatas panjang URL | Praktis lebih besar |
| Cocok untuk | Pencarian, filter (bisa dibagikan lewat URL) | Pengiriman data formulir, data sensitif |

### 5. Mengapa input pengguna perlu divalidasi di sisi server?

Validasi di sisi klien (browser) dapat dilewati atau dimatikan, misalnya dengan atribut `novalidate`, mengubah kode lewat developer tools, atau mengirim permintaan langsung. Server adalah pertahanan terakhir, sehingga validasi di sana menjamin data yang masuk benar (tidak kosong, format sesuai, rentang wajar) dan melindungi aplikasi dari masukan berbahaya.

### 6. Apa fungsi `htmlspecialchars()` ketika menampilkan data dari form?

Fungsi ini mengubah karakter khusus HTML (`<`, `>`, `&`, `"`, `'`) menjadi entitas aman (`&lt;`, `&gt;`, dan seterusnya). Akibatnya masukan seperti `<b>Zaki</b>` atau `<script>` ditampilkan sebagai teks biasa, bukan dijalankan sebagai HTML atau JavaScript. Ini mencegah serangan **XSS (Cross-Site Scripting)**.

### 7. Apa manfaat penggunaan function dalam program PHP?

- **Dapat dipakai ulang:** kode ditulis sekali dan dipanggil berkali-kali (contoh `hitungDiskon()` dan `formatRupiah()`).
- **Program lebih rapi dan mudah dibaca**, karena dipecah menjadi bagian kecil yang bernama jelas.
- **Mudah dirawat:** perbaikan cukup dilakukan di satu tempat.
- **Mengurangi duplikasi kode** dan kesalahan, serta dapat mengembalikan nilai melalui `return`.

## Daftar Pustaka

- The PHP Group. *PHP Manual*. https://www.php.net/manual/
- W3Schools. *PHP Tutorial*. https://www.w3schools.com/php/
- Modul Praktikum Pemrograman Web, Praktikum 7.
