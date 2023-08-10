<?php
$servername = "localhost";
$username = "root"; // Replace with your actual MySQL username
$password = ""; // Replace with your actual MySQL password
$databaseName = "budget_db"; // Replace with the name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $databaseName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user inputs
function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if the form is submitted
$budgetAmount = 10;
$budgetDuration = 0;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data and sanitize it
    $budgetAmount = sanitize_input($_POST["desired-budget"]);
    $sanitizeDuration = sanitize_input($_POST["hidden-duration"]);
    $budgetDuration = intval($sanitizeDuration);
    // Perform any additional validation here

    // Insert the data into the database
    $sql = "INSERT INTO budget_details (`budget_amount`,`budget_duration`) VALUES ('$budgetAmount', $budgetDuration)";

    if (mysqli_query($conn, $sql)) {
        echo "insert successfully";
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
}

// Fetch data from the database
$sqlDetails = "SELECT id, budget_amount, budget_duration FROM budget_details ORDER BY ID DESC LIMIT 1";
$resultDetails = mysqli_query($conn, $sqlDetails);
if ($resultDetails && mysqli_num_rows($resultDetails) > 0) {
    $row = mysqli_fetch_assoc($resultDetails);
    $id = $row['id'];
    $budgetAmount = $row['budget_amount'];
    $budgetDuration = $row['budget_duration'];
} else {
    // If no data found, you can set a default value or show an error message
    $id = 0;
    $budgetAmount = 0;
    $budgetDuration = 0;
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css13.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia" />
    <title>Budget</title>
</head>

<body>
    <form method="post" class="form-submit" name="myForm" action="budget.php">
        <div class="grid-container">
            <nav class="navbar">
                <div class="logo">
                    <img src="budget-logo.jpg" alt="">
                    <p><b>Vayzu's Budgetting Site</b></p>
                </div>
            </nav>
            <div class="duration-container">
                <div class="duration-content">
                    <p id="duration-para"><b>Duration</b></p>
                    <p id="choose-para">Choose the duration for your budget:</label>
                        <br />
                    <div class="duration-button">
                        <button type="button" class="day-duration" onclick="dayFunction()">
                            Day
                        </button>
                        <button type="button" class="week-duration" onclick="weekFunction()">
                            Week
                        </button>
                        <button type="button" class="month-duration" onclick="monthFunction()">
                            Month
                        </button>
                        <button type="button" class="year-duration" onclick="yearFunction()">
                            Year
                        </button>
                        <br />
                        <label for="input-date-duration" id="label-date-duration">Enter the duration: </label>
                        <input type="number" id="input-date-duration" name="input-date-duration" oninput="myFunction()"
                            disabled>
                        <span id="requiredMessage" style="color: red; display: none;">This field is required.</span>

                        <input type="hidden" id="hidden-duration" name="hidden-duration" value="">
                    </div>
                </div>
            </div>
            <div class="amount-container">
                <div class="amount-content">
                    <p class="amount-para">Amount</p>
                    <label for="desired-budget" id="label_desired_budget" class="label-desired-budget">Enter your
                        budget:</label>
                    <input type="number" class="budget-amount" id="desired-budget" name="desired-budget" disabled />
                    <span id="requiredMessage" style="color: red; display: none;">This field is required.</span>
                    <br />

                    <div class="next-container">
                        <button type="button" class="next-button" id="next-button" onclick="checkboxExpensesEnable()">
                            Next
                        </button>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p><b>This site is for my loves only ❤️</b> </p>
            </div>
        </div>
    </form>
</body>

<script src="js4.js"></script>

</html>