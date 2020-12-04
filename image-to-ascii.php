<?php

function imageToASCII($src ='image.png', $asciiPalette = array("&nbsp;", ".", ",", ":", ";", "i", "I", "O"), $paletteInvert = false) {

    // 1. Errors?

    if (!file_exists($src) 
        || !function_exists("gd_info")
        || !is_array($asciiPalette)
        || !sizeof($asciiPalette) > 0
    ) {
        echo '<p class="error">Error!</p>';
        return;
    }

    // 2. Open the image.

    $img = false;
    $imgType = exif_imagetype($src);
    if ($imgType === IMAGETYPE_JPEG) {
        $img = @imagecreatefromjpeg($src);
    } else if ($imgType === IMAGETYPE_PNG) {
        $img = @imagecreatefrompng($src);
    }
    if (!$img) {
        echo '<p class="error">Error!</p>';
        return;
    }

    // 3. Get image dimentions.

    $imgWidth = imagesx($img);
    $imgHeight = imagesy($img);
    $imgRatio = $imgWidth / $imgHeight;
    $imgOrientation = "portrait";
    if ($imgRatio >= 1) {
        $imgOrientation = "landscape";
    }
    $imgDimensions = "$imgWidth &times; $imgHeight px";

    // 4. Process the image.

    $ascii = '';
    if ($paletteInvert) {
        $asciiPalette = array_reverse($asciiPalette);
    }
    $asciiPaletteSize = sizeof($asciiPalette);
    for ($y = 0; $y < $imgHeight; $y++) {
        for ($x = 0; $x < $imgWidth; $x++) {
            $pixelColor = imagecolorat($img, $x, $y);
            $r = ($pixelColor >> 16) & 0xFF;
            $g = ($pixelColor >> 8) & 0xFF;
            $b = $pixelColor & 0xFF;
            $grey = round(($r + $g + $b) / 3);
            $asciiPaletteIndex = (int)floor($grey / (256 / $asciiPaletteSize));
            $asciiPixel = $asciiPalette[$asciiPaletteIndex];
            $ascii .= "$asciiPixel";
        }
        $ascii .= "<br>";
    }

    // 5. Output ASCII.

    $output =   "<p>Converting <a href=\"$src\">$src</a> ($imgDimensions) into $asciiPaletteSize character ASCII palette...<p>"
                . "<p>(" . implode('&nbsp;', $asciiPalette) . ")</p>"
                . "<div class=\"output\">"
                    . "<div class=\"ascii $imgOrientation\">"
                        . $ascii
                    . "</div>"
                . "</div>"
                . "<p>Done!</p>";
    echo $output;
    
}

?>