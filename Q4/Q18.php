<!DOCTYPE html>
<html>
<head>
    <title>Array Min/Max Finder</title>
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
            max-width: 500px;
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
        .array-display {
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
            word-break: break-all;
        }
        .minmax-result {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        .min-box, .max-box {
            padding: 15px;
            border-radius: 6px;
            font-weight: 600;
            font-size: clamp(16px, 3.5vw, 20px);
        }
        .min-box {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .max-box {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
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
            .minmax-result {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Array Min/Max Finder</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="array">Enter numbers (comma separated):</label>
                <input type="text" name="array" id="array" value="<?php echo htmlspecialchars($_POST['array'] ?? '7,3,9,2,5,1,8,4,6'); ?>" required>
            </div>
            <input type="submit" name="submit" value="Find Min & Max">
        </form>

        <?php
        function findMinMax($input) {
            // Convert input string to array of numbers
            $numbers = array_map('trim', explode(',', $input));
            $numbers = array_filter($numbers, 'is_numeric');
            $numbers = array_map('floatval', $numbers);

            if (empty($numbers)) {
                return false;
            }

            // Initialize min and max with first element
            $min = $numbers[0];
            $max = $numbers[0];

            // Find min and max without using built-in functions
            foreach ($numbers as $number) {
                if ($number < $min) {
                    $min = $number;
                }
                if ($number > $max) {
                    $max = $number;
                }
            }

            return [
                'numbers' => $numbers,
                'min' => $min,
                'max' => $max
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['array'])) {
            $input = $_POST['array'];
            $result = findMinMax($input);

            echo '<div class="result">';

            if ($result === false) {
                echo '<div>Please enter valid numbers.</div>';
            } else {
                echo '<div class="array-title">Your Array:</div>';
                echo '<div class="array-display">[' . implode(', ', $result['numbers']) . ']</div>';

                echo '<div class="minmax-result">';
                echo '<div class="min-box">';
                echo '<div>Minimum Value</div>';
                echo '<div>' . $result['min'] . '</div>';
                echo '</div>';

                echo '<div class="max-box">';
                echo '<div>Maximum Value</div>';
                echo '<div>' . $result['max'] . '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div style="margin-top: 15px; font-size: smaller;">';
                echo 'Array contains ' . count($result['numbers']) . ' numbers.';
                echo '</div>';
            }

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
