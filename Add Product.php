<!DOCTYPE html>
<html>
<head>
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="styling/staff dashboard.css">

</head>
<body>

<div class="header">
    <div class="logo">
      <img src="logo.jpg" alt="Tropicana Aquarium Logo" > 
    </div>
    <ul class="nav">
      <li><a href="staff_dashboard.php">Dashboard</a></li>
      <li><a href="homepage.php">Log Out</a></li>
    </ul>
  </div>


  <div class="content">
    <h2>Products</h2>
    <div class="product-list">

    </div>
    <button onclick="openAddProductPopup()">Add Product</button>
  </div>


  <div class="add-product-popup" id="add-product-popup">
  <span class="close-button" onclick="closeAddProductPopup()">&times;</span>
  <h2>Add Product</h2>
  <form id="add-product-form" action="" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="image">Image URL:</label>
    <input type="file" id="image" name="image" required>
    
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="10" cols="30" required></textarea><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required>

    <label for="category">Category:</label>
    <select id="category" name="category">
      <option value="Filter">Filter</option>
      <option value="Aquarium">Aquarium</option>
      <option value="Accessories">Accessories</option>
      <option value="Decoration">Decoration</option>
      <option value="Essential">Essential</option>
    </select>

    <button type="submit" name="submit">Add Product</button>
  </form>
</div>


  <script>
    function openAddProductPopup() {
      document.getElementById("add-product-popup").style.display = "block";
    }

    function closeAddProductPopup() {
      document.getElementById("add-product-popup").style.display = "none";
    }

    function openUpdateStockPopup(id, name) {
  var newStock = prompt("Enter the new stock quantity for product " + name);
  if (newStock !== null && newStock !== "") {
    updateStock(id, newStock);
  }
}

function openUpdatePricePopup(id, name) {
  var newPrice = prompt("Enter the new price for product " + name);
  if (newPrice !== null && newPrice !== "") {
    updatePrice(id, newPrice);
  }
}

function updateStock(id, newStock) {
  var form = document.createElement('form');
  form.method = 'post';
  form.style.display = 'none';

  var inputId = document.createElement('input');
  inputId.name = 'id';
  inputId.value = id;
  form.appendChild(inputId);

  var inputNewStock = document.createElement('input');
  inputNewStock.name = 'newStock';
  inputNewStock.value = newStock;
  form.appendChild(inputNewStock);

  document.body.appendChild(form);
  form.submit();
}

function updatePrice(id, newPrice) {
  var form = document.createElement('form');
  form.method = 'post';
  form.style.display = 'none';

  var inputId = document.createElement('input');
  inputId.name = 'id';
  inputId.value = id;
  form.appendChild(inputId);

  var inputNewPrice = document.createElement('input');
  inputNewPrice.name = 'newPrice';
  inputNewPrice.value = newPrice;
  form.appendChild(inputNewPrice);

  document.body.appendChild(form);
  form.submit();

}


    function removeProduct(id) {

      var form = document.createElement('form');
      form.method = 'post';
      form.style.display = 'none';

      var inputId = document.createElement('input');
      inputId.name = 'id';
      inputId.value = id;
      form.appendChild(inputId);

      var inputRemove = document.createElement('input');
      inputRemove.name = 'remove';
      inputRemove.value = '1';
      form.appendChild(inputRemove);

      document.body.appendChild(form);
      form.submit();
    }
  </script>
</body>

<?php
if (isset($_POST['submit'])) {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "tropicana aquarium";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $name = $conn->real_escape_string($_POST['name']);
  $description = $conn->real_escape_string($_POST['description']);
  $price = $conn->real_escape_string($_POST['price']);
  $quantity = $conn->real_escape_string($_POST['quantity']);
  $category = ucfirst($conn->real_escape_string($_POST['category'])); // Capitalize the first letter
  $image = $_FILES['image']['name'];
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);

  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $description = nl2br($description);
    $sql = "INSERT INTO product (name, price, description, stock_quantity, categories, image) VALUES ('$name', '$price', '$description', '$quantity', '$category', '$target_file')";
    if ($conn->query($sql) === TRUE) {
      echo "<script type='text/javascript'>alert('Product added successfully');</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

  $conn->close();
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tropicana aquarium";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM product";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  echo "<table class='product-table' style='width: 80%; margin: 0 auto;'>";
  echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Category</th><th>Image</th><th>Actions</th></tr>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["product_id"] . "</td>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["description"] . "</td>";
    echo "<td>" . $row["price"] . "</td>";
    echo "<td>" . $row["stock_quantity"] . "</td>";
    echo "<td>" . $row["categories"] . "</td>";
    echo "<td><img src='" . $row["image"] . "' width='50' height='50'></td>";
    echo "<td>";
    echo "<button onclick=\"openUpdateStockPopup(" . $row["product_id"] . " ,'" . $row["name"] . "')\">Update Stock</button>";
    echo "<button onclick=\"openUpdatePricePopup(" . $row["product_id"] . " ,'" . $row["name"] . "')\">Update Price</button>";
    echo "<button onclick=\"removeProduct(" . $row["product_id"] . ")\">Remove</button>";
    echo "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No products found";
}

if (isset($_POST['remove'])) {
  $id = $conn->real_escape_string($_POST['id']);
  $sql = "DELETE FROM product WHERE product_id = '$id'";
  if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Product removed successfully');</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_POST['newStock'])) {
  $id = $conn->real_escape_string($_POST['id']);
  $newStock = $conn->real_escape_string($_POST['newStock']);
  $sql = "UPDATE product SET stock_quantity = '$newStock' WHERE product_id = '$id'";
  if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Stock updated successfully');</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_POST['newPrice'])) {
  $id = $conn->real_escape_string($_POST['id']);
  $newPrice = $conn->real_escape_string($_POST['newPrice']);
  $sql = "UPDATE product SET price = '$newPrice' WHERE product_id = '$id'";
  if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Price updated successfully');</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>


</html>