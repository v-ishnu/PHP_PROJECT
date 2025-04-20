<!DOCTYPE html>
<html>
<head>
    <title>Text on Image Generator</title>
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
        <h1>Text on Image Generator</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Text to Display:</label>
                <input type="text" name="text" id="text" value="<?php echo htmlspecialchars($_POST['text'] ?? 'Sample Text'); ?>" required>
            </div>
            <div class="input-group">
                <label for="font_size">Font Size (10-100):</label>
                <input type="number" name="font_size" id="font_size" min="10" max="100" value="<?php echo htmlspecialchars($_POST['font_size'] ?? '30'); ?>" required>
            </div>
            <div class="input-group">
                <label for="text_color">Text Color: <span class="color-preview" style="background-color: <?php echo $_POST['text_color'] ?? '#ff0000'; ?>"></span></label>
                <input type="color" name="text_color" id="text_color" value="<?php echo $_POST['text_color'] ?? '#ff0000'; ?>" required>
            </div>
            <div class="input-group">
                <label for="bg_color">Background Color: <span class="color-preview" style="background-color: <?php echo $_POST['bg_color'] ?? '#ffffff'; ?>"></span></label>
                <input type="color" name="bg_color" id="bg_color" value="<?php echo $_POST['bg_color'] ?? '#ffffff'; ?>" required>
            </div>
            <div class="input-group">
                <label for="font">Font Style:</label>
                <select name="font" id="font">
                    <option value="arial" <?php echo (isset($_POST['font']) && $_POST['font'] === 'arial') ? 'selected' : ''; ?>>Arial</option>
                    <option value="times" <?php echo (isset($_POST['font']) && $_POST['font'] === 'times') ? 'selected' : ''; ?>>Times New Roman</option>
                    <option value="courier" <?php echo (isset($_POST['font']) && $_POST['font'] === 'courier') ? 'selected' : ''; ?>>Courier New</option>
                    <option value="verdana" <?php echo (isset($_POST['font']) && $_POST['font'] === 'verdana') ? 'selected' : ''; ?>>Verdana</option>
                </select>
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
            $fontSize = intval($_POST['font_size']);
            $textColorHex = ltrim($_POST['text_color'], '#');
            $bgColorHex = ltrim($_POST['bg_color'], '#');
            $font = $_POST['font'];

            // Convert hex colors to RGB
            $textColor = [
                'r' => hexdec(substr($textColorHex, 0, 2)),
                'g' => hexdec(substr($textColorHex, 2, 2)),
                'b' => hexdec(substr($textColorHex, 4, 2))
            ];

            $bgColor = [
                'r' => hexdec(substr($bgColorHex, 0, 2)),
                'g' => hexdec(substr($bgColorHex, 2, 2)),
                'b' => hexdec(substr($bgColorHex, 4, 2))
            ];

            // Create image (width based on text length)
            $imageWidth = strlen($text) * ($fontSize / 1.5) + 100;
            $imageHeight = $fontSize * 2 + 50;
            $image = imagecreatetruecolor($imageWidth, $imageHeight);

            // Allocate colors
            $textColorAlloc = imagecolorallocate($image, $textColor['r'], $textColor['g'], $textColor['b']);
            $bgColorAlloc = imagecolorallocate($image, $bgColor['r'], $bgColor['g'], $bgColor['b']);

            // Fill background
            imagefill($image, 0, 0, $bgColorAlloc);

            // Set font path based on selection
            switch ($font) {
                case 'arial':
                    $fontPath = 'fonts/arial.ttf';
                    break;
                case 'times':
                    $fontPath = 'fonts/times.ttf';
                    break;
                case 'courier':
                    $fontPath = 'fonts/cour.ttf';
                    break;
                case 'verdana':
                    $fontPath = 'fonts/verdana.ttf';
                    break;
                default:
                    $fontPath = 'fonts/arial.ttf';
            }

            // Use a fallback font if the selected one doesn't exist
            if (!file_exists($fontPath)) {
                $fontPath = 'arial.ttf'; // Let GD use its built-in font
            }

            // Calculate text position (centered)
            $textBox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $textBox[2] - $textBox[0];
            $textHeight = $textBox[1] - $textBox[7];
            $x = ($imageWidth - $textWidth) / 2;
            $y = ($imageHeight - $textHeight) / 2 + $textHeight;

            // Add text to image
            if (function_exists('imagettftext')) {
                imagettftext($image, $fontSize, 0, $x, $y, $textColorAlloc, $fontPath, $text);
            } else {
                imagestring($image, 5, 10, 10, $text, $textColorAlloc);
            }

            // Save image to file
            $filename = 'text_image_' . time() . '.png';
            imagepng($image, $filename);
            imagedestroy($image);

            // Display image
            echo '<div class="result">';
            echo '<h3>Generated Image</h3>';
            echo '<p>Text: ' . htmlspecialchars($text) . '</p>';
            echo '<p>Font: ' . ucfirst($font) . ' (' . $fontSize . 'px)</p>';
            echo '<img src="' . $filename . '" class="generated-image" alt="Text Image">';
            echo '<a href="' . $filename . '" download class="btn">Download Image</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
