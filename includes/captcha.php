<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Create image with larger dimensions
$width = 150;
$height = 50;
$image = imagecreatetruecolor($width, $height);

// Colors
$background = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 20, 40, 100);
$noise_color = imagecolorallocate($image, 100, 120, 180);

// Fill background
imagefilledrectangle($image, 0, 0, $width, $height, $background);

// Add random noise
for($i=0; $i<100; $i++) {
    imagesetpixel($image, rand(0,$width), rand(0,$height), $noise_color);
    // Add some lines for more complexity
    imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $noise_color);
}

// Generate random string
$letters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
$captcha_text = substr(str_shuffle($letters), 0, 6);

// Store captcha text in session
$_SESSION['captcha'] = $captcha_text;

// If no TTF font is available, use basic text
imagestring($image, 5, 30, 15, $captcha_text, $text_color);

// Output image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?> 