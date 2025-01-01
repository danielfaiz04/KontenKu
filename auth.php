<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php?page=login');
        exit;
    }
}

function logout() {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
} 