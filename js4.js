// Duration of Budget
var inputDateDuration = document.getElementById("input-date-duration");
var dueWeekGlobal;
const setDurationInput = (dueWeek) => {
  if (dueWeek > 0) {
    inputDateDuration.disabled = false;
    dueWeekGlobal = dueWeek;
  }
};

function dayFunction() {
  setDurationInput(1);
}

function weekFunction() {
  setDurationInput(7);
}

function monthFunction() {
  setDurationInput(30);
}

function yearFunction() {
  setDurationInput(365);
}

var durationOfBudget;
var HiddenDuration = document.getElementById("hidden-duration");
var desiredBudget = 0;
var requiredMessage = document.getElementById("requiredMessage");
var budgetAmount = document.getElementById("desired-budget");

function checkboxExpensesEnable() {
  const budgetAmountValue = budgetAmount.value;
  if (budgetAmountValue) {
    durationOfBudget = inputDateDuration.value * dueWeekGlobal;
    HiddenDuration.value = parseInt(durationOfBudget); // Convert durationOfBudget to an integer and store it in the hidden input field
    document.myForm.submit();
  } else {
    requiredMessage.style.display = "inline";
    console.log("Enter a value");
  }
}

function myFunction() {
  var inputField = budgetAmount;

  if (inputDateDuration.value === "") {
    inputField.value = "";
    inputField.disabled = true;
  } else {
    inputField.disabled = false;
  }
}
