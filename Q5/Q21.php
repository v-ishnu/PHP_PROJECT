<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Inheritance Demo</title>
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
        .vehicle-info {
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 6px;
            margin-top: 15px;
        }
        .method-call {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #e7f5ff;
            border-radius: 4px;
        }
        .method-name {
            font-weight: 600;
            color: #007bff;
        }
        .method-result {
            margin-top: 5px;
            padding-left: 15px;
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
        <h1>Vehicle Inheritance Demo</h1>

        <?php
        // Parent class
        class Vehicle {
            public function move() {
                return "The vehicle is moving";
            }
        }

        // Child class inheriting from Vehicle
        class Car extends Vehicle {
            public function fuelType() {
                return "This car uses gasoline";
            }

            // Overriding parent method
            public function move() {
                return "The car is driving on the road";
            }
        }

        // Create instances
        $vehicle = new Vehicle();
        $car = new Car();

        echo '<div class="result">';
        echo '<h3>Vehicle Class Demonstration</h3>';

        echo '<div class="vehicle-info">';

        // Demonstrate Vehicle methods
        echo '<div class="method-call">';
        echo '<div class="method-name">$vehicle->move():</div>';
        echo '<div class="method-result">' . $vehicle->move() . '</div>';
        echo '</div>';

        echo '</div>';

        echo '<h3 style="margin-top: 20px;">Car Class Demonstration</h3>';
        echo '<div class="vehicle-info">';

        // Demonstrate inherited method
        echo '<div class="method-call">';
        echo '<div class="method-name">$car->move() (inherited from Vehicle):</div>';
        echo '<div class="method-result">' . $car->move() . '</div>';
        echo '</div>';

        // Demonstrate Car's own method
        echo '<div class="method-call">';
        echo '<div class="method-name">$car->fuelType() (Car-specific method):</div>';
        echo '<div class="method-result">' . $car->fuelType() . '</div>';
        echo '</div>';

        echo '</div>';
        echo '</div>';
        ?>
    </div>
</body>
</html>
