<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Idea.php';
require_once 'models/Product.php';
require_once 'includes/helpers.php';
require_once 'includes/auth.php';

$db = new Database();
$database = $db->getConnection();

// Handle login action
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'login') {
        $user = new User($database);
        $auth = $user->authenticate($_POST['email'], $_POST['password']);
        
        if ($auth) {
            $_SESSION['user_id'] = (string) $auth->_id;
            $_SESSION['user_name'] = $auth->name;
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = 'Email atau password salah';
            header('Location: index.php?page=login');
            exit;
        }
    } elseif ($_GET['action'] === 'register') {
        $user = new User($database);
        
        // Validasi password
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $_SESSION['error'] = 'Password tidak cocok';
            header('Location: index.php?page=register');
            exit;
        }
        
        try {
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];
            
            $user->create($userData);
            $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
            header('Location: index.php?page=login');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?page=register');
            exit;
        }
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

$page = $_GET['page'] ?? 'dashboard';

// Pages that don't require authentication
if (in_array($page, ['login', 'register'])) {
    include "views/auth/$page.php";
    exit;
}

// Require authentication for all other pages
requireLogin();

$idea = new Idea($database);

include 'includes/header.php';

switch($page) {
    case 'dashboard':
        include 'views/dashboard.php';
        break;
    case 'ideas':
        include 'views/ideas/list.php';
        break;
    case 'idea-create':
        include 'views/ideas/create.php';
        break;
    case 'idea-edit':
        include 'views/ideas/edit.php';
        break;
    case 'idea-detail':
        include 'views/ideas/detail.php';
        break;
    case 'products':
        include 'views/products/list.php';
        break;
    case 'product-create':
        include 'views/products/create.php';
        break;
    default:
        include 'views/dashboard.php';
}

include 'includes/footer.php'; 