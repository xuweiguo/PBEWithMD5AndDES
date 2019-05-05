class Tool{
 /**
     * 获取随机数
     * @param int $length
     * @return string
     */
    public static function _getCharRandomSalt($length = 16) {
        $bytes = openssl_random_pseudo_bytes($length);
        return substr(bin2hex($bytes), 0, $length);
    }

    /**
     * PBEWithMD5AndDES
     * @param $encrypted
     * @param string $password
     * @param int $iterations
     * @return string
     */
    public static function decryptPBEWithMD5AndDES($encrypted, $password = 'xuweiguo', $iterations = 1000) {
        $data = bin2hex(base64_decode($encrypted));
        $salt = substr($data, 0, 16);
        $eb = base64_encode(hex2bin(substr($data, 16)));
        $passwordBin = unpack('H*', $password);
        $dk = array_shift($passwordBin) . $salt;
        $dk = hex2bin($dk);
        while ($iterations--) {
            $dk = openssl_digest(($dk), 'md5', true);
        }
        $dk = bin2hex($dk);
        $key = hex2bin(substr($dk, 0, 16));
        $iv = hex2bin(substr($dk, 16));
        $text = openssl_decrypt($eb, 'DES-CBC', $key, false, $iv);
        return $text;
    }

    /**
     * PBEWithMD5AndDES
     * @param $encrypted
     * @param string $password
     * @param int $iterations
     * @return string
     */
    public static function encryptPBEWithMD5AndDES($encrypted, $password = 'xuweiguo', $iterations = 1000) {
        $salt = self::_getCharRandomSalt(16);
        $passwordBin = unpack('H*', $password);
        $dk = array_shift($passwordBin) . $salt;
        $dk = hex2bin($dk);
        while ($iterations--) {
            $dk = openssl_digest(($dk), 'md5', true);
        }
        $dk = bin2hex($dk);
        $key = hex2bin(substr($dk, 0, 16));
        $iv = hex2bin(substr($dk, 16));
        $text = openssl_encrypt($encrypted, 'DES-CBC', $key, true, $iv);
        $crypt = pack("H*", $salt) . $text;
        return base64_encode($crypt);
    }

}
