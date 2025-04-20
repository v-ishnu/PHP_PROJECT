<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Questions Navigation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        .category {
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .category-header {
            padding: 15px 20px;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        .category-header .icon {
            margin-right: 10px;
            font-size: 1.5em;
        }
        .questions-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            padding: 20px;
            background-color: white;
        }
        .question-card {
            padding: 15px;
            border-left: 4px solid;
            border-radius: 4px;
            background-color: #f8f9fa;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .question-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .question-number {
            font-weight: bold;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        .question-number:before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .question-text {
            font-size: 0.95em;
            color: #555;
        }

        /* Category Colors */
        .category-1 { background-color: #2ecc71; border-color: #2ecc71; }
        .category-1 .question-card { border-color: #2ecc71; }
        .category-1 .question-number:before { background-color: #2ecc71; }

        .category-2 { background-color: #3498db; border-color: #3498db; }
        .category-2 .question-card { border-color: #3498db; }
        .category-2 .question-number:before { background-color: #3498db; }

        .category-3 { background-color: #f1c40f; border-color: #f1c40f; }
        .category-3 .question-card { border-color: #f1c40f; }
        .category-3 .question-number:before { background-color: #f1c40f; }

        .category-4 { background-color: #9b59b6; border-color: #9b59b6; }
        .category-4 .question-card { border-color: #9b59b6; }
        .category-4 .question-number:before { background-color: #9b59b6; }

        .category-5 { background-color: #e67e22; border-color: #e67e22; }
        .category-5 .question-card { border-color: #e67e22; }
        .category-5 .question-number:before { background-color: #e67e22; }

        .category-6 { background-color: #e74c3c; border-color: #e74c3c; }
        .category-6 .question-card { border-color: #e74c3c; }
        .category-6 .question-number:before { background-color: #e74c3c; }

        .category-7 { background-color: #1abc9c; border-color: #1abc9c; }
        .category-7 .question-card { border-color: #1abc9c; }
        .category-7 .question-number:before { background-color: #1abc9c; }

        /* Navigation Controls */
        .nav-controls {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 15px;
            background-color: #2c3e50;
            color: white;
            border-radius: 5px;
        }
        .nav-button {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .nav-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Questions Navigation</h1>

        <!-- Category 1: Programming Logic & Constructs -->
        <div class="category">
            <div class="category-header category-1">
                <span class="icon">🟩</span>
                <h2>1. Programming Logic & Constructs</h2>
            </div>
            <div class="questions-container">
                <a href="Q1/Q1.php" class="question-card">
                    <div class="question-number">1</div>
                    <div class="question-text">Develop a PHP program that accepts two numbers from the user and determines the larger number.</div>
                </a>
                <a href="Q1/Q2.php" class="question-card">
                    <div class="question-number">2</div>
                    <div class="question-text">Implement a PHP script to check whether a given number is prime or not.</div>
                </a>
                <a href="Q1/Q3.php" class="question-card">
                    <div class="question-number">3</div>
                    <div class="question-text">Create a PHP script that takes a string input and reverses it without using built-in string functions.</div>
                </a>
                <a href="Q1/Q4.php" class="question-card">
                    <div class="question-number">4</div>
                    <div class="question-text">Write a PHP program that accepts input from the user and generates the Fibonacci series up to a given number using loops.</div>
                </a>
                <a href="Q1/Q5.php" class="question-card">
                    <div class="question-number">5</div>
                    <div class="question-text">Write a PHP program that takes a number as input from the user and uses a user-defined recursive function to calculate and display its factorial.</div>
                </a>
            </div>
        </div>

        <!-- Category 2: Functions in PHP -->
        <div class="category">
            <div class="category-header category-2">
                <span class="icon">🟦</span>
                <h2>2. Functions in PHP</h2>
            </div>
            <div class="questions-container">
                <a href="Q2/Q6.php" class="question-card">
                    <div class="question-number">6</div>
                    <div class="question-text">Write a PHP function that takes an array of numbers and returns the sum of its elements.</div>
                </a>
                <a href="Q2/Q7.php" class="question-card">
                    <div class="question-number">7</div>
                    <div class="question-text">Create a user-defined function that calculates the factorial of a given number using recursion.</div>
                </a>
                <a href="Q2/Q8.php" class="question-card">
                    <div class="question-number">8</div>
                    <div class="question-text">Develop an anonymous function in PHP that checks whether a given number is even or odd.</div>
                </a>
                <a href="Q2/Q9.php" class="question-card">
                    <div class="question-number">9</div>
                    <div class="question-text">Implement a PHP script using a function that converts temperature from Celsius to Fahrenheit and vice versa.</div>
                </a>
            </div>
        </div>

        <!-- Category 3: String Handling -->
        <div class="category">
            <div class="category-header category-3">
                <span class="icon">🟨</span>
                <h2>3. String Handling</h2>
            </div>
            <div class="questions-container">
                <a href="Q3/Q10.php" class="question-card">
                    <div class="question-number">10</div>
                    <div class="question-text">Write a PHP program to count the number of words, characters, and vowels in a given string.</div>
                </a>
                <a href="Q3/Q11.php" class="question-card">
                    <div class="question-number">11</div>
                    <div class="question-text">Develop a PHP script that replaces a specific word in a string with another word provided by the user.</div>
                </a>
                <a href="Q3/Q12.php" class="question-card">
                    <div class="question-number">12</div>
                    <div class="question-text">Create a PHP program to find the frequency of a particular character in a string.</div>
                </a>
                <a href="Q3/Q13.php" class="question-card">
                    <div class="question-number">13</div>
                    <div class="question-text">Implement a PHP script to extract all numeric values from a given string.</div>
                </a>
                <a href="Q3/Q14.php" class="question-card">
                    <div class="question-number">14</div>
                    <div class="question-text">Develop a PHP program that accepts a string from the user and performs various string operations.</div>
                </a>
            </div>
        </div>

        <!-- Category 4: Arrays in PHP -->
        <div class="category">
            <div class="category-header category-4">
                <span class="icon">🟪</span>
                <h2>4. Arrays in PHP</h2>
            </div>
            <div class="questions-container">
                <a href="Q4/Q15.php" class="question-card">
                    <div class="question-number">15</div>
                    <div class="question-text">Create a PHP script that sorts an array of integers in ascending and descending order using built-in functions.</div>
                </a>
                <a href="Q4/Q16.php" class="question-card">
                    <div class="question-number">16</div>
                    <div class="question-text">Write a PHP program to implement a multi-dimensional array to store student records and display them in a tabular format.</div>
                </a>
                <a href="Q4/Q17.php" class="question-card">
                    <div class="question-number">17</div>
                    <div class="question-text">Develop a PHP program that merges two arrays and removes duplicate elements.</div>
                </a>
                <a href="Q4/Q18.php" class="question-card">
                    <div class="question-number">18</div>
                    <div class="question-text">Implement a PHP script that finds the maximum and minimum values from an array without using built-in functions.</div>
                </a>
                <a href="Q4/Q19.php" class="question-card">
                    <div class="question-number">19</div>
                    <div class="question-text">Create an array of student names and their corresponding grades. Write a PHP program to calculate and display various grade statistics.</div>
                </a>
            </div>
        </div>

        <!-- Category 5: OOP -->
        <div class="category">
            <div class="category-header category-5">
                <span class="icon">🟫</span>
                <h2>5. Object-Oriented Programming</h2>
            </div>
            <div class="questions-container">
                <a href="Q5/Q20.php" class="question-card">
                    <div class="question-number">20</div>
                    <div class="question-text">Write a PHP class named Book with properties (title, author, price) and methods to set and display the book details.</div>
                </a>
                <a href="Q5/Q21.php" class="question-card">
                    <div class="question-number">21</div>
                    <div class="question-text">Develop a PHP program demonstrating inheritance by creating a Vehicle class with a method move(), and a Car class extending Vehicle.</div>
                </a>
            </div>
        </div>

        <!-- Category 6: Database Handling -->
        <div class="category">
            <div class="category-header category-6">
                <span class="icon">🟥</span>
                <h2>6. Database Handling (MySQLi)</h2>
            </div>
            <div class="questions-container">
                <a href="Q6/Q22.php" class="question-card">
                    <div class="question-number">22</div>
                    <div class="question-text">Create a PHP script that connects to a MySQL database, creates a table for storing employee details, and inserts records into it.</div>
                </a>
                <a href="Q6/Q23.php" class="question-card">
                    <div class="question-number">23</div>
                    <div class="question-text">Develop a PHP program to fetch and display all records from the employee table in a tabular format with an option to delete a record.</div>
                </a>
            </div>
        </div>

        <!-- Category 7: Image Processing -->
        <div class="category">
            <div class="category-header category-7">
                <span class="icon">🟧</span>
                <h2>7. Image Processing with GD Library</h2>
            </div>
            <div class="questions-container">
                <a href="Q7/Q24.php" class="question-card">
                    <div class="question-number">24</div>
                    <div class="question-text">Write a PHP script to embed an image in a web page using PHP. Allow the user to upload an image and display it dynamically.</div>
                </a>
                <a href="Q7/Q25.php" class="question-card">
                    <div class="question-number">25</div>
                    <div class="question-text">Create a PHP program that generates a blank image of 400x400 pixels and draws a rectangle, circle, and line using GD functions.</div>
                </a>
                <a href="Q7/Q26.php" class="question-card">
                    <div class="question-number">26</div>
                    <div class="question-text">Develop a PHP script that writes a given text string on an image using different font sizes and colors.</div>
                </a>
                <a href="Q7/Q27.php" class="question-card">
                    <div class="question-number">27</div>
                    <div class="question-text">Implement a PHP script to resize an uploaded image to a specified width and height while maintaining its aspect ratio.</div>
                </a>
                <a href="Q7/Q28.php" class="question-card">
                    <div class="question-number">28</div>
                    <div class="question-text">Write a PHP program to create an image with a gradient background and add text to it in different colors.</div>
                </a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all question cards
        const questionCards = document.querySelectorAll('.question-card');
        const prevButton = document.querySelector('.nav-button:first-child');
        const nextButton = document.querySelector('.nav-button:last-child');
        const navMessage = document.querySelector('.nav-controls span');

        // Extract question numbers from URL (e.g., "question5.html" -> 5)
        function getCurrentQuestionNumber() {
            const path = window.location.pathname;
            const match = path.match(/question(\d+)\.html/);
            return match ? parseInt(match[1]) : null;
        }

        // Update UI based on current question
        function updateNavigation(currentQ) {
            // Reset all cards
            questionCards.forEach(card => {
                card.classList.remove('current');
            });

            // Highlight current question if we're on a question page
            if (currentQ) {
                const currentCard = document.querySelector(`.question-card[href="question${currentQ}.html"]`);
                if (currentCard) {
                    currentCard.classList.add('current');
                    navMessage.textContent = `Currently viewing Question ${currentQ} of ${questionCards.length}`;

                    // Update prev/next buttons
                    prevButton.href = currentQ > 1 ? `question${currentQ-1}.html` : '#';
                    nextButton.href = currentQ < questionCards.length ? `question${currentQ+1}.html` : '#';

                    prevButton.classList.toggle('disabled', currentQ === 1);
                    nextButton.classList.toggle('disabled', currentQ === questionCards.length);

                    // Store last viewed question
                    localStorage.setItem('lastViewedQuestion', currentQ);
                }
            } else {
                // On the main navigation page
                const lastViewed = localStorage.getItem('lastViewedQuestion');
                navMessage.textContent = lastViewed ?
                    `Last viewed: Question ${lastViewed}` :
                    'Select a question to begin';
            }

            // Mark completed questions (from localStorage)
            const completedQuestions = JSON.parse(localStorage.getItem('completedQuestions') || '[]');
            completedQuestions.forEach(qNum => {
                const card = document.querySelector(`.question-card[href="question${qNum}.html"]`);
                if (card) {
                    card.classList.add('completed');
                    const numberDiv = card.querySelector('.question-number');
                    if (numberDiv) {
                        numberDiv.innerHTML += ' <span class="checkmark">✓</span>';
                    }
                }
            });
        }

        // Check if we're on a question page or the navigation page
        const currentQuestion = getCurrentQuestionNumber();
        updateNavigation(currentQuestion);

        // Add click handler to mark questions as completed
        questionCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.ctrlKey || e.metaKey) { // Mark as complete when Ctrl+Click
                    e.preventDefault();
                    const qNum = parseInt(card.querySelector('.question-number').textContent);
                    let completed = JSON.parse(localStorage.getItem('completedQuestions') || []);

                    if (!completed.includes(qNum)) {
                        completed.push(qNum);
                        localStorage.setItem('completedQuestions', JSON.stringify(completed));
                        card.classList.add('completed');
                        const numberDiv = card.querySelector('.question-number');
                        if (numberDiv) {
                            numberDiv.innerHTML += ' <span class="checkmark">✓</span>';
                        }
                    }
                }
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (currentQuestion) {
                if (e.key === 'ArrowLeft' && currentQuestion > 1) {
                    window.location.href = `question${currentQuestion-1}.html`;
                } else if (e.key === 'ArrowRight' && currentQuestion < questionCards.length) {
                    window.location.href = `question${currentQuestion+1}.html`;
                }
            }
        });

        // Style for checkmark
        const style = document.createElement('style');
        style.textContent = `
            .checkmark {
                color: #2ecc71;
                margin-left: 5px;
                font-weight: bold;
            }
            .completed {
                background-color: #e8f5e9;
                border-left-color: #2ecc71 !important;
            }
            .nav-button.disabled {
                opacity: 0.5;
                cursor: not-allowed;
                background-color: #95a5a6;
            }
        `;
        document.head.appendChild(style);
    });
</script>
</body>
</html>
