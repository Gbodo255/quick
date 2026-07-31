<?php

// 1. BRAND LOGO (QuickCredit / CreditEco) - High Resolution 240x240
$w = 240; $h = 240;
$imgBrand = imagecreatetruecolor($w, $h);
imagealphablending($imgBrand, true);
imagesavealpha($imgBrand, true);

$bgNavy = imagecolorallocate($imgBrand, 15, 23, 42); // #0f172a
$blueBrand = imagecolorallocate($imgBrand, 37, 99, 235); // #2563eb
$gold = imagecolorallocate($imgBrand, 245, 158, 11); // #f59e0b
$white = imagecolorallocate($imgBrand, 255, 255, 255);

imagefilledrectangle($imgBrand, 0, 0, $w, $h, $bgNavy);

// Outer gold frame
imagerectangle($imgBrand, 6, 6, $w-7, $h-7, $gold);
imagerectangle($imgBrand, 7, 7, $w-8, $h-8, $gold);

// Shield shape
$pts = [
    120, 35,
    205, 70,
    205, 155,
    120, 205,
    35, 155,
    35, 70
];
imagefilledpolygon($imgBrand, $pts, $blueBrand);
imagepolygon($imgBrand, $pts, $white);

// Text
imagestring($imgBrand, 5, 105, 95, "QC", $white);
imagestring($imgBrand, 4, 65, 140, "QUICKCREDIT", $gold);

ob_start();
imagepng($imgBrand);
$brandPngBase64 = base64_encode(ob_get_clean());
imagedestroy($imgBrand);


// 2. EUROPEAN UNION FLAG (EU) - High Resolution 360x240
$w = 360; $h = 240;
$imgEu = imagecreatetruecolor($w, $h);
$euBlue = imagecolorallocate($imgEu, 0, 51, 153); // Official EU Blue #003399
$goldStar = imagecolorallocate($imgEu, 255, 204, 0); // Official EU Gold #FFCC00
$whiteBorder = imagecolorallocate($imgEu, 226, 232, 240);

imagefilledrectangle($imgEu, 0, 0, $w, $h, $euBlue);
imagerectangle($imgEu, 0, 0, $w-1, $h-1, $whiteBorder);

// 12 Stars Circle
$cx = $w / 2;
$cy = $h / 2;
$radius = 70;

for ($i = 0; $i < 12; $i++) {
    $angle = deg2rad($i * 30 - 90);
    $sx = $cx + $radius * cos($angle);
    $sy = $cy + $radius * sin($angle);
    
    // Draw 5-point star
    $starPoints = [];
    for ($j = 0; $j < 10; $j++) {
        $r = ($j % 2 === 0) ? 14 : 6;
        $a = $angle + deg2rad($j * 36);
        $starPoints[] = (int)($sx + $r * cos($a));
        $starPoints[] = (int)($sy + $r * sin($a));
    }
    imagefilledpolygon($imgEu, $starPoints, $goldStar);
}

ob_start();
imagepng($imgEu);
$euPngBase64 = base64_encode(ob_get_clean());
imagedestroy($imgEu);


// 3. FRENCH REPUBLIC / MINISTERE DES FINANCES EMBLEM - High Res 360x240
$w = 360; $h = 240;
$imgFr = imagecreatetruecolor($w, $h);
$frBlue = imagecolorallocate($imgFr, 0, 35, 149);   // Official Blue #002395
$frWhite = imagecolorallocate($imgFr, 255, 255, 255);
$frRed = imagecolorallocate($imgFr, 237, 41, 57);   // Official Red #ED2939
$navyText = imagecolorallocate($imgFr, 15, 23, 42);

// Tricolor stripes
imagefilledrectangle($imgFr, 0, 0, 119, $h, $frBlue);
imagefilledrectangle($imgFr, 120, 0, 239, $h, $frWhite);
imagefilledrectangle($imgFr, 240, 0, 359, $h, $frRed);

// Outer frame
imagerectangle($imgFr, 0, 0, $w-1, $h-1, $navyText);

// Official Text in white center section
imagestring($imgFr, 4, 135, 75, "R\xC9PUBLIQUE", $frBlue);
imagestring($imgFr, 4, 135, 100, "FRAN\xC7AISE", $frBlue);
imagestring($imgFr, 2, 128, 140, "MINIST\xC8RE DES FINANCES", $navyText);

ob_start();
imagepng($imgFr);
$frPngBase64 = base64_encode(ob_get_clean());
imagedestroy($imgFr);

$data = [
    'brand' => 'data:image/png;base64,' . $brandPngBase64,
    'eu'    => 'data:image/png;base64,' . $euPngBase64,
    'fr'    => 'data:image/png;base64,' . $frPngBase64,
];

file_put_contents(__DIR__ . '/pdf_logos.json', json_encode($data, JSON_PRETTY_PRINT));
echo "High-resolution PNG logos generated successfully.\n";
