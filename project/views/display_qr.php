<?php
require '../config.php';
require "vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conn->prepare("SELECT reset_code FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['reset_code']) {
        $code = $user['reset_code'];

        $qrCode = QrCode::create($code);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Page content with styles
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>QR Code</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .container {
                    text-align: center;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    font-size: 24px;
                    color: #333;
                    margin-bottom: 20px;
                }
                img {
                    width: 200px;
                    height: 200px;
                    margin: 20px 0;
                }
                a {
                    text-decoration: none;
                    color: #fff;
                    background: #007BFF;
                    padding: 10px 20px;
                    border-radius: 5px;
                    font-size: 16px;
                }
                a:hover {
                    background: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Scan the QR Code</h1>
                <img src='data:" . $result->getMimeType() . ";base64," . base64_encode($result->getString()) . "' alt='QR Code'>
                <br>
                <a href='submit_code.php?email=" . urlencode($email) . "'>Enter Code Manually</a>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    text-align: center;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    font-size: 24px;
                    color: #333;
                    margin-bottom: 20px;
                }
                a {
                    text-decoration: none;
                    color: #fff;
                    background: #007BFF;
                    padding: 10px 20px;
                    border-radius: 5px;
                    font-size: 16px;
                }
                a:hover {
                    background: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>No reset code found. Please try again.</h1>
                <a href='forgot_password.php'>Go Back</a>
            </div>
        </body>
        </html>";
    }
} else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .container {
                text-align: center;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                font-size: 24px;
                color: #333;
                margin-bottom: 20px;
            }
            a {
                text-decoration: none;
                color: #fff;
                background: #007BFF;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 16px;
            }
            a:hover {
                background: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Invalid request.</h1>
            <a href='forgot_password.php'>Go Back</a>
        </div>
    </body>
    </html>";
}
?>
