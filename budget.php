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
$budgetAmount = 0;
$budgetDuration = 0;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get form data and sanitize it

  $budgetAmount = sanitize_input($_POST["desired-budget"]);
  $sanitizeDuration = sanitize_input($_POST["hidden-duration"]);
  $budgetDuration = intval($sanitizeDuration);
  // Perform any additional validation here
  if ($budgetAmount > 0) {
    // Insert the data into the database
    $sql = "INSERT INTO budget_details (`budget_amount`,`budget_duration`) VALUES ('$budgetAmount', $budgetDuration)";
    if (mysqli_query($conn, $sql)) {
    } else {
      echo "Error inserting data: " . mysqli_error($conn);
    }
  } else {
    // Insert the expenses into the database
    if (isset($_POST['expenses'])) {
      foreach ($_POST['expenses'] as $expense) {
        $expensesName = sanitize_input($expense);
        $sql = "INSERT INTO budget_expenses (`expenses_name`) VALUES ('$expensesName') ON DUPLICATE KEY UPDATE expenses_name = VALUES(expenses_name)";
        if (mysqli_query($conn, $sql)) {
        } else {
        }
        mysqli_query($conn, $sql);
      }
    }
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

$sqlExpenses = "SELECT expenses_id, expenses_name FROM budget_expenses ORDER BY expenses_id ASC";
$resultExpenses = mysqli_query($conn, $sqlExpenses);
$expensesList = array();

if ($resultExpenses && mysqli_num_rows($resultExpenses) > 0) {
  while ($row = mysqli_fetch_assoc($resultExpenses)) {
    $expensesList[] = $row['expenses_name'];
  }
} else {
  // If no data found, you can set a default value or show an error message
  $expensesList = array();
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="style11.css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <title>Budget</title>
</head>

<body>
  <!-- Content Inside -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="grid-container">
      <nav class="navbar">
        <div class="logo">
          <img src="budget-logo.jpg" alt="">
          <p><b>
              <?php echo "₱ " . $budgetAmount ?>
            </b></p>
        </div>
      </nav>
      <div class="expenses-container">
        <div class="add-items-container">
          <input type="hidden" name="desired-budget" value="0">
          <input type="hidden" name="hidden-duration" value="0">
          <p class="expenses-para"><b>Expenses</b></p>
          <label for="newItemText">Add your expenses</label>
          <input type="text" id="new-item-text" placeholder="eg. Gulay" />
          <button type="button" id="add-button" onclick="addItem()">Add</button>
        </div>
        <div class="added-items-container">
          <h3>Budget List</h3>
          <ul id="todoList">
            <!-- Items will be dynamically added here -->
            <script>
              var expensesList = <?php echo json_encode($expensesList); ?>;
            </script>
          </ul>
        </div>
        <div class="options-footer">
          <div class="more-options">
            <button type="button" class="material-symbols-outlined">
              more_horiz
            </button>
          </div>
          <div class="duration-option">
            <p>
            <div id="timer"></div>
            </p>
          </div>
          <div class="save-option">
            <button type="submit" id="save-button" class="material-symbols-outlined" />
            save
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
<script>
  function countdownTimer(targetDate) {
    const timerElement = document.getElementById("timer");

    function updateTimer() {
      const currentDate = new Date();
      const timeDifference = targetDate - currentDate;

      if (timeDifference <= 0) {
        timerElement.innerHTML = "Countdown finished!";
        return;
      }

      const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
      const hours = Math.floor(
        (timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      const minutes = Math.floor(
        (timeDifference % (1000 * 60 * 60)) / (1000 * 60)
      );
      const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

      const timerString = `${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`;
      timerElement.innerHTML = timerString;
    }

    updateTimer();
    setInterval(updateTimer, 1000); // Update timer every second
  }

  // Set the target date for the countdown (current date + 23 days)
  const targetDate = new Date();
  var budgetDuration = <?php echo $budgetDuration * 24 * 60 * 60; ?>; // Convert days to seconds

  targetDate.setTime(targetDate.getTime() + (budgetDuration * 1000)); // Convert seconds to milliseconds
  countdownTimer(targetDate);
</script>
<script src="102.js"></script>

</html>