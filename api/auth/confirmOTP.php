<?php
require_once 'vendor/autoload.php';
require_once 'config.php'; // DB connection and JWT_SECRET_KEY
require 'src/User.php';

use Srex\Api\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Function to generate JWT with enhanced user details
function generateJWT($userDetails) {
    $key = JWT_SECRET_KEY; // Defined in config.php
    $payload = [
        "iss" => APP_URL, //"https://srex.swiftspeed.org", // Your issuer
        "aud" => APP_URL, //"https://srex.swiftspeed.org", // Your audience
        "iat" => time(), // Issued at
        "exp" => time() + (24 * 60 * 60), // Token expiration, adjust as necessary
        "sub" => $userDetails['email'], // User's email as subject
        "user" => [ // Embedding additional user information
            "id" => $userDetails['id'],
            "username" => $userDetails['username'],
            "email" => $userDetails['email'],
            "status" => $userDetails['status'],
        ]
    ];

    return JWT::encode($payload, $key, 'HS256');
}

// Decoding JWT token
function decodeJWT($jwt) {
    $key = JWT_SECRET_KEY;
    try {
        return JWT::decode($jwt, new Key($key, 'HS256'));
    } catch (Exception $e) {
        error_log("JWT Decode Error: " . $e->getMessage());
        return null;
    }
}

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['otp']) || empty($data['token'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required input']);
    exit;
}

$decoded = decodeJWT($data['token']);
if ($decoded === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Token authentication error']);
    exit;
}

// Assuming your payload structure includes a user object
$email = $decoded->user->email; // Adjust based on actual payload structure
$user = new User($conn);

$userId = $user->getUserInfoByEmail($email);
if (!$userId) {
    http_response_code(404);
    echo json_encode(['error' => 'User does not exist']);
    exit;
}

$storedOTP = $user->getUserOTP($userId);
if ($data['otp'] != $storedOTP) {
    http_response_code(400);
    echo $storedOTP;
    echo json_encode(['error' => 'Invalid OTP']);
    exit;
}

// Mark the user as verified
if($user->verifyUser($userId)) {
    // Fetch updated user info for response
    $userData = $user->getUserInfoById($userId);
    
    // Regenerate JWT token with updated user info
    $token = generateJWT($userData); // Note: $userData must be an array with keys: id, username, email, is_verified

    $response = [
        "status" => 200,
        "message" => "User verified successfully.",
        "user_data" => $userData,
        "isverified" => true,
        "token" => $token
    ];

    echo json_encode($response);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to verify user']);
}
