<!DOCTYPE html>
<html>
<head>
    <title>Gradient Image Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #514313;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 100%;
            max-width: 600px;
            transition: transform 0.3s ease;
            box-sizing: border-box;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        .container h1 {
            font-size: clamp(20px, 4vw, 24px);
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }
        .container h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #007bff;
            border-radius: 3px;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .container label {
            font-size: clamp(14px, 3vw, 16px);
            color: #555;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .container input[type="text"],
        .container input[type="number"],
        .container input[type="color"],
        .container select {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: clamp(14px, 3vw, 16px);
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        .container input[type="text"]:focus,
        .container input[type="number"]:focus,
        .container select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        .container input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: clamp(14px, 3vw, 16px);
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .container input[type="submit"]:hover {
            background-color: #0069d9;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
            background-color: #f8f9fa;
            font-size: clamp(14px, 3vw, 16px);
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
            animation: fadeIn 0.5s ease;
            border-left: 4px solid #007bff;
        }
        .generated-image {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-top: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: clamp(14px, 3vw, 16px);
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #218838;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
        }
        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-left: 10px;
            vertical-align: middle;
            border: 1px solid #ddd;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            .result {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gradient Image Generator</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Text to Display:</label>
                <input type="text" name="text" id="text" value="<?php echo htmlspecialchars($_POST['text'] ?? 'Gradient Text'); ?>" required>
            </div>
            <div class="input-group">
                <label for="width">Image Width (400-1200px):</label>
                <input type="number" name="width" id="width" min="400" max="1200" value="<?php echo htmlspecialchars($_POST['width'] ?? '800'); ?>" required>
            </div>
            <div class="input-group">
                <label for="height">Image Height (200-800px):</label>
                <input type="number" name="height" id="height" min="200" max="800" value="<?php echo htmlspecialchars($_POST['height'] ?? '400'); ?>" required>
            </div>
            <div class="input-group">
                <label for="gradient_start">Gradient Start Color: <span class="color-preview" style="background-color: <?php echo $_POST['gradient_start'] ?? '#1e5799'; ?>"></span></label>
                <input type="color" name="gradient_start" id="gradient_start" value="<?php echo $_POST['gradient_start'] ?? '#1e5799'; ?>" required>
            </div>
            <div class="input-group">
                <label for="gradient_end">Gradient End Color: <span class="color-preview" style="background-color: <?php echo $_POST['gradient_end'] ?? '#7db9e8'; ?>"></span></label>
                <input type="color" name="gradient_end" id="gradient_end" value="<?php echo $_POST['gradient_end'] ?? '#7db9e8'; ?>" required>
            </div>
            <div class="input-group">
                <label for="gradient_direction">Gradient Direction:</label>
                <select name="gradient_direction" id="gradient_direction">
                    <option value="horizontal" <?php echo (isset($_POST['gradient_direction']) && $_POST['gradient_direction'] === 'horizontal') ? 'selected' : ''; ?>>Horizontal</option>
                    <option value="vertical" <?php echo (isset($_POST['gradient_direction']) && $_POST['gradient_direction'] === 'vertical') ? 'selected' : ''; ?>>Vertical</option>
                    <option value="diagonal" <?php echo (isset($_POST['gradient_direction']) && $_POST['gradient_direction'] === 'diagonal') ? 'selected' : ''; ?>>Diagonal</option>
                    <option value="radial" <?php echo (isset($_POST['gradient_direction']) && $_POST['gradient_direction'] === 'radial') ? 'selected' : ''; ?>>Radial</option>
                </select>
            </div>
            <div class="input-group">
                <label for="text_color1">Text Color 1: <span class="color-preview" style="background-color: <?php echo $_POST['text_color1'] ?? '#ffffff'; ?>"></span></label>
                <input type="color" name="text_color1" id="text_color1" value="<?php echo $_POST['text_color1'] ?? '#ffffff'; ?>" required>
            </div>
            <div class="input-group">
                <label for="text_color2">Text Color 2: <span class="color-preview" style="background-color: <?php echo $_POST['text_color2'] ?? '#ff0000'; ?>"></span></label>
                <input type="color" name="text_color2" id="text_color2" value="<?php echo $_POST['text_color2'] ?? '#ff0000'; ?>" required>
            </div>
            <div class="input-group">
                <label for="font_size">Font Size (20-100px):</label>
                <input type="number" name="font_size" id="font_size" min="20" max="100" value="<?php echo htmlspecialchars($_POST['font_size'] ?? '48'); ?>" required>
            </div>
            <input type="submit" name="submit" value="Generate Image">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
            // Check if GD library is installed
            if (!extension_loaded('gd')) {
                echo '<div class="result error">GD library is not installed. Please install it to generate images.</div>';
                echo '<div class="result warning">On Arch Linux, run: <code>sudo pacman -S php-gd</code></div>';
                exit;
            }

            // Get form values
            $text = $_POST['text'];
            $width = intval($_POST['width']);
            $height = intval($_POST['height']);
            $gradientStart = $_POST['gradient_start'];
            $gradientEnd = $_POST['gradient_end'];
            $gradientDirection = $_POST['gradient_direction'];
            $textColor1 = $_POST['text_color1'];
            $textColor2 = $_POST['text_color2'];
            $fontSize = intval($_POST['font_size']);

            // Create image
            $image = imagecreatetruecolor($width, $height);

            // Convert hex colors to RGB
            function hex2rgb($hex) {
                $hex = str_replace('#', '', $hex);
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                return [$r, $g, $b];
            }

            list($r1, $g1, $b1) = hex2rgb($gradientStart);
            list($r2, $g2, $b2) = hex2rgb($gradientEnd);

            // Create gradient background
            function createGradient($img, $w, $h, $r1, $g1, $b1, $r2, $g2, $b2, $direction) {
                switch($direction) {
                    case 'horizontal':
                        for ($i = 0; $i < $w; $i++) {
                            $r = $r1 + ($r2 - $r1) * ($i / $w);
                            $g = $g1 + ($g2 - $g1) * ($i / $w);
                            $b = $b1 + ($b2 - $b1) * ($i / $w);
                            $color = imagecolorallocate($img, $r, $g, $b);
                            imageline($img, $i, 0, $i, $h, $color);
                        }
                        break;
                    case 'vertical':
                        for ($i = 0; $i < $h; $i++) {
                            $r = $r1 + ($r2 - $r1) * ($i / $h);
                            $g = $g1 + ($g2 - $g1) * ($i / $h);
                            $b = $b1 + ($b2 - $b1) * ($i / $h);
                            $color = imagecolorallocate($img, $r, $g, $b);
                            imageline($img, 0, $i, $w, $i, $color);
                        }
                        break;
                    case 'diagonal':
                        for ($i = 0; $i < $w; $i++) {
                            for ($j = 0; $j < $h; $j++) {
                                $r = $r1 + ($r2 - $r1) * (($i + $j) / ($w + $h));
                                $g = $g1 + ($g2 - $g1) * (($i + $j) / ($w + $h));
                                $b = $b1 + ($b2 - $b1) * (($i + $j) / ($w + $h));
                                $color = imagecolorallocate($img, $r, $g, $b);
                                imagesetpixel($img, $i, $j, $color);
                            }
                        }
                        break;
                    case 'radial':
                        $centerX = $w / 2;
                        $centerY = $h / 2;
                        $maxDist = sqrt(pow($centerX, 2) + pow($centerY, 2));

                        for ($i = 0; $i < $w; $i++) {
                            for ($j = 0; $j < $h; $j++) {
                                $dist = sqrt(pow($i - $centerX, 2) + pow($j - $centerY, 2));
                                $ratio = $dist / $maxDist;
                                $r = $r1 + ($r2 - $r1) * $ratio;
                                $g = $g1 + ($g2 - $g1) * $ratio;
                                $b = $b1 + ($b2 - $b1) * $ratio;
                                $color = imagecolorallocate($img, $r, $g, $b);
                                imagesetpixel($img, $i, $j, $color);
                            }
                        }
                        break;
                }
            }

            createGradient($image, $width, $height, $r1, $g1, $b1, $r2, $g2, $b2, $gradientDirection);

            // Allocate text colors
            list($tr1, $tg1, $tb1) = hex2rgb($textColor1);
            list($tr2, $tg2, $tb2) = hex2rgb($textColor2);
            $textColor1 = imagecolorallocate($image, $tr1, $tg1, $tb1);
            $textColor2 = imagecolorallocate($image, $tr2, $tg2, $tb2);

            // Add text with alternating colors
            $font = 'arial.ttf'; // Default font (use a TTF font file)
            $textParts = explode(' ', $text);
            $x = 20;
            $y = $height / 2 + $fontSize / 3;

            foreach ($textParts as $index => $part) {
                $color = ($index % 2 == 0) ? $textColor1 : $textColor2;

                // Calculate text width
                $bbox = imagettfbbox($fontSize, 0, $font, $part . ' ');
                $textWidth = $bbox[2] - $bbox[0];

                // Add text to image
                imagettftext($image, $fontSize, 0, $x, $y, $color, $font, $part . ' ');

                // Move x position for next word
                $x += $textWidth;
            }

            // Save image to file
            $filename = 'gradient_image_' . time() . '.png';
            imagepng($image, $filename);
            imagedestroy($image);

            // Display image
            echo '<div class="result">';
            echo '<h3>Generated Gradient Image</h3>';
            echo '<img src="' . $filename . '" class="generated-image" alt="Gradient Image">';
            echo '<a href="' . $filename . '" download class="btn">Download Image</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
