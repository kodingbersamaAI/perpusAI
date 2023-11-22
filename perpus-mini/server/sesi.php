<?php
session_start();

// Fungsi untuk menghasilkan token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fungsi untuk menghasilkan token sesi
function generateSessionToken() {
    return bin2hex(random_bytes(64));
}

// Periksa apakah sesi telah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Setel waktu kedaluwarsa sesi (opsional)
// session_set_cookie_params(3600, '/', '', true, true);

// Perbarui waktu timeout sesi
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    // Sesuaikan waktu timeout sesuai kebutuhan (misalnya 1800 detik = 30 menit)
    session_unset();
    session_destroy();
    session_start();
}

// Setel waktu terakhir aktivitas
$_SESSION['last_activity'] = time();

// Fungsi untuk menyimpan data dalam sesi
function setSessionData($key, $value) {
    $_SESSION[$key] = $value;
}

// Fungsi untuk mendapatkan data dari sesi
function getSessionData($key) {
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }
    return null;
}

// Fungsi untuk menghapus data dari sesi
function removeSessionData($key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

// Fungsi untuk memeriksa apakah sesi tersedia
function isSessionAvailable() {
    return session_status() == PHP_SESSION_ACTIVE;
}

// Fungsi untuk menghapus sesi
function destroySession() {
    session_unset();
    session_destroy();
}

// Fungsi untuk memeriksa apakah pengguna telah login (opsional)
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk memeriksa token CSRF
function checkCSRFToken($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>