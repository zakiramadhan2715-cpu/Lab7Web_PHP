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

  <!-- novalidate: agar validasi server-side bisa diuji tanpa dihalangi browser -->
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