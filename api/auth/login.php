<?php
require_once 'vendor/autoload.php';
require_once 'config.php'; // DB connection and JWT_SECRET_KEY
require 'src/User.php';

require 'vendor/phpmailer/src/Exception.php';
require 'vendor/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/src/SMTP.php';

use Srex\Api\User;
use Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

header('Content-Type: application/json');

// Function to generate JWT with enhanced user details
function generateJWT($userDetails) {
    $key = JWT_SECRET_KEY; // Use the secret key defined in config.php
    $payload = [
        "iss" => APP_URL, //"https://srex.swiftspeed.org", // Your issuer
        "aud" => APP_URL, //"https://srex.swiftspeed.org", // Your audience
        "iat" => time(),
        "exp" => time() + (24 * 60 * 60), // Token valid for 24 hours
        "sub" => $userDetails['email'], // Subject
        "user" => [
            "id" => $userDetails['id'],
            "username" => $userDetails['username'],
            "email" => $userDetails['email'],
            "status" => $userDetails['status'],
        ]
    ];

    return JWT::encode($payload, $key, 'HS256');
}

function sendVerificationEmail($email, $otp) {
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
        $mail->Body    = "Your verification code is: <b>{$otp}</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

$data = json_decode(file_get_contents('php://input'), true);
// var_dump($data);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required input']);
    exit;
}

$user = new User($conn);

$userDetails = $user->getUserInfoByEmail($data['email']);
if (!$userDetails) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
    exit;
}

if (!password_verify($data['password'], $userDetails['password'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Incorrect Password']);
    exit;
}

if (!$userDetails['status']) {
    $newOTP = bin2hex(random_bytes(5)); // Generate a new OTP
    if ($user->resendOTP($userDetails['id'], $newOTP)) {
    	$token = generateJWT($userDetails); // Generate JWT with detailed user info
        if (sendVerificationEmail($userDetails['email'], $newOTP)) {; // Resend OTP to the user
        http_response_code(403); // Forbidden
        echo json_encode(['error' => 'User is not verified. A new OTP has been sent to your email.', 'token' => $token]);
        }else{
            http_response_code(500);
            echo json_encode(['error' => 'Error resending OTP.', 'token' => $token]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error resending OTP.']);
    }
    exit;
}

$token = generateJWT($userDetails);

echo json_encode([
    "status" => 200,
    "message" => "Login successful",
    "user_data" => $userDetails, // Directly using the fetched user details
    "token" => $token,
]);
