<?php
/**
 * ========================================
 * CONFIGURATION CENTRALISÉE
 * ========================================
 * Fichier de configuration principal qui charge
 * les variables d'environnement depuis .env
 */

// Empêcher l'accès direct
if (!defined('APP_ACCESS')) {
    define('APP_ACCESS', true);
}

// Charger le fichier .env
function loadEnv($path = __DIR__ . '/../.env') {
    if (!file_exists($path)) {
        throw new Exception(".env file not found at: " . $path);
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser la ligne
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Définir dans $_ENV et $_SERVER
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Charger les variables d'environnement
loadEnv();

// ========================================
// CONFIGURATION BASE DE DONNÉES
// ========================================
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'cheap');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// ========================================
// CONFIGURATION APPLICATION
// ========================================
define('APP_NAME', 'Cheap');
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost');
define('APP_DEBUG', APP_ENV === 'development');

// ========================================
// CONFIGURATION STRIPE
// ========================================
define('STRIPE_API_KEY', getenv('STRIPE_API_KEY'));
define('STRIPE_PUBLISHABLE_KEY', getenv('STRIPE_PUBLISHABLE_KEY'));

// ========================================
// CONFIGURATION CHEMINS
// ========================================
define('ROOT_PATH', dirname(__DIR__));
define('CONTROLLER_PATH', ROOT_PATH . '/controller');
define('VIEW_PATH', ROOT_PATH . '/vue');
define('STYLE_PATH', ROOT_PATH . '/style');

// ========================================
// CONFIGURATION SÉCURITÉ
// ========================================
define('SESSION_LIFETIME', 3600 * 24); // 24 heures
define('PASSWORD_MIN_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);

// ========================================
// CONFIGURATION EMAIL (MAILJET)
// ========================================
define('MAILJET_API_KEY', getenv('MAILJET_API_KEY') ?: '');
define('MAILJET_SECRET_KEY', getenv('MAILJET_SECRET_KEY') ?: '');
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: 'noreply@cheap.com');
define('EMAIL_FROM_NAME', getenv('EMAIL_FROM_NAME') ?: APP_NAME);

// ========================================
// TIMEZONE
// ========================================
date_default_timezone_set('Europe/Paris');

// ========================================
// GESTION DES ERREURS
// ========================================
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ========================================
// HELPERS FUNCTIONS
// ========================================

/**
 * Récupère une variable d'environnement
 */
function env($key, $default = null) {
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

/**
 * Retourne l'URL de base de l'application
 */
function base_url($path = '') {
    return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Redirection sécurisée
 */
function redirect($path) {
    header('Location: ' . $path);
    exit();
}

/**
 * Échapper les données HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Vérifier si l'utilisateur est admin
 */
function is_admin() {
    return isset($_SESSION['type_user']) && $_SESSION['type_user'] === 'admin';
}

/**
 * Obtenir l'utilisateur connecté
 */
function current_user() {
    if (!is_logged_in()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'email' => $_SESSION['email_user'] ?? null,
        'type' => $_SESSION['type_user'] ?? 'user'
    ];
}

/**
 * Générer un token CSRF
 */
function csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifier un token CSRF
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Logger un message (simple)
 */
function logger($message, $level = 'info') {
    if (APP_DEBUG) {
        $log_file = ROOT_PATH . '/logs/app.log';
        $log_dir = dirname($log_file);

        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $log_message = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }
}

// ========================================
// MESSAGE FLASH SYSTEM
// ========================================

/**
 * Définir un message flash
 */
function set_flash($key, $message, $type = 'info') {
    $_SESSION['flash'][$key] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Récupérer et supprimer un message flash
 */
function get_flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }
    return null;
}

/**
 * Vérifier si un message flash existe
 */
function has_flash($key) {
    return isset($_SESSION['flash'][$key]);
}
