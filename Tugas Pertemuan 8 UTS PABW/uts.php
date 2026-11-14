
<?php

// Fungsi menghitung diskon
function hitungDiskon($totalBelanja) {

    if ($totalBelanja >= 100000) {
        return 0.10 * $totalBelanja;
    } elseif ($totalBelanja >= 50000) {
        return 0.05 * $totalBelanja;
    } else {
        return 0;
    }
}

// Fungsi format rupiah
function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Variabel awal
$totalBelanja = 0;
$diskon = 0;
$totalBayar = 0;
$persentase = 0;
$sudahHitung = false;

// Memproses input
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hitung"])) {

    $input = $_POST["totalBelanja"] ?? '';

    if (is_numeric($input) && (float)$input >= 0) {

        $totalBelanja = (float)$input;

        // Memanggil fungsi
        $diskon = hitungDiskon($totalBelanja);

        // Menghitung total pembayaran
        $totalBayar = $totalBelanja - $diskon;

        // Menentukan persentase diskon
        if ($totalBelanja >= 100000) {
            $persentase = 10;
        } elseif ($totalBelanja >= 50000) {
            $persentase = 5;
        }

        $sudahHitung = true;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kalkulator Diskon</title>

<style>

/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* BACKGROUND */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 25px;

    background:
        radial-gradient(circle at top left, #51258a, transparent 40%),
        radial-gradient(circle at bottom right, #32145c, transparent 40%),
        #090711;
    color: white;
}

/* DEKORASI BACKGROUND */
body::before {
    content: "";
    position: fixed;
    width: 250px;
    height: 250px;
    background: #8b5cf6;
    filter: blur(120px);
    top: 10%;
    right: 10%;
    opacity: 0.35;
    pointer-events: none;
}

/* CONTAINER */
.container {
    position: relative;
    width: 100%;
    max-width: 440px;

    padding: 35px;

    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 22px;

    box-shadow:
        0 20px 50px rgba(0, 0, 0, 0.5),
        0 0 30px rgba(139, 92, 246, 0.15);
}

/* HEADER */
.header {
    text-align: center;
    margin-bottom: 30px;
}

.logo {
    width: 65px;
    height: 65px;
    margin: 0 auto 15px;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 18px;

    background: linear-gradient(135deg, #a855f7, #6d28d9);

    font-size: 30px;

    box-shadow: 0 0 25px rgba(168, 85, 247, 0.4);
}

.header h1 {
    font-size: 25px;
    font-weight: 800;
    letter-spacing: 1px;
}

.header p {
    color: #b9a7d9;
    font-size: 13px;
    margin-top: 8px;
}

/* LABEL */
label {
    display: block;
    margin-bottom: 10px;

    color: #e9d5ff;
    font-size: 14px;
    font-weight: 600;
}

/* INPUT */
.input-box {
    position: relative;
}

.input-box span {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);

    color: #c4b5fd;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 16px 15px 16px 65px;

    background: rgba(0, 0, 0, 0.25);

    border: 1px solid rgba(196, 181, 253, 0.3);
    border-radius: 12px;

    color: white;
    font-size: 16px;
    outline: none;

    transition: 0.3s;
}

input:focus {
    border-color: #a855f7;
    box-shadow: 0 0 15px rgba(168, 85, 247, 0.25);
}

input::placeholder {
    color: #887b9f;
}

/* BUTTON */
button {
    width: 100%;
    margin-top: 20px;
    padding: 15px;

    border: none;
    border-radius: 12px;

    background: linear-gradient(135deg, #a855f7, #6d28d9);

    color: white;
    font-size: 15px;
    font-weight: bold;

    cursor: pointer;

    box-shadow: 0 5px 20px rgba(139, 92, 246, 0.3);

    transition: 0.3s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(168, 85, 247, 0.5);
}

/* RESET */
.reset {
    display: block;
    margin-top: 18px;

    text-align: center;
    color: #c4b5fd;

    font-size: 13px;
    text-decoration: none;
}

.reset:hover {
    color: white;
}

/* HASIL */
.hasil {
    margin-top: 30px;
    padding: 22px;

    background: rgba(139, 92, 246, 0.12);

    border: 1px solid rgba(196, 181, 253, 0.25);
    border-radius: 15px;

    animation: muncul 0.5s ease;
}

.hasil h2 {
    text-align: center;
    font-size: 18px;
    margin-bottom: 22px;

    color: #e9d5ff;
}

.detail {
    display: flex;
    justify-content: space-between;
    gap: 10px;

    margin: 16px 0;

    font-size: 14px;
}

.detail span:first-child {
    color: #c4b5fd;
}

.detail strong {
    text-align: right;
    color: white;
}

.diskon {
    color: #86efac !important;
}

/* TOTAL BAYAR */
.total {
    border-top: 1px solid rgba(196, 181, 253, 0.3);
    padding-top: 18px;
    margin-top: 20px;
}

.total span:first-child {
    color: white;
    font-weight: bold;
}

.total strong {
    color: #c4b5fd;
    font-size: 19px;
}

/* INFO */
.info {
    margin-top: 25px;
    padding: 17px;

    background: rgba(0, 0, 0, 0.2);

    border: 1px solid rgba(196, 181, 253, 0.2);
    border-radius: 12px;
}

.info h3 {
    font-size: 14px;
    color: #e9d5ff;
    margin-bottom: 12px;
}

.info p {
    font-size: 12px;
    color: #b9a7d9;
    margin: 9px 0;
}

/* FOOTER */
.footer {
    text-align: center;
    margin-top: 25px;

    font-size: 11px;
    color: #887b9f;
    letter-spacing: 1px;
}

/* ANIMASI */
@keyframes muncul {
    from {
        opacity: 0;
        transform: translateY(15px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */
@media (max-width: 480px) {
    .container {
        padding: 25px 20px;
    }

    .header h1 {
        font-size: 21px;
    }
}

</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div class="logo">✦</div>

        <h1>DISCOUNT CALCULATOR</h1>

        <p>Smart Shopping, Save More!</p>

    </div>

    <!-- FORM INPUT -->
    <form method="POST">

        <label>💰 TOTAL BELANJA</label>

        <div class="input-box">

            <span>Rp</span>

            <input
                type="number"
                name="totalBelanja"
                placeholder="Masukkan total belanja"
                min="0"
                step="1"
                required
                value="<?php
                    echo $sudahHitung
                    ? htmlspecialchars((string)$totalBelanja)
                    : '';
                ?>"
            >

        </div>

        <button type="submit" name="hitung">
            HITUNG DISKON →
        </button>

        <a href="diskon.php" class="reset">
            ↻ Reset Perhitungan
        </a>

    </form>

    <!-- HASIL PERHITUNGAN -->
    <?php if ($sudahHitung): ?>

    <div class="hasil">

        <h2>✧ HASIL PERHITUNGAN ✧</h2>

        <div class="detail">

            <span>Total Belanja</span>

            <strong>
                <?php echo rupiah($totalBelanja); ?>
            </strong>

        </div>

        <div class="detail">

            <span>Diskon (<?php echo $persentase; ?>%)</span>

            <strong class="diskon">
                - <?php echo rupiah($diskon); ?>
            </strong>

        </div>

        <div class="detail total">

            <span>TOTAL BAYAR</span>

            <strong>
                <?php echo rupiah($totalBayar); ?>
            </strong>

        </div>

    </div>

    <?php endif; ?>

    <!-- KETENTUAN DISKON -->
    <div class="info">

        <h3>📌 KETENTUAN DISKON</h3>

        <p>✦ Belanja ≥ Rp100.000 : Diskon 10%</p>

        <p>✦ Belanja ≥ Rp50.000 : Diskon 5%</p>

        <p>✦ Belanja <escape><</escape> Rp50.000 : Tanpa Diskon</p>

    </div>

    <!-- FOOTER -->
    <div class="footer">

        POWERED BY PHP | 2026

    </div>

</div>

</body>
</html>
