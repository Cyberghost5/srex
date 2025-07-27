<?php
require_once 'vendor/autoload.php'; // Adjust path as necessary for autoloader
require_once 'auth/config.php'; // Include your database configuration, adjust path as needed

// A basic router setup
$request = $_GET['url'] ?? ''; // Get the 'url' parameter from .htaccess rewrite
$httpMethod = $_SERVER['REQUEST_METHOD']; // Capture the HTTP method

// Split the request into parts
$requestParts = explode('/', $request);

// Handle requests based on the first part of the URL
switch ($requestParts[0]) {
    case 'signup':
        if ($httpMethod == 'POST') {
            require 'auth/signup.php'; // Point to your signup script
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;
    
    case 'login':
        if ($httpMethod == 'POST') {
            require 'auth/login.php'; // Point to your login script
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    case 'confirmotp':
        if ($httpMethod == 'POST') {
            require 'auth/confirmOTP.php'; // Point to OTP confirmation script
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    case 'shippment': // Handling the shippment endpoint
        if ($httpMethod == 'GET') {
            require 'endpoints/shippment.php'; // Adjust path as needed to point to the shippment script
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;
  	
	case 'shippment-p': // Handling the shippment endpoint
        if ($httpMethod == 'POST') {
            require 'endpoints/shippment.php'; // Adjust path as needed to point to the shippment script
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;


    default:
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
