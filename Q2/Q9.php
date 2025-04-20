<!DOCTYPE html>
<html>
<head>
    <title>Temperature Converter</title>
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
        .container select {
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
            overflow-x: auto;
        }
        .conversion-result {
            font-size: clamp(16px, 3.5vw, 18px);
            font-weight: 600;
            color: #28a745;
            margin: 10px 0;
            overflow-x: auto;
            white-space: nowrap;
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
        <h1>Temperature Converter</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="temperature">Enter temperature:</label>
                <input type="number" name="temperature" id="temperature" step="0.01" required>
            </div>
            <div class="input-group">
                <label for="conversion_type">Convert from:</label>
                <select name="conversion_type" id="conversion_type" required>
                    <option value="c_to_f">Celsius to Fahrenheit</option>
                    <option value="f_to_c">Fahrenheit to Celsius</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Convert">
        </form>

        <?php
        function convertTemperature($temp, $type) {
            if ($type === 'c_to_f') {
                return ($temp * 9/5) + 32;
            } else {
                return ($temp - 32) * 5/9;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $temperature = isset($_POST['temperature']) ? (float)$_POST['temperature'] : 0;
            $conversionType = $_POST['conversion_type'] ?? 'c_to_f';

            $convertedTemp = convertTemperature($temperature, $conversionType);
            $fromUnit = ($conversionType === 'c_to_f') ? '°C' : '°F';
            $toUnit = ($conversionType === 'c_to_f') ? '°F' : '°C';
            $conversionText = ($conversionType === 'c_to_f') ? 'Celsius to Fahrenheit' : 'Fahrenheit to Celsius';

            echo '<div class="result">';
            echo '<p>Temperature conversion (' . $conversionText . '):</p>';
            echo '<div class="conversion-result">';
            echo number_format($temperature, 2) . $fromUnit . ' = ' . number_format($convertedTemp, 2) . $toUnit;
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
