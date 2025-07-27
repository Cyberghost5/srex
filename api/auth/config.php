<?php
// config.php
include 'getEnv.php';
use DevCoder\DotEnv;
(new DotEnv(realpath("../") . '/.env'))->load();
$dbHost = getenv('DB_HOST'); //'localhost';
$dbUsername = getenv('DB_USERNAME'); //'srex';
$dbPassword = getenv('DB_PASSWORD'); //'Swiftspee1';
$dbName = getenv('DB_DATABASE'); //'srex';

// config.php
define('JWT_SECRET_KEY', 's^,7||YZe=92&[)j~s{TN*=$D=M@c]kA-z^sEFk:y0jRx6Sv,g{%W;P7jZOWNxMX');
define('APP_URL', getenv('APP_URL'));

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
