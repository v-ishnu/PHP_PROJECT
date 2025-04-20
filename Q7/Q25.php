<!DOCTYPE html>
<html>
<head>
    <title>GD Image Generator</title>
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
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #0069d9;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
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
        <h1>GD Image Generator</h1>

        <?php
        // Check if GD library is installed
        if (!extension_loaded('gd')) {
            echo '<div class="result error">GD library is not installed. Please install it to generate images.</div>';
            echo '<div class="result warning">On Arch Linux, run: <code>sudo pacman -S php-gd</code></div>';
            exit;
        }

        // Generate image when page loads
        $image = imagecreatetruecolor(400, 400);

        // Allocate colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $red = imagecolorallocate($image, 255, 0, 0);
        $green = imagecolorallocate($image, 0, 255, 0);
        $blue = imagecolorallocate($image, 0, 0, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Fill background
        imagefill($image, 0, 0, $white);

        // Draw shapes
        imagerectangle($image, 50, 50, 150, 150, $red); // Rectangle
        imageellipse($image, 300, 100, 100, 100, $green); // Circle
        imageline($image, 200, 200, 350, 350, $blue); // Line

        // Add text
        imagestring($image, 5, 150, 380, 'GD Library Demo', $black);

        // Save image to file
        $filename = 'generated_image_' . time() . '.png';
        imagepng($image, $filename);
        imagedestroy($image);

        // Display image
        echo '<div class="result">';
        echo '<h3>Generated Image (400×400px)</h3>';
        echo '<img src="' . $filename . '" class="generated-image" alt="GD Generated Image">';
        echo '<p>Shapes drawn: Rectangle (red), Circle (green), Line (blue)</p>';
        echo '<a href="' . $filename . '" download class="btn">Download Image</a>';
        echo '</div>';
        ?>
    </div>
</body>
</html>
