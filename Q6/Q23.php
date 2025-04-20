<!DOCTYPE html>
<html>
<head>
    <title>Employee Records Manager</title>
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
        .employee-table tr:hover {
            background-color: #e9ecef;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .delete-btn:hover {
            background-color: #c82333;
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
            .employee-table td:nth-child(4) {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Records Manager</h1>

        <?php
        // Database configuration
        $servername = "localhost";
        $username = "root"; // Change to your MySQL username
        $password = ""; // Change to your MySQL password
        $dbname = "employee_db";

        try {
            // Create connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Handle delete action
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $stmt = $conn->prepare("DELETE FROM employees WHERE id = :id");
                $stmt->bindParam(':id', $delete_id);
                $stmt->execute();

                echo '<div class="result success">Employee record deleted successfully!</div>';
            }

            // Display all employees
            $stmt = $conn->query("SELECT id, name, salary, reg_date FROM employees ORDER BY id DESC");
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($employees) > 0) {
                echo '<div class="result">';
                echo '<h3>Employee Records</h3>';
                echo '<table class="employee-table">';
                echo '<thead><tr><th>ID</th><th>Name</th><th>Salary</th><th>Date Added</th><th>Action</th></tr></thead>';
                echo '<tbody>';

                foreach ($employees as $employee) {
                    echo '<tr>';
                    echo '<td>' . $employee['id'] . '</td>';
                    echo '<td>' . htmlspecialchars($employee['name']) . '</td>';
                    echo '<td>$' . number_format($employee['salary'], 2) . '</td>';
                    echo '<td>' . date('M j, Y', strtotime($employee['reg_date'])) . '</td>';
                    echo '<td><a href="?delete_id=' . $employee['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="result">No employee records found.</div>';
            }

        } catch(PDOException $e) {
            echo '<div class="result error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        $conn = null; // Close connection
        ?>
    </div>
</body>
</html>
