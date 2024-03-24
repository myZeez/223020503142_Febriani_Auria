<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Febriani Auria</title>

    <link rel="stylesheet" href="Style1.css">
</head>

<body>
    <div class="container">
        <h2>Program Pengolahan Nama Anggota Keluarga </h2>

        <div class="content">
            <?php
                    // Start sesi untuk menyimpan data antar permintaan
                    session_start();

                    // Inisialisasi variabel array untuk menyimpan nama keluarga jika belum ada sesi yang dimulai
                    if (!isset($_SESSION['nama_keluarga'])) {
                        $_SESSION['nama_keluarga'] = [];
                    }

                    // Ambil nama dari input form jika form disubmit dengan metode POST dan jika input nama ada
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nama"])) {
                        $nama_input = $_POST["nama"];

                        // Periksa apakah nama yang diinputkan sudah ada dalam sesi
                        if (in_array($nama_input, $_SESSION['nama_keluarga'])) {

                            // Jika nama sudah ada, tampilkan pesan kesalahan
                            echo "<p>Nama \"$nama_input\" sudah ada dalam riwayat.</p>";

                        } else {
                            // Jika nama belum ada, lakukan pengolahan dan tampilkan hasilnya
                            $_SESSION['nama_keluarga'][] = $nama_input;

                            // Kumlah kata dan jumlah huruf
                            $jumlah_kata = str_word_count($nama_input);
                            $jumlah_huruf = strlen($nama_input);

                            // Kebalikan dari nama yang diinputkan
                            $kebalikan_nama = strrev($nama_input);

                            // Menghitung jumlah konsonan dan vokal
                            $jumlah_konsonan = preg_match_all('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', $nama_input);
                            $jumlah_vokal = preg_match_all('/[aeiouAEIOU]/', $nama_input);
                        

                            // Menyimpan riwayat input ke dalam file teks
                            $file = 'history.txt';
                            $data = "$nama_input|$jumlah_kata|$jumlah_huruf|$kebalikan_nama|$jumlah_konsonan|$jumlah_vokal\n";

                            // Menambahkan data ke dalam file
                            file_put_contents($file, $data, FILE_APPEND);


                

                // Menampilkan hasil dalam bentuk tabel
                echo "<table>";
                echo "<tr><th>JENIS INFORMASI</th><th>HASIL</th></tr>";
                echo "<tr><td>Nama yang diinputkan</td><th>$nama_input</th></tr>";
                echo "<tr><td>Jumlah Kata</td><th>$jumlah_kata</th></tr>";
                echo "<tr><td>Jumlah Huruf</td><th>$jumlah_huruf</th></tr>";
                echo "<tr><td>Kebalikan Nama</td><th>$kebalikan_nama</th></tr>";
                echo "<tr><td>Jumlah Konsonan</td><th>$jumlah_konsonan</th></tr>";
                echo "<tr><td>Jumlah Vokal</td><th>$jumlah_vokal</th></tr>";
                echo "</table>";
            }
        }
            
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                Masukkan nama: <input type="text" name="nama">
                <input type="submit">
                <input type="submit" name="clear" value="Bersihkan Riwayat">
            </form>
        </div>
    </div>

    <!-- Menampilkan riwayat input dalam bentuk tabel -->
    <div class="container">
        <h2>Riwayat Input</h2>
        <div class="content">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah Kata</th>
                    <th>Jumlah Huruf</th>
                    <th>Kebalikan Nama</th>
                    <th>Jumlah Konsonan</th>
                    <th>Jumlah Vokal</th>
                </tr>
                <?php
                // Membaca dan menampilkan riwayat input dari file teks
                $file = 'history.txt';
                if (file_exists($file)) {
                    $lines = file($file);
                    foreach ($lines as $line) {
                        $data = explode('|', $line);
                        echo "<tr>";
                        foreach ($data as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                }

                ?>
            </table>

            <?php
            // Tambahkan ini di bagian bawah form input nama
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clear"])) {
                // Hapus file history.txt
                $file = 'history.txt';
                if (file_exists($file)) {
                    unlink($file);
                }

                // Kosongkan array $_SESSION['nama_keluarga']
                $_SESSION['nama_keluarga'] = [];
            }


            ?>





        </div>
    </div>

    <footer>
        <p>&copy; 2024, Teknik Informatika, Universitas Palangka Raya </p>
        <p>Modul 1 - Tugas</p>
        <p>Dibuat oleh: Febriani Auria </p>
        <p>223020503142</p>
    </footer>
</body>

</html>