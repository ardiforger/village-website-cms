<?php
// includes/auth.php
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function checkRole($allowed_roles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini!";
        header('Location: dashboard.php');
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isEditor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'editor';
}

function isAuthor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'author';
}

// Function untuk mengecek permission berdasarkan halaman
function checkPagePermission($page) {
    $permissions = [
        'users.php' => ['admin'],
        'pengaturan.php' => ['admin'],
        'artikel.php' => ['admin', 'editor', 'author'],
        'galeri.php' => ['admin', 'editor'],
        'carousel.php' => ['admin'],
        'profil.php' => ['admin', 'editor', 'author']
    ];
    
    if (isset($permissions[$page])) {
        checkRole($permissions[$page]);
    }
}
?>