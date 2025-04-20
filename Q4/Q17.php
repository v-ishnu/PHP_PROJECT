<!DOCTYPE html>
<html>
<head>
    <title>Array Merger</title>
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
            text-align: left;
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
        .array-title {
            font-weight: 600;
            color: #007bff;
            margin: 15px 0 5px 0;
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
        <h1>Array Merger</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="array1">First Array (comma separated):</label>
                <input type="text" name="array1" id="array1" value="<?php echo htmlspecialchars($_POST['array1'] ?? '1,2,3,4,5'); ?>" required>
            </div>
            <div class="input-group">
                <label for="array2">Second Array (comma separated):</label>
                <input type="text" name="array2" id="array2" value="<?php echo htmlspecialchars($_POST['array2'] ?? '4,5,6,7,8'); ?>" required>
            </div>
            <input type="submit" name="submit" value="Merge Arrays">
        </form>

        <?php
        function mergeAndRemoveDuplicates($array1, $array2) {
            // Convert comma-separated strings to arrays
            $arr1 = array_map('trim', explode(',', $array1));
            $arr2 = array_map('trim', explode(',', $array2));

            // Merge arrays
            $merged = array_merge($arr1, $arr2);

            // Remove duplicates
            $unique = array_unique($merged);

            // Re-index array
            $result = array_values($unique);

            return [
                'array1' => $arr1,
                'array2' => $arr2,
                'merged' => $result
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['array1'])) {
            $array1 = $_POST['array1'];
            $array2 = $_POST['array2'];
            $result = mergeAndRemoveDuplicates($array1, $array2);

            echo '<div class="result">';

            echo '<div class="array-title">First Array:</div>';
            echo '<div class="array-display">[' . implode(', ', $result['array1']) . ']</div>';

            echo '<div class="array-title">Second Array:</div>';
            echo '<div class="array-display">[' . implode(', ', $result['array2']) . ']</div>';

            echo '<div class="array-title">Merged Array (No Duplicates):</div>';
            echo '<div class="array-display">[' . implode(', ', $result['merged']) . ']</div>';

            echo '<div style="margin-top: 15px; font-size: smaller;">';
            echo 'Total elements in merged array: <strong>' . count($result['merged']) . '</strong>';
            echo '</div>';

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
