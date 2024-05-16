$input = '12454as5d6as5asdf87a8sf7d8sdfd3';
$key = '1111111111';
$iv = 'aaaaaaaaaaaa';
function padZero($data) {
    $blockSize = 16;
    $paddingLength = $blockSize - (strlen($data) % $blockSize);
    return $data . str_repeat("\0", $paddingLength);
}

function unpadZero($data) {
    return rtrim($data, "\0");
}

$aes1 = openssl_encrypt(padZero($input), 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING,$iv);
$text2 =openssl_decrypt(unpadZero($aes1), 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING,$iv);


$aes1 = base64_encode(openssl_encrypt($input, 'AES-128-CBC', $key, OPENSSL_RAW_DATA,$iv));
$text2 =openssl_decrypt( base64_decode($aes1), 'AES-128-CBC', $key, OPENSSL_RAW_DATA,$iv);

