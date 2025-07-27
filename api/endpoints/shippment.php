<?php
require_once 'vendor/autoload.php';
require_once 'auth/config.php'; // Adjust the path as needed
require_once 'src/User.php'; // Adjust path as needed for the User class

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

// Assuming you might use the User class for additional functionalities
// $user = new User($conn);

// Function to decode JWT
function decodeJWT($jwtToken) {
    try {
        $decoded = JWT::decode($jwtToken, new Key(JWT_SECRET_KEY, 'HS256'));
        return (array) $decoded;
    } catch (Exception $e) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'Invalid token', 'error' => $e->getMessage()], JSON_PRETTY_PRINT);
        exit;
    }
}

// Retrieve the JWT token from the Authorization header
$_SERVER['HTTP_AUTHORIZATION'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3NyZXgiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0L3NyZXgiLCJpYXQiOjE3MTAzMTI0MDYsImV4cCI6MTcxMDM5ODgwNiwic3ViIjoiYWRlYmlzaWNvdmVuYW50MDFAZ21haWwuY29tIiwidXNlciI6eyJpZCI6MTg0LCJ1c2VybmFtZSI6IkNvdkFkZTc3MiIsImVtYWlsIjoiYWRlYmlzaWNvdmVuYW50MDFAZ21haWwuY29tIiwic3RhdHVzIjoxfX0.vjYOEdIAgw0baauc8E4YH0CNHHaQFucebI4rJILcE88';
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$jwtToken = str_replace('Bearer ', '', $authHeader);

if (!$jwtToken) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Token not provided']);
    exit;
}

// var_dump($decodedToken);

// Decode the JWT Token to get the user ID
$decodedToken = decodeJWT($jwtToken);
$userId = $decodedToken['user']->id ?? null;

if (!$userId) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode(['message' => 'User ID not found in token']);
    exit;
}

// Fetch shippments for the user from the "shippment" table
$query = "SELECT * FROM shippments WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$shippments = [];

while ($row = $result->fetch_assoc()) {
    $shippments[] = $row;
}

if (count($shippments) > 0) {
    http_response_code(200); // OK
    echo json_encode([
        'status' => 'success',
        'message' => 'Shippments retrieved successfully',
        'data' => $shippments
    ]);
} else {
    http_response_code(404); // Not Found
    echo json_encode([
        'status' => 'success',
        'message' => 'No shippments found for this user',
        'data' => []
    ]);
}


// Function to process shipment data for POST requests
function processShipmentRequest($userId, $data) {
    global $conn; // Make sure to use global $conn if it's defined outside this function

    // Validate input data - ensure all required fields are provided
    $requiredFields = [
        'ref_id', 'trx_id', 'amount', 'delivery_type', 'delivery_method',
        'destination_option', 'sender_name', 'sender_email', 'sender_phone',
        // Continue listing all required fields as per your table structure
    ];
    
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            return ['error' => "Missing required field: $field"];
        }
    }
    
    // Here, insert or update the database with the $data
    // This part is left as an exercise since it depends on your specific database schema and logic
    // Example: $result = insertOrUpdateShipment($userId, $data);

    // Assuming insertOrUpdateShipment returns true on success
    // if ($result) {
    //     return ['message' => 'Shipment entry created/updated successfully'];
    // } else {
    //     return ['error' => 'Failed to create/update the shipment entry'];
    // }
}

$_SERVER['HTTP_AUTHORIZATION'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3NyZXgiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0L3NyZXgiLCJpYXQiOjE3MTAzMTI0MDYsImV4cCI6MTcxMDM5ODgwNiwic3ViIjoiYWRlYmlzaWNvdmVuYW50MDFAZ21haWwuY29tIiwidXNlciI6eyJpZCI6MTg0LCJ1c2VybmFtZSI6IkNvdkFkZTc3MiIsImVtYWlsIjoiYWRlYmlzaWNvdmVuYW50MDFAZ21haWwuY29tIiwic3RhdHVzIjoxfX0.vjYOEdIAgw0baauc8E4YH0CNHHaQFucebI4rJILcE88';
$httpMethod = $_SERVER['REQUEST_METHOD'];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$jwtToken = str_replace('Bearer ', '', $authHeader);

if (!$jwtToken) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Token not provided']);
    exit;
}

$decodedToken = decodeJWT($jwtToken);
$userId = $decodedToken['user']->id ?? null;

if (!$userId) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode(['message' => 'User ID not found in token']);
    exit;
}

if ($httpMethod == 'GET') {
    // Existing code for handling GET requests...
} elseif ($httpMethod == 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);
    $response = processShipmentRequest($userId, $postData);
    if (isset($response['error'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => $response['error']]);
    } else {
        http_response_code(200); // OK
        echo json_encode(['message' => $response['message']]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    // echo json_encode(['error' => 'Method Not Allowed e']);
}


