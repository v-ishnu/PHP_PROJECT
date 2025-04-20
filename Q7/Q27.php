<!DOCTYPE html>
<html>
<head>
    <title>Image Resizer</title>
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
        .container input[type="file"],
        .container input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: clamp(14px, 3vw, 16px);
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        .container input[type="file"]:focus,
        .container input[type="number"]:focus {
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
        .image-comparison {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .image-container {
            margin: 10px;
            text-align: center;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .image-caption {
            margin-top: 8px;
            font-size: 14px;
            color: #666;
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
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .error {
            color: #dc3545;
            font-weight: 600;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .image-comparison {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Resizer</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="input-group">
                <label for="image">Select Image (JPG, PNG, GIF - Max 5MB):</label>
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif" required>
            </div>
            <div class="input-group">
                <label for="width">Target Width (pixels):</label>
                <input type="number" name="width" id="width" min="50" max="2000" value="<?php echo htmlspecialchars($_POST['width'] ?? '800'); ?>" required>
            </div>
            <div class="input-group">
                <label for="height">Target Height (pixels):</label>
                <input type="number" name="height" id="height" min="50" max="2000" value="<?php echo htmlspecialchars($_POST['height'] ?? '600'); ?>" required>
            </div>
            <input type="submit" name="submit" value="Resize Image">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
            // Check if GD library is installed
            if (!extension_loaded('gd')) {
                echo '<div class="result error">GD library is not installed. Please install it to resize images.</div>';
                echo '<div class="result warning">On Arch Linux, run: <code>sudo pacman -S php-gd</code></div>';
                exit;
            }

            // File upload handling
            $file = $_FILES['image'];
            $targetWidth = intval($_POST['width']);
            $targetHeight = intval($_POST['height']);

            // Validate dimensions
            if ($targetWidth < 50 || $targetWidth > 2000 || $targetHeight < 50 || $targetHeight > 2000) {
                echo '<div class="result error">Dimensions must be between 50 and 2000 pixels.</div>';
                exit;
            }

            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $uploadErrors = [
                    UPLOAD_ERR_INI_SIZE => 'File is too large (server limit)',
                    UPLOAD_ERR_FORM_SIZE => 'File is too large (form limit)',
                    UPLOAD_ERR_PARTIAL => 'File upload was incomplete',
                    UPLOAD_ERR_NO_FILE => 'No file was selected',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk',
                    UPLOAD_ERR_EXTENSION => 'File upload stopped by PHP extension'
                ];
                $errorMsg = $uploadErrors[$file['error']] ?? 'Unknown upload error';
                echo '<div class="result error">Upload error: ' . $errorMsg . '</div>';
                exit;
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($file['tmp_name']);
            if (!in_array($fileType, $allowedTypes)) {
                echo '<div class="result error">Invalid file type. Only JPG, PNG, and GIF are allowed.</div>';
                exit;
            }

            // Create upload directory if needed
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    echo '<div class="result error">Failed to create upload directory. Check permissions.</div>';
                    exit;
                }
            }

            // Process the image
            try {
                // Get original image dimensions
                list($originalWidth, $originalHeight) = getimagesize($file['tmp_name']);

                // Calculate new dimensions maintaining aspect ratio
                $ratio = $originalWidth / $originalHeight;
                if ($targetWidth / $targetHeight > $ratio) {
                    $targetWidth = $targetHeight * $ratio;
                } else {
                    $targetHeight = $targetWidth / $ratio;
                }

                // Create image resource based on file type
                switch ($fileType) {
                    case 'image/jpeg':
                        $source = imagecreatefromjpeg($file['tmp_name']);
                        break;
                    case 'image/png':
                        $source = imagecreatefrompng($file['tmp_name']);
                        break;
                    case 'image/gif':
                        $source = imagecreatefromgif($file['tmp_name']);
                        break;
                    default:
                        throw new Exception('Unsupported image type');
                }

                // Create new image
                $destination = imagecreatetruecolor($targetWidth, $targetHeight);

                // Preserve transparency for PNG and GIF
                if ($fileType == 'image/png' || $fileType == 'image/gif') {
                    imagecolortransparent($destination, imagecolorallocatealpha($destination, 0, 0, 0, 127));
                    imagealphablending($destination, false);
                    imagesavealpha($destination, true);
                }

                // Resize the image
                imagecopyresampled(
                    $destination, $source,
                    0, 0, 0, 0,
                    $targetWidth, $targetHeight,
                    $originalWidth, $originalHeight
                );

                // Save the resized image
                $originalFilename = pathinfo($file['name'], PATHINFO_FILENAME);
                $resizedFilename = $uploadDir . $originalFilename . '_resized_' . time() . '.jpg';

                // Save based on original format for better quality
                switch ($fileType) {
                    case 'image/jpeg':
                        imagejpeg($destination, $resizedFilename, 90);
                        break;
                    case 'image/png':
                        imagepng($destination, $resizedFilename, 9);
                        break;
                    case 'image/gif':
                        imagegif($destination, $resizedFilename);
                        break;
                }

                // Save original for comparison
                $originalFilename = $uploadDir . $originalFilename . '_original_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                move_uploaded_file($file['tmp_name'], $originalFilename);

                // Free up memory
                imagedestroy($source);
                imagedestroy($destination);

                // Display results
                echo '<div class="result success">Image resized successfully while maintaining aspect ratio!</div>';
                echo '<div class="result">';
                echo '<div class="image-comparison">';

                echo '<div class="image-container">';
                echo '<img src="' . $originalFilename . '" alt="Original Image">';
                echo '<div class="image-caption">Original: ' . $originalWidth . '×' . $originalHeight . 'px</div>';
                echo '</div>';

                echo '<div class="image-container">';
                echo '<img src="' . $resizedFilename . '" alt="Resized Image">';
                echo '<div class="image-caption">Resized: ' . round($targetWidth) . '×' . round($targetHeight) . 'px</div>';
                echo '</div>';

                echo '</div>';
                echo '<a href="' . $resizedFilename . '" download class="btn">Download Resized Image</a>';
                echo '</div>';

            } catch (Exception $e) {
                echo '<div class="result error">Error processing image: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
