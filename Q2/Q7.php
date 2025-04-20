<!DOCTYPE html>
<html>
<head>
    <title>Recursive Factorial Calculator</title>
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
            max-width: 800px;
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
            overflow-x: auto;
            white-space: nowrap;
        }
        .factorial-result {
            font-size: clamp(16px, 3.5vw, 18px);
            font-weight: 600;
            color: #28a745;
            margin: 10px 0;
            overflow-x: auto;
            white-space: nowrap;
        }
        .calculation-steps {
            margin-top: 15px;
            font-family: monospace;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
            font-size: clamp(12px, 2.5vw, 14px);
            text-align: left;
            overflow-x: auto;
            white-space: pre;
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
            .calculation-steps {
                padding: 8px;
                font-size: 12px;
                white-space: pre;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recursive Factorial Calculator</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="number">Enter a non-negative integer:</label>
                <input type="number" name="number" id="number" min="0" max="50" required>
            </div>
            <input type="submit" name="submit" value="Calculate Factorial">
        </form>

        <?php
        function recursiveFactorial($n) {
            // Base case: factorial of 0 is 1
            if ($n == 0) {
                return 1;
            }
            // Recursive case: n! = n * (n-1)!
            else {
                return $n * recursiveFactorial($n - 1);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $number = isset($_POST['number']) ? (int)$_POST['number'] : 0;

            echo '<div class="result">';

            // Validate input
            if ($number < 0) {
                echo "<p>Please enter a non-negative integer.</p>";
            } elseif ($number > 50) {
                echo "<p>Please enter a number ≤ 50 for better performance.</p>";
            } else {
                $result = recursiveFactorial($number);

                echo "<p>Factorial of <strong>$number</strong> is:</p>";
                echo '<div class="factorial-result">'.$number.'! = '.number_format($result).'</div>';

                // Show recursive steps for numbers <= 10
                if ($number <= 10) {
                    echo '<div class="calculation-steps">';
                    echo "<p>Recursive steps:</p>";
                    echo "<div>".buildRecursiveSteps($number)."</div>";
                    echo '</div>';
                }
            }

            echo '</div>';
        }

        // Helper function to show recursive steps
        function buildRecursiveSteps($n, $depth = 0) {
            $indent = str_repeat("&nbsp;&nbsp;", $depth * 2);

            if ($n == 0) {
                return $indent . "factorial(0) returns 1 (base case)<br>";
            }

            $current = $indent . "factorial($n) calls factorial(" . ($n-1) . ")<br>";
            $recursive = buildRecursiveSteps($n-1, $depth+1);
            $return = $indent . "factorial($n) returns $n × " . recursiveFactorial($n-1) . " = " . recursiveFactorial($n) . "<br>";

            return $current . $recursive . $return;
        }
        ?>
    </div>
</body>
</html>
