<?php
// homepage.php

if (!isset($_SESSION)) {
    session_start();
}


$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT DISTINCT categories FROM product";
$result = mysqli_query($conn, $query);

// Create an array 
$categories = array();

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Handle search 
$searchResults = array();
if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = "SELECT * FROM product WHERE name LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";
    $searchResult = mysqli_query($conn, $searchQuery);

    while ($row = mysqli_fetch_assoc($searchResult)) {
        $searchResults[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tropicana Aquarium</title>
    <link rel="stylesheet" href="styling/product list.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo.jpg" alt="Tropicana Aquarium Logo">
        </div>
        <ul class="nav">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="Product List.php">Shop</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="profile.php">Account</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="Product List.php">Shop</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="search-bar">
        <form action="Product List.php" method="GET">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
            <button type="reset" onclick="window.location.href='Product%20List.php'">Reset</button> <!-- This resets the form -->
            </form>
    </div>

    <div class="content">
        <div class="categories">
            <?php foreach ($categories as $category) {?>
                <li class="product-category" data-category="<?php echo $category['categories'];?>"><?php echo $category['categories'];?></li>
            <?php }?>
        </div>

        <main>
            <?php
            if (isset($_GET['search']) && !empty($searchResults)) {
                // Display search results
                echo '<h2>Search Results for "' . htmlspecialchars($_GET['search']) . '"</h2>';
                echo '<div class="products">';
                foreach ($searchResults as $product) {
                    echo '<div class="product-card" id="'. $product['product_id']. '">';
                    echo '<a href="'. (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ? 'Product View.php?product_id='. $product['product_id'] : 'login.php'). '" style="text-decoration: none;">';
                    echo '<img src="'. $product['image']. '" alt="'. $product['name']. '">';
                    echo '</a>';
                    echo '<div class="product-info">';
                    echo '<h3>'. $product['name']. '</h3>';
                    echo '<p>RM '. $product['price']. '</p>';
                    echo '<p>'. $product['description']. '</p>';
                    echo '</div>';
                    echo '<div class="buttons">';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                // Display products by categories
                foreach ($categories as $category) {
                    echo '<section id="'. $category['categories']. '">';
                    echo '<h2>'. $category['categories']. '</h2>';
                    echo '<div class="products">';

                    $conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");
                    $query = "SELECT * FROM product WHERE categories = '". $category['categories']. "'";
                    $result = mysqli_query($conn, $query);

                    while ($product = mysqli_fetch_assoc($result)) {
                        // Display product card
                        echo '<div class="product-card" id="'. $product['product_id']. '">';
                        echo '<a href="'. (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ? 'Product View.php?product_id='. $product['product_id'] : 'login.php'). '" style="text-decoration: none;">';
                        echo '<img src="'. $product['image']. '" alt="'. $product['name']. '">';
                        echo '</a>';
                        echo '<div class="product-info">';
                        echo '<h3>'. $product['name']. '</h3>';
                        echo '<p>RM '. $product['price']. '</p>';
                        echo '<p>'. $product['description']. '</p>';
                        echo '</div>';
                        echo '<div class="buttons">';
                        echo '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</section>';
                    mysqli_close($conn);
                }
            }
            ?>
        </main>
    </div>

    <script>
        const productCategories = document.querySelectorAll('.product-category');

        productCategories.forEach(category => {
            category.addEventListener('click', () => {
                const categoryId = category.dataset.category;
                const categorySection = document.querySelector(`#${categoryId}`);
                categorySection.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
