<!DOCTYPE html>
<html>
<head>
    <title>Prime Number Checker</title>
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
        .container input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin: 5px 0;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
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
        }
        .prime {
            border-left: 4px solid #28a745;
        }
        .not-prime {
            border-left: 4px solid #dc3545;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prime Number Checker</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="number">Enter a Positive Integer:</label>
                <input type="number" name="number" id="number" min="2" required>
            </div>
            <input type="submit" name="submit" value="Check Prime">
        </form>

        <?php
        function isPrime($num) {
            if ($num <= 1) {
                return false;
            }
            if ($num <= 3) {
                return true;
            }
            if ($num % 2 == 0 || $num % 3 == 0) {
                return false;
            }
            $i = 5;
            while ($i * $i <= $num) {
                if ($num % $i == 0 || $num % ($i + 2) == 0) {
                    return false;
                }
                $i += 6;
            }
            return true;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $number = $_POST['number'];

            echo '<div class="result '.(isPrime($number) ? 'prime' : 'not-prime').'">';
            if (isPrime($number)) {
                echo "<p><strong>$number</strong> is a prime number.</p>";
            } else {
                echo "<p><strong>$number</strong> is not a prime number.</p>";
            }
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
