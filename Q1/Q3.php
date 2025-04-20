<!DOCTYPE html>
<html>
<head>
    <title>String Reverser</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #514313;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            width: 350px;
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 25px;
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
            font-size: 14px;
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
            font-size: 14px;
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
            font-size: 15px;
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
            margin-top: 25px;
            padding: 15px;
            border-radius: 6px;
            background-color: #f8f9fa;
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
            animation: fadeIn 0.5s ease;
            border-left: 4px solid #007bff;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>String Reverser</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="inputString">Enter a String:</label>
                <input type="text" name="inputString" id="inputString" required>
            </div>
            <input type="submit" name="submit" value="Reverse String">
        </form>

        <?php
        function reverseString($str) {
            $reversed = '';
            $length = 0;

            // Calculate string length without using strlen()
            while (isset($str[$length])) {
                $length++;
            }

            // Reverse the string manually
            for ($i = $length - 1; $i >= 0; $i--) {
                $reversed .= $str[$i];
            }

            return $reversed;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $inputString = $_POST['inputString'];
            $reversedString = reverseString($inputString);

            echo '<div class="result">';
            echo "<p><strong>Original String:</strong> $inputString</p>";
            echo "<p><strong>Reversed String:</strong> $reversedString</p>";
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
