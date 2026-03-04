<?php
session_start();

// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'login_system');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

function hashPassword($password, $type = 'bcrypt') {
    switch (strtolower($type)) {
        case 'md5':
            return md5($password);
        case 'bcrypt':
            return password_hash($password, PASSWORD_BCRYPT);
        case 'scrypt':
            $salt = bin2hex(random_bytes(16));
            return $salt . ':' . hash('sha512', $password . $salt);
        default:
            return password_hash($password, PASSWORD_BCRYPT);
    }
}

function verifyPassword($password, $storedPassword, $type = 'bcrypt') {
    switch (strtolower($type)) {
        case 'md5':
            return md5($password) === $storedPassword;
        case 'bcrypt':
            return password_verify($password, $storedPassword);
        case 'scrypt':
            list($salt, $hash) = explode(':', $storedPassword);
            return hash('sha512', $password . $salt) === $hash;
        default:
            return false;
    }
}
?>
