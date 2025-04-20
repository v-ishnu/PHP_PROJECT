<!DOCTYPE html>
<html>
<head>
    <title>Number Extractor</title>
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
            text-align: left;
            animation: fadeIn 0.5s ease;
            border-left: 4px solid #007bff;
        }
        .numbers-list {
            margin-top: 15px;
        }
        .number-item {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-family: monospace;
            font-size: 16px;
            color: #28a745;
            font-weight: 600;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-size: clamp(12px, 2.5vw, 14px);
        }
        .original-text {
            color: #6c757d;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
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
        <h1>Number Extractor</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="text">Enter your text:</label>
                <textarea name="text" id="text" required><?php echo htmlspecialchars($_POST['text'] ?? ''); ?></textarea>
            </div>
            <input type="submit" name="submit" value="Extract Numbers">
        </form>

        <?php
        function extractNumbers($text) {
            // Extract all numbers including decimals and negative numbers
            preg_match_all('/-?\d+\.?\d*/', $text, $matches);

            $numbers = array_map('floatval', $matches[0]);
            $count = count($numbers);
            $sum = array_sum($numbers);
            $average = $count > 0 ? $sum / $count : 0;

            return [
                'numbers' => $numbers,
                'count' => $count,
                'sum' => $sum,
                'average' => $average,
                'originalText' => $text
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['text'])) {
            $text = $_POST['text'];
            $result = extractNumbers($text);

            echo '<div class="result">';
            echo '<div class="original-text"><strong>Original text:</strong><br>' . nl2br(htmlspecialchars($result['originalText'])) . '</div>';

            if ($result['count'] > 0) {
                echo '<div><strong>Extracted numbers (' . $result['count'] . '):</strong></div>';
                echo '<div class="numbers-list">';
                foreach ($result['numbers'] as $number) {
                    echo '<span class="number-item">' . $number . '</span>';
                }
                echo '</div>';

                echo '<div class="summary">';
                echo 'Total numbers found: <strong>' . $result['count'] . '</strong><br>';
                echo 'Sum: <strong>' . $result['sum'] . '</strong><br>';
                echo 'Average: <strong>' . number_format($result['average'], 2) . '</strong>';
                echo '</div>';
            } else {
                echo '<div>No numbers found in the text.</div>';
            }

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
