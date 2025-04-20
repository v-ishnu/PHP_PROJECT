<!DOCTYPE html>
<html>
<head>
    <title>Image Uploader</title>
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
            margin-bottom: 20px;
            text-align: left;
        }
        .container label {
            font-size: clamp(14px, 3vw, 16px);
            color: #555;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .container input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: clamp(14px, 3vw, 16px);
            transition: border 0.3s ease;
            box-sizing: border-box;
            background-color: white;
        }
        .container input[type="file"]:focus {
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
        .uploaded-image {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-top: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .image-container {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .error {
            color: #dc3545;
            font-weight: 600;
        }
        .warning {
            color: #fd7e14;
            font-weight: 600;
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
            .image-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Uploader</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="input-group">
                <label for="image">Select Image (JPG, PNG, GIF - Max 2MB):</label>
                <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif" required>
            </div>
            <input type="submit" name="submit" value="Upload Image">
        </form>

        <?php
        // Image upload directory
        $uploadDir = 'uploads/';

        // Check and create directory with proper permissions
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                echo '<div class="result error">Failed to create upload directory. Check permissions.</div>';
                exit;
            }
            echo '<div class="result success">Created upload directory successfully.</div>';
        } elseif (!is_writable($uploadDir)) {
            echo '<div class="result error">Upload directory is not writable. Check permissions.</div>';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
            $file = $_FILES['image'];

            // Upload error messages
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'File is too large (server limit)',
                UPLOAD_ERR_FORM_SIZE => 'File is too large (form limit)',
                UPLOAD_ERR_PARTIAL => 'File upload was incomplete',
                UPLOAD_ERR_NO_FILE => 'No file was selected',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by PHP extension'
            ];

            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errorMsg = $uploadErrors[$file['error']] ?? 'Unknown upload error (Code: '.$file['error'].')';
                echo '<div class="result error">Upload error: ' . $errorMsg . '</div>';

                // Show server configuration for debugging
                echo '<div class="result warning">';
                echo 'Server Limits:<br>';
                echo 'Upload Max: ' . ini_get('upload_max_filesize') . '<br>';
                echo 'Post Max: ' . ini_get('post_max_size') . '<br>';
                echo 'Temp Dir: ' . sys_get_temp_dir() . '<br>';
                echo '</div>';

                exit;
            }

            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];

            // Get file extension
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Allowed file types
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowed)) {
                if ($fileSize < 2097152) { // 2MB limit
                    // Generate unique filename
                    $newFileName = uniqid('', true) . '.' . $fileExt;
                    $fileDest = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmp, $fileDest)) {
                        echo '<div class="result success">Image uploaded successfully!</div>';
                        echo '<div class="result">';
                        echo '<h3>Your Uploaded Image:</h3>';
                        echo '<img src="' . $fileDest . '" class="uploaded-image" alt="Uploaded Image">';
                        echo '</div>';
                    } else {
                        echo '<div class="result error">Failed to move uploaded file. Check directory permissions.</div>';
                        echo '<div class="result warning">';
                        echo 'Troubleshooting:<br>';
                        echo '- Check if uploads/ directory exists<br>';
                        echo '- Verify directory permissions (should be 755)<br>';
                        echo '- Check available disk space';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="result error">File is too large (max 2MB). Your file: ' . round($fileSize/1024/1024, 2) . 'MB</div>';
                }
            } else {
                echo '<div class="result error">Invalid file type. Only JPG, PNG, GIF allowed. Your file: .' . $fileExt . '</div>';
            }
        }

        // Display all uploaded images
        $images = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        if (!empty($images)) {
            echo '<div class="result">';
            echo '<h3>Previously Uploaded Images:</h3>';
            echo '<div class="image-grid">';
            foreach ($images as $image) {
                echo '<div class="image-container">';
                echo '<img src="' . $image . '" class="uploaded-image" alt="Uploaded Image">';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="result">No images have been uploaded yet.</div>';
        }
        ?>
    </div>
</body>
</html>
