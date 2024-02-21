<?php
// Define the environment
const env = 'dev';
const file_system = 'windows';

// Datetime format YYYY-MM-DD HH:MM:SS
date_default_timezone_set('Africa/Johannesburg');

if(env === 'dev'){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Convert filesystem path to web path (replace backslashes)
if(file_system === 'windows'){
    $relative_path = str_replace('\\', '/', dirname(__FILE__));
} else {
    $relative_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__));
}

// Define the root path for php includes
define('ROOT_PATH', dirname(__DIR__) . '/');

// Remove the document root from the path, if it exists
$web_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $relative_path);

// Move up one directory to get to the root of your project
$project_root = dirname($web_path);

// Ensure it starts and ends with a /
$project_root = '/' . trim($project_root, '/');

// Get the protocol (http or https)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";

// Get the server name (like yourdomain.com)
$server_name = $_SERVER['SERVER_NAME'];

define('BASE_URL', $protocol . $server_name . $project_root);



