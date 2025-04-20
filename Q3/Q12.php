<!DOCTYPE html>
<html>
<head>
    <title>Character Frequency Counter</title>
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
            max-width: 400px;
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
        .container textarea {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: clamp(14px, 3vw, 16px);
            transition: border 0.3s ease;
            box-sizing: border-box;
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }
        .container input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: clamp(14px, 3vw, 16px);
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        .container textarea:focus,
        .container input[type="text"]:focus {
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
        .frequency-result {
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            color: #28a745;
            margin: 15px 0;
        }
        .char-display {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-family: monospace;
            font-size: 20px;
        }
        .text-preview {
            margin-top: 15px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-size: clamp(12px, 2.5vw, 14px);
            text-align: left;
            max-height: 150px;
            overflow-y: auto;
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
        <h1>Character Frequency Counter</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Enter your text:</label>
                <textarea name="text" id="text" required><?php echo htmlspecialchars($_POST['text'] ?? ''); ?></textarea>
            </div>
            <div class="input-group">
                <label for="character">Character to count:</label>
                <input type="text" name="character" id="character" maxlength="1" value="<?php echo htmlspecialchars($_POST['character'] ?? ''); ?>" required>
            </div>
            <input type="submit" name="submit" value="Count Character">
        </form>

        <?php
        function countCharacterFrequency($text, $char) {
            // Case-sensitive character counting
            $count = substr_count($text, $char);

            // For case-insensitive counting, use:
            // $count = substr_count(strtolower($text), strtolower($char));

            return $count;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $char = $_POST['character'];

            // Ensure we only take the first character if more than one was entered
            $char = substr($char, 0, 1);

            $frequency = countCharacterFrequency($text, $char);

            echo '<div class="result">';

            echo '<div>The character <span class="char-display">' . htmlspecialchars($char) . '</span> appears</div>';
            echo '<div class="frequency-result">' . $frequency . '</div>';
            echo '<div>time' . ($frequency !== 1 ? 's' : '') . ' in the text</div>';

            if ($frequency > 0) {
                echo '<div class="text-preview">';
                echo '<strong>Text preview:</strong><br>';
                echo nl2br(htmlspecialchars($text));
                echo '</div>';
            }

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
