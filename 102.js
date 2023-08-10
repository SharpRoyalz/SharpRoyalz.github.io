// Function to create a new checkbox item
function createCheckboxItem(text) {
  const li = document.createElement("li");
  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";
  checkbox.addEventListener("change", lineItem);
  const label = document.createElement("label");
  label.textContent = text;
  const textBox = document.createElement("input");
  textBox.type = "hidden";
  textBox.name = "expenses[]";
  textBox.value = text;
  li.appendChild(checkbox);
  li.appendChild(label);
  li.appendChild(textBox);
  return li;
}
var i = 1;
// Function to add an item to the list
function addItem() {
  const newItemText = document.getElementById("new-item-text");
  const text = newItemText.value;
  console.log("Im working");
  if (text) {
    const newItem = createCheckboxItem(text); // Pass the id to the function
    const todoList = document.getElementById("todoList");
    todoList.appendChild(newItem);
    newItemText.value = "";
  }
}

function populateExpenses() {
  const todoList = document.getElementById("todoList");
  todoList.innerHTML = ""; // Clear existing list items

  // Iterate through the expensesList array and create list items
  for (const expense of expensesList) {
    const li = createCheckboxItem(expense); // Create list item with expense text
    todoList.appendChild(li);
  }
}

// Call populateExpenses() when the page loads to display existing expenses
document.addEventListener("DOMContentLoaded", populateExpenses);

// Function to line an item when checkbox is checked
function lineItem(event) {
  const checkbox = event.target;
  const listItem = checkbox.parentElement;

  if (listItem.style.textDecoration == "line-through") {
    listItem.style.textDecoration = "none";
  } else {
    var numberPrompt = 0;
    do {
      numberPrompt = prompt(
        "How much did you spend? (if nothing leave it blank)"
      );
    } while (numberPrompt < 0 || !Number.isInteger(+numberPrompt));
    listItem.style.textDecoration = "line-through";
  }
}


