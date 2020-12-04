<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>image-to-ascii-php</title>
</head>
<body class="white">
    <h1 class="title">image-to-ascii-php demo</h1>
    <?php
        // Image to ASCII demo starts here!
        include_once "image-to-ascii.php";
        $asciiPalette = array("H", "X", "O", "Y", "I", "l", "i", ";", ":", ",", ".", "&nbsp;");
        imageToASCII("image.png", $asciiPalette, false);
    ?>
    <div class="footer">
        <p>Some footer info here...</p>
    </div>
</body>
</html>