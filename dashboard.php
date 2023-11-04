<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php'); // Redirect to the login page if the user is not logged in
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8">
      <title>Food Delivery Example</title>
      
      <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="stylesheet" href="styles.css">
      <link rel="stylesheet" href="anostyle.css">
   </head>
<body>
  <div class="header">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
  </div>
  <div class="content">
    <?php if (isset($_SESSION['Available_balance'])): ?>
      <p><?php echo $_SESSION['success'] = "You are now logged in"; ?></p>
      <p>Your Available Balance is: $<?php echo $_SESSION['Available_balance']; ?></p>
    <?php else :?>
      <p>Your have no balance</p>
    <?php endif; ?>
    <a href="login.php">Logout</a>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <script>
    // Sending a request to the server
    function serverRequest(method, data, callback) {
      $.ajax({
        type: 'POST',
        url: 'https://studio.alan.app/api_playground/' + method,
        crossDomain: true,
        data: JSON.stringify(data),
        dataType: 'json',
        success: callback,
        error: () => alert('POST failed')
      });
    }
  </script>
  <script src = "Alan_ai/Hello_World.js"></script>
<style>
  /* Style for the "Food Delivery" heading */
h1 {
    text-align: center; /* Center-align the heading */
    font-size: 2.5em; /* Increase font size */
    font-family: 'Arial', sans-serif; /* Specify a font-family */
    color: #333; /* Set text color */
}

/* Style for the "Menu" heading */
h3 {
    text-align: center; /* Center-align the heading */
    font-size: 1.8em; /* Increase font size */
    font-family: 'Arial', sans-serif; /* Specify a font-family */
    color: #555; /* Set text color */
}

</style>
  <h1>Food Delivery</h1>
      <h3>Menu</h3>
      <div class="menu">
         <div class="menu-item" id="pepperoni">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/pepperoni.jpg"/>
            <p>Pepperoni</p>
            <p>Price: <strong>$12.99</strong></p>
         </div>
         <div class="menu-item" id="margherita">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/margherita.jpg"/>
            <p>Margherita</p>
            <p>Price: <strong>$10.99</strong></p>
         </div>
         <div class="menu-item" id="burrito">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/burrito.jpg"/>
            <p>Burrito</p>
            <p>Price: <strong>$8.99</strong></p>
         </div>
         <div class="menu-item" id="burger">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/burger.jpg"/>
            <p>Burger</p>
            <p>Price: <strong>$6.99</strong></p>
         </div>
         <div class="menu-item" id="taco">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/taco.jpg"/>
            <p>Taco</p>
            <p>Price: <strong>$4.99</strong></p>
         </div>
         <div class="menu-item" id="apple-pie">
            <img src="https://storage.googleapis.com/alan-tutorial/web-sdk/applepie.jpg"/>
            <p>Apple Pie</p>
            <p>Price: <strong>$3.99</strong></p>
         </div>
      </div>
      <div id="order-details">
         <div id="order"></div>
         <div id="address"></div>
         <div id="time"></div>
         <div id="comment"></div>
      </div>
  <div class="alan-btn"></div>
  <script type="text/javascript"
 src="https://studio.alan.app/web/lib/alan_lib.min.js"></script>
  <script>
    var alanBtnInstance = alanBtn({
        key: "81b37bf4db53ab329e786304cb3399282e956eca572e1d8b807a3e2338fdd0dc/stage",
        onCommand: function (commandData) {
            if (commandData.command == "updateOrder") {
                changeOrder(commandData.item, commandData.quantity);
            } else if (commandData.command == "highlightItem") {
                highlight(commandData.item);
            } else if (commandData.command == "setAddress") {
                document.getElementById("address").innerHTML = "Address: " + commandData.address;
            } else if (commandData.command == "setTime") {
                document.getElementById("time").innerHTML = "Delivery time: " + commandData.time;
            } else if (commandData.command == "setComment") {
                document.getElementById("comment").innerHTML = "Comments: " + commandData.comment;
            }
        
            if (commandData.command === "go:back") {
                // call client code that will react to the received command
            }
        },
        rootEl: document.getElementById("alan-btn"),
    });
  </script>

<script>
    // Change the key in the order object to use item ID instead of item name
let order = {};

function updateCart() {
    let html = "<table border='0'><tr><th>Item</th><th>Quantity</th><th>Subtotal</th></tr>";
    let total = 0; // Initialize the total price

    const anomenuItems = {
        "pepperoni": 12.99,
        "margherita": 10.99,
        "burrito": 8.99,
        "burger": 6.99,
        "taco": 4.99,
        "apple-pie": 3.99
    };
    for (const key in anomenuItems) {
      const value = anomenuItems[key];


      for (let itemId in order) {
        let quantity = order[itemId];
        let anoquantity =quantity;
        let price = getItemPrice(itemId); // Get the item price using the item ID
        let subtotal = (price * quantity).toFixed(2); // Calculate subtotal
        total += parseFloat(subtotal); // Add subtotal to the total
        html += `<tr><td>${itemId}</td><td>${quantity}</td><td>$${value}</td>`;
    }


    html += "</table>";

    // Display the total price outside the loop
    if (total > 0) {
        html += `<p>Total Price: $${total.toFixed(2)}</p>`;
    }

    document.getElementById("order").innerHTML = html;
    }

    
}

// Update the changeOrder function to use item ID
function changeOrder(itemId, quantity) {
    let number = (order[itemId] ? order[itemId] : 0) + quantity;
    // Removing the item or updating the number of items
    if (number <= 0) {
        delete order[itemId];
    } else {
        order[itemId] = number;
    }
    updateCart();
}



// Helper function to get the item price based on the item ID
function getItemPrice(itemId) {
    const menuItems = {
        "pepperoni": 12.99,
        "margherita": 10.99,
        "burrito": 8.99,
        "burger": 6.99,
        "taco": 4.99,
        "apple-pie": 3.99
    };
    for (const key in dictionary) {
  const value = dictionary[key];
  console.log(`Key: ${key}, Value: ${value}`);
}


    return menuItems[itemId] || 0;
}
  </script>
  

</body>
</html>
