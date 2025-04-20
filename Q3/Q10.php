<!DOCTYPE html>
<html>
<head>
    <title>Text Analyzer</title>
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
        .container textarea:focus {
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
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
            text-align: left;
        }
        .stat-item {
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .stat-value {
            font-weight: 600;
            color: #28a745;
            font-size: clamp(16px, 3.5vw, 18px);
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
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Text Analyzer</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Enter your text:</label>
                <textarea name="text" id="text" required><?php echo $_POST['text'] ?? ''; ?></textarea>
            </div>
            <input type="submit" name="submit" value="Analyze Text">
        </form>

        <?php
        function analyzeText($text) {
            $results = [];

            // Count characters (including spaces)
            $results['characters'] = mb_strlen($text);

            // Count characters (excluding spaces)
            $results['characters_no_spaces'] = mb_strlen(str_replace(' ', '', $text));

            // Count words
            $results['words'] = str_word_count($text);

            // Count vowels
            $vowels = ['a', 'e', 'i', 'o', 'u'];
            $results['vowels'] = 0;
            $textLower = mb_strtolower($text);

            foreach ($vowels as $vowel) {
                $results['vowels'] += mb_substr_count($textLower, $vowel);
            }

            return $results;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $results = analyzeText($text);

            echo '<div class="result">';
            echo '<p>Text Analysis Results:</p>';
            echo '<div class="stats">';
            echo '<div class="stat-item">';
            echo '<div>Total Characters:</div>';
            echo '<div class="stat-value">' . $results['characters'] . '</div>';
            echo '</div>';

            echo '<div class="stat-item">';
            echo '<div>Characters (no spaces):</div>';
            echo '<div class="stat-value">' . $results['characters_no_spaces'] . '</div>';
            echo '</div>';

            echo '<div class="stat-item">';
            echo '<div>Word Count:</div>';
            echo '<div class="stat-value">' . $results['words'] . '</div>';
            echo '</div>';

            echo '<div class="stat-item">';
            echo '<div>Vowel Count:</div>';
            echo '<div class="stat-value">' . $results['vowels'] . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
