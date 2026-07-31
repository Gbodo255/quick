<?php

// 1. BRAND LOGO (QuickCredit) - 300x300 PNG
$w = 300; $h = 300;
$imgBrand = imagecreatetruecolor($w, $h);
$bgNavy = imagecolorallocate($imgBrand, 15, 23, 42); // #0f172a
$blueBrand = imagecolorallocate($imgBrand, 37, 99, 235); // #2563eb
$gold = imagecolorallocate($imgBrand, 245, 158, 11); // #f59e0b
$white = imagecolorallocate($imgBrand, 255, 255, 255);

imagefilledrectangle($imgBrand, 0, 0, $w, $h, $bgNavy);

// Outer frame
imagerectangle($imgBrand, 8, 8, $w-9, $h-9, $gold);
imagerectangle($imgBrand, 9, 9, $w-10, $h-10, $gold);

// Shield shape
$pts = [
    150, 45,
    255, 90,
    255, 195,
    150, 255,
    45, 195,
    45, 90
];
imagefilledpolygon($imgBrand, $pts, $blueBrand);
imagepolygon($imgBrand, $pts, $white);

// Text
imagestring($imgBrand, 5, 132, 120, "QC", $white);
imagestring($imgBrand, 5, 85, 175, "QUICKCREDIT", $gold);

imagepng($imgBrand, __DIR__ . '/../public/images/logo_brand.png');
imagedestroy($imgBrand);


// 2. EUROPEAN UNION FLAG (EU) - 450x300 PNG
$w = 450; $h = 300;
$imgEu = imagecreatetruecolor($w, $h);
$euBlue = imagecolorallocate($imgEu, 0, 51, 153); // #003399
$goldStar = imagecolorallocate($imgEu, 255, 204, 0); // #FFCC00
$whiteBorder = imagecolorallocate($imgEu, 226, 232, 240);

imagefilledrectangle($imgEu, 0, 0, $w, $h, $euBlue);
imagerectangle($imgEu, 0, 0, $w-1, $h-1, $whiteBorder);

// 12 Stars Circle
$cx = $w / 2;
$cy = $h / 2;
$radius = 88;

for ($i = 0; $i < 12; $i++) {
    $angle = deg2rad($i * 30 - 90);
    $sx = $cx + $radius * cos($angle);
    $sy = $cy + $radius * sin($angle);
    
    // Draw 5-point star
    $starPoints = [];
    for ($j = 0; $j < 10; $j++) {
        $r = ($j % 2 === 0) ? 18 : 8;
        $a = $angle + deg2rad($j * 36);
        $starPoints[] = (int)($sx + $r * cos($a));
        $starPoints[] = (int)($sy + $r * sin($a));
    }
    imagefilledpolygon($imgEu, $starPoints, $goldStar);
}

imagepng($imgEu, __DIR__ . '/../public/images/logo_eu.png');
imagedestroy($imgEu);


// 3. FRENCH REPUBLIC / MINISTERE DES FINANCES EMBLEM - 450x300 PNG
$w = 450; $h = 300;
$imgFr = imagecreatetruecolor($w, $h);
$frBlue = imagecolorallocate($imgFr, 0, 35, 149);   // #002395
$frWhite = imagecolorallocate($imgFr, 255, 255, 255);
$frRed = imagecolorallocate($imgFr, 237, 41, 57);   // #ED2939
$navyText = imagecolorallocate($imgFr, 15, 23, 42);

// Tricolor stripes
imagefilledrectangle($imgFr, 0, 0, 149, $h, $frBlue);
imagefilledrectangle($imgFr, 150, 0, 299, $h, $frWhite);
imagefilledrectangle($imgFr, 300, 0, 449, $h, $frRed);

// Outer frame
imagerectangle($imgFr, 0, 0, $w-1, $h-1, $navyText);

// Official Text in center
imagestring($imgFr, 5, 175, 95, "R\xC9PUBLIQUE", $frBlue);
imagestring($imgFr, 5, 175, 125, "FRAN\xC7AISE", $frBlue);
imagestring($imgFr, 3, 160, 175, "MINIST\xC8RE DES FINANCES", $navyText);

imagepng($imgFr, __DIR__ . '/../public/images/logo_fr.png');
imagedestroy($imgFr);

echo "PNG images saved into public/images/\n";
