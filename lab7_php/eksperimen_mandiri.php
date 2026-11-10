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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Eksperimen Mandiri</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 640px; margin: 30px auto; }
        fieldset { margin-bottom: 24px; padding: 16px; }
        label { display: block; margin-top: 10px; }
        .error { color: #b00020; }
        .hasil { background: #e8f5e9; padding: 10px; margin-top: 12px; }
    </style>
</head>
<body>

<!-- ================= No. 2: pencarian dengan GET ================= -->
<fieldset>
    <legend>Cari Nama (GET)</legend>
    <form method="get" action="">
        <input type="text" name="cari" value="<?= htmlspecialchars($kataKunci) ?>" placeholder="Ketik nama...">
        <button type="submit">Cari</button>
    </form>

    <?php if ($kataKunci !== ""): ?>
        <?php if ($hasilCari): ?>
            <ul>
                <?php foreach ($hasilCari as $n): ?>
                    <li><?= htmlspecialchars($n) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="error">Nama "<?= htmlspecialchars($kataKunci) ?>" tidak ditemukan.</p>
        <?php endif; ?>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Input Nilai Mahasiswa (POST)</legend>

    <?php foreach ($errors as $e): ?>
        <p class="error"><?= htmlspecialchars($e) ?></p>
    <?php endforeach; ?>

    <form method="post" action="">
        <label>Nama
            <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>">
        </label>
        <label>NIM (10 digit angka)
            <input type="text" name="nim" value="<?= htmlspecialchars($nim) ?>" maxlength="10">
        </label>
        <label>Nilai Tugas
            <input type="number" name="tugas" value="<?= htmlspecialchars($tugas) ?>">
        </label>
        <label>Nilai UTS
            <input type="number" name="uts" value="<?= htmlspecialchars($uts) ?>">
        </label>
        <label>Nilai UAS
            <input type="number" name="uas" value="<?= htmlspecialchars($uas) ?>">
        </label>

        <br>
        <button type="submit">Proses</button>

        <button type="reset">Reset</button>
    </form>

    <?php if ($rataRata !== null): ?>
        <div class="hasil">
            <b><?= htmlspecialchars($nama) ?></b> (<?= htmlspecialchars($nim) ?>)<br>
            Rata-rata nilai: <b><?= number_format($rataRata, 2) ?></b>
        </div>
    <?php endif; ?>
</fieldset>


<fieldset>
    <legend>Demo Format Rupiah</legend>
    <p>Harga 1500000 &rarr; <?= formatRupiah(1500000) ?></p>
    <p>Harga 25000 &rarr; <?= formatRupiah(25000) ?></p>
</fieldset>

</body>
</html>
