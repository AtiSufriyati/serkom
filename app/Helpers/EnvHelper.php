<?php
    function secEnv($name, $fallback = '') {
        // $env = require __DIR__. './../config/env.php';
        // $crypt = new \Illuminate\Encryption\Encrypter($env['key']);
        $crypt = new \Illuminate\Encryption\Encrypter(base64_encode(env('APP_OWNER')));
        try {
            $value = $crypt->decrypt(substr(env($name), 4));
            $value = preg_replace( "/\r|\n/", "", $value);
        }
        catch (Exception $e) {
            $value = env($name, $fallback);
        }
        return $value;
    }
?>