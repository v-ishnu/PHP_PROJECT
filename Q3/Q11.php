<!DOCTYPE html>
<html>
<head>
    <title>Word Replacer</title>
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
            text-align: left;
            animation: fadeIn 0.5s ease;
            border-left: 4px solid #007bff;
        }
        .original-text {
            color: #6c757d;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .modified-text {
            color: #28a745;
            font-weight: 600;
        }
        .stats {
            margin-top: 15px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-size: clamp(12px, 2.5vw, 14px);
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
        <h1>Word Replacer</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Enter your text:</label>
                <textarea name="text" id="text" required><?php echo htmlspecialchars($_POST['text'] ?? ''); ?></textarea>
            </div>
            <div class="input-group">
                <label for="search_word">Word to replace:</label>
                <input type="text" name="search_word" id="search_word" value="<?php echo htmlspecialchars($_POST['search_word'] ?? ''); ?>" required>
            </div>
            <div class="input-group">
                <label for="replace_word">Replacement word:</label>
                <input type="text" name="replace_word" id="replace_word" value="<?php echo htmlspecialchars($_POST['replace_word'] ?? ''); ?>" required>
            </div>
            <input type="submit" name="submit" value="Replace Words">
        </form>

        <?php
        function replaceWords($text, $search, $replace) {
            // Case-sensitive word replacement with whole word matching
            $pattern = '/\b' . preg_quote($search, '/') . '\b/';
            $modifiedText = preg_replace($pattern, $replace, $text);

            // Count replacements
            preg_match_all($pattern, $text, $matches);
            $replacements = count($matches[0]);

            return [
                'modifiedText' => $modifiedText,
                'replacements' => $replacements,
                'originalText' => $text
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $search = $_POST['search_word'];
            $replace = $_POST['replace_word'];

            $result = replaceWords($text, $search, $replace);

            echo '<div class="result">';
            echo '<div class="original-text"><strong>Original text:</strong><br>' . nl2br(htmlspecialchars($result['originalText'])) . '</div>';
            echo '<div class="modified-text"><strong>Modified text:</strong><br>' . nl2br(htmlspecialchars($result['modifiedText'])) . '</div>';

            echo '<div class="stats">';
            echo 'Replacements made: <strong>' . $result['replacements'] . '</strong>';
            if ($result['replacements'] > 0) {
                echo ' (Changed "' . htmlspecialchars($search) . '" to "' . htmlspecialchars($replace) . '")';
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
