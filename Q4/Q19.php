<!DOCTYPE html>
<html>
<head>
    <title>Student Grade Analyzer</title>
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
            max-width: 600px;
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
            text-align: left;
            animation: fadeIn 0.5s ease;
            border-left: 4px solid #007bff;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        .stat-box {
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        .stat-value {
            font-weight: 600;
            font-size: clamp(18px, 4vw, 24px);
            margin-top: 5px;
        }
        .average {
            background-color: #e7f5ff;
            border-left: 4px solid #339af0;
        }
        .highest {
            background-color: #ebfbee;
            border-left: 4px solid #40c057;
        }
        .lowest {
            background-color: #fff4e6;
            border-left: 4px solid #fd7e14;
        }
        .below-grade {
            background-color: #fff5f5;
            border-left: 4px solid #fa5252;
        }
        .student-list {
            margin-top: 10px;
            padding-left: 20px;
        }
        .student-item {
            margin-bottom: 5px;
        }
        .grade-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .grade-table th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .grade-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .grade-table tr:nth-child(even) {
            background-color: #f8f9fa;
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
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .grade-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Grade Analyzer</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="threshold">Grade Threshold (show students below this grade):</label>
                <input type="number" name="threshold" id="threshold" min="0" max="100" value="<?php echo htmlspecialchars($_POST['threshold'] ?? 60); ?>">
            </div>
            <input type="submit" name="submit" value="Analyze Grades">
        </form>

        <?php
        // Sample student data (name => grade)
        $students = [
            "Emily Johnson" => 92,
            "Michael Brown" => 78,
            "Sarah Davis" => 85,
            "David Wilson" => 65,
            "Jessica Lee" => 58,
            "Daniel Miller" => 72,
            "Olivia Taylor" => 89,
            "James Anderson" => 53,
            "Sophia Martinez" => 95,
            "William Thomas" => 62
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $threshold = isset($_POST['threshold']) ? (int)$_POST['threshold'] : 60;

            // Calculate statistics
            $grades = array_values($students);
            $average = array_sum($grades) / count($grades);
            $highest = max($grades);
            $lowest = min($grades);

            // Find students below threshold
            $belowThreshold = array_filter($students, function($grade) use ($threshold) {
                return $grade < $threshold;
            });

            echo '<div class="result">';

            // Display all students in a table
            echo '<table class="grade-table">';
            echo '<thead><tr><th>Student</th><th>Grade</th></tr></thead>';
            echo '<tbody>';
            foreach ($students as $name => $grade) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($name) . '</td>';
                echo '<td>' . $grade . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';

            // Display statistics
            echo '<div class="stats-grid">';

            echo '<div class="stat-box average">';
            echo '<div>Average Grade</div>';
            echo '<div class="stat-value">' . number_format($average, 2) . '</div>';
            echo '</div>';

            echo '<div class="stat-box highest">';
            echo '<div>Highest Grade</div>';
            echo '<div class="stat-value">' . $highest . '</div>';
            echo '</div>';

            echo '<div class="stat-box lowest">';
            echo '<div>Lowest Grade</div>';
            echo '<div class="stat-value">' . $lowest . '</div>';
            echo '</div>';

            echo '<div class="stat-box below-grade">';
            echo '<div>Students Below ' . $threshold . '</div>';
            echo '<div class="stat-value">' . count($belowThreshold) . '</div>';
            echo '</div>';

            echo '</div>';

            // Display list of students below threshold
            if (!empty($belowThreshold)) {
                echo '<div style="margin-top: 20px;">';
                echo '<h3 style="color: #fa5252; margin-bottom: 10px;">Students Below Grade ' . $threshold . ':</h3>';
                echo '<div class="student-list">';
                foreach ($belowThreshold as $name => $grade) {
                    echo '<div class="student-item">' . htmlspecialchars($name) . ' (' . $grade . ')</div>';
                }
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
