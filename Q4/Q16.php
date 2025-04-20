<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
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
        .container input[type="text"],
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
        .container input[type="text"]:focus,
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
        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .student-table th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .student-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .student-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .student-table tr:hover {
            background-color: #e9ecef;
        }
        .highlight {
            font-weight: 600;
            color: #28a745;
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .student-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Records</h1>

        <form method="post" action="">
            <div class="input-group">
                <label for="name">Student Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="input-group">
                <label for="math">Math Marks:</label>
                <input type="number" name="math" id="math" min="0" max="100" required>
            </div>
            <div class="input-group">
                <label for="science">Science Marks:</label>
                <input type="number" name="science" id="science" min="0" max="100" required>
            </div>
            <div class="input-group">
                <label for="english">English Marks:</label>
                <input type="number" name="english" id="english" min="0" max="100" required>
            </div>
            <input type="submit" name="submit" value="Add Student">
        </form>

        <?php
        session_start();

        // Initialize students array in session if not exists
        if (!isset($_SESSION['students'])) {
            $_SESSION['students'] = [];
        }

        // Add new student if form submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
            $newStudent = [
                'name' => $_POST['name'],
                'marks' => [
                    'Math' => $_POST['math'],
                    'Science' => $_POST['science'],
                    'English' => $_POST['english']
                ]
            ];

            array_push($_SESSION['students'], $newStudent);
        }

        // Function to calculate average
        function calculateAverage($marks) {
            return array_sum($marks) / count($marks);
        }

        // Display student records if any exist
        if (!empty($_SESSION['students'])) {
            echo '<div class="result">';
            echo '<table class="student-table">';
            echo '<thead><tr>
                    <th>Name</th>
                    <th>Math</th>
                    <th>Science</th>
                    <th>English</th>
                    <th>Average</th>
                  </tr></thead>';
            echo '<tbody>';

            foreach ($_SESSION['students'] as $student) {
                $average = calculateAverage($student['marks']);
                echo '<tr>';
                echo '<td>' . htmlspecialchars($student['name']) . '</td>';
                echo '<td>' . $student['marks']['Math'] . '</td>';
                echo '<td>' . $student['marks']['Science'] . '</td>';
                echo '<td>' . $student['marks']['English'] . '</td>';
                echo '<td class="highlight">' . number_format($average, 2) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
