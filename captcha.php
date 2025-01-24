<?php
session_start();

// Generar un código CAPTCHA aleatorio de 4 dígitos
$captcha_code = rand(1000, 9999);
$_SESSION['captcha'] = $captcha_code;

// Crear la imagen CAPTCHA
$width = 200;
$height = 80;
$image = imagecreate($width, $height);

// Colores de la imagen
$background_color = imagecolorallocate($image, 255, 255, 255); // Blanco
$text_color = imagecolorallocate($image, 106, 17, 203); // Púrpura
$line_color = imagecolorallocate($image, 176, 133, 245); // Gris claro

// Dibujar líneas aleatorias para ruido
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Configurar la fuente y tamaño
$font_size = 30;
$font_file = __DIR__ . '/Minecrafter.ttf';

// Verificar si la fuente existe
if (!file_exists($font_file)) {
    die("Error: La fuente no se encuentra.");
}

// Calcular las dimensiones del texto para centrarlo
$bbox = imagettfbbox($font_size, 0, $font_file, $captcha_code);
$text_width = $bbox[2] - $bbox[0];
$text_height = $bbox[1] - $bbox[7];

// Calcular posición centrada
$x = ($width - $text_width) / 2;
$y = ($height + $text_height) / 2;

// Agregar el texto CAPTCHA a la imagen
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_file, $captcha_code);

// Configurar la cabecera para mostrar la imagen
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);

