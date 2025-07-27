<?php
require_once 'vendor/autoload.php';
require_once 'config.php'; // Ensure this file has your DB connection and JWT_SECRET_KEY
require 'src/User.php';

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

use Srex\Api\User;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Function to generate JWT with enhanced user details
function generateJWT($userDetails) {
    $key = JWT_SECRET_KEY; // Use the secret key from config.php
    $payload = [
        "iss" => APP_URL, //"https://srex.swiftspeed.org", // Your issuer
        "aud" => APP_URL, //"https://srex.swiftspeed.org", // Your audience
        "iat" => time(), // Issued at
        "exp" => time() + (24 * 60 * 60), // Expiration time
        "sub" => $userDetails['email'], // Subject - the user's email
        "user" => [ // Additional user details
            "id" => $userDetails['id'],
            "username" => $userDetails['username'],
            "status" => $userDetails['status']
        ]
    ];

    return JWT::encode($payload, $key, 'HS256');
}

function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.securedmail.swiftspeedappcreator.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true; // Enable SMTP authentication
        $mail->Username   = 'support@securedmail.swiftspeedappcreator.com'; // SMTP username
        $mail->Password   = 'SecuredMail425913@.'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
        $mail->Port       = 465; // TCP port to connect to

        // Recipients
        $mail->setFrom('support@securedmail.swiftspeedappcreator.com', 'Srex');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Verify Your Email';
        $mail->Body    = "Your verification code is: <b>{$verificationCode}</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['firstName']) || empty($data['lastName'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required input']);
    exit;
}

$user = new User($conn);

if ($user->userExists($data['email'])) {
    http_response_code(409);
    echo json_encode(['error' => 'User already exists']);
    exit;
}

$verificationCode = bin2hex(random_bytes(5));

// var_dump($data['email']);
if ($userId = $user->createUser($data['username'], $data['firstName'], $data['lastName'], $data['email'], $data['password'], $verificationCode)) {
    $userDetails = $user->getUserInfoById($userId); // Fetch the newly created user details
    $token = generateJWT($userDetails); // Generate JWT with detailed user info

	if (sendVerificationEmail($data['email'], $verificationCode)) {
	echo json_encode(['message' => 'User created. Please verify your email.', 'token' => $token]);
	} 
	else {
		echo json_encode(['message' => 'User created. But failed to send verification email.', 'token' => $token]);
	}
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create user']);
}
