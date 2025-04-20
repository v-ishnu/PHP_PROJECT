<!DOCTYPE html>
<html>
<head>
    <title>Employee Management System</title>
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
        .employee-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .employee-table th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .employee-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .employee-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .error {
            color: #dc3545;
            font-weight: 600;
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
            .employee-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Management System</h1>
        <form method="post" action="">
            <div class="input-group">
                <label for="name">Employee Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="input-group">
                <label for="salary">Salary:</label>
                <input type="number" name="salary" id="salary" min="0" step="0.01" required>
            </div>
            <input type="submit" name="submit" value="Add Employee">
        </form>

        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "employee_db";

        try {
            // Create connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create table if not exists
            $sql = "CREATE TABLE IF NOT EXISTS employees (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                salary DECIMAL(10,2) NOT NULL,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);

            // Insert new employee if form submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
                $name = $_POST['name'];
                $salary = $_POST['salary'];

                $stmt = $conn->prepare("INSERT INTO employees (name, salary) VALUES (:name, :salary)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':salary', $salary);
                $stmt->execute();

                echo '<div class="result success">New employee record created successfully!</div>';
            }

            // Display all employees
            $stmt = $conn->query("SELECT id, name, salary FROM employees ORDER BY id DESC");
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($employees) > 0) {
                echo '<div class="result">';
                echo '<h3>Employee Records</h3>';
                echo '<table class="employee-table">';
                echo '<thead><tr><th>ID</th><th>Name</th><th>Salary</th></tr></thead>';
                echo '<tbody>';

                foreach ($employees as $employee) {
                    echo '<tr>';
                    echo '<td>' . $employee['id'] . '</td>';
                    echo '<td>' . htmlspecialchars($employee['name']) . '</td>';
                    echo '<td>₹' . number_format($employee['salary'], 2) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="result">No employee records found.</div>';
            }

        } catch(PDOException $e) {
            echo '<div class="result error">Connection failed: ' . $e->getMessage() . '</div>';
        }

        $conn = null; // Close connection
        ?>
    </div>
</body>
</html>
