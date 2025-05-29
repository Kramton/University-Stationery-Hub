<?php

$products = [
    ["name" => "Pen Set", "price" => "29.99", "category" => "Writing","subcategory" => "Pens", "image" => "category/pen sets.png"],
    ["name" => "Eco-Friendly Notebook", "price" => "8.99", "category" => "Notebooks", "image" => "category/notebook.png"],
    ["name" => "Pencil Case", "price" => "10.00", "category" => "Cases", "image" => "category/pencilcase1.png"],
    ["name" => "Pink Scissors", "price" => "15.00", "category" => "Office Product","subcategory" => "Scissors & Cutters", "image" => "category/pink scissors.png"],
    ["name" => "Croxley Envelops C4 Peel & Seal Non Window White Pack 25", "price" => "12.49", "category" => "Envelopes & Packaging", "image" => "category/envelop1.png"],
    ["name" => "Kaskad Paper A4 80gsm Assorted Brights Pack 30", "price" => "7.79",  "category" => "Paper", "subcategory" => "Coloured Paper", "image" => "category/colourpaper1.png"],
    ["name" => "Okin Thermal Roll BPA Free 80x80mm, Pack of 5", "price" => "20.99",  "category" => "Paper", "subcategory" => "Machine Rolls", "image" => "category/okin rolls.png"],
    ["name" => "Classic Notebook", "price" => "5.66", "category" => "Notebooks","image" => "Notebook.jpg"],
    ["name" => "Gel Pen Set", "price" => "2.00", "category" => "Writing","subcategory" => "Pens", "image" => "Gel pen set.jpg"],
    ["name" => "HB Pencil with Eraser Tip", "price" => "3.00", "category" => "Writing", "subcategory" => "Pencils","image" => "Pencil.jpg"],
    ["name" => "Sketchbook", "price" => "14.99", "category" => "Notebooks", "image" => "sketchbook.jpg"],
    ["name" => "Binder Clips", "price" => "2.49", "category" => "Office Product","subcategory" => "adhesive, binding & fastenings", "image" => "binder clips.jpg"],
    ["name" => "Highlighters", "price" => "7.99", "category" => "Writing","subcategory" => "Highlighters", "image" => "highlighters.jpg"],

];

//  (?category=Pens)
$category = $_GET['category'] ?? 'All';
$subcategory = $_GET['subcategory'] ?? 'All';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Categories</title>
    <style>
   body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #ff6a00;
    }

header {
    background: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 40px;
    border-bottom: 1px solid #ccc;
}

.logo {
    font-size: 22px;
    font-weight: bold;
}

.nav {
    display: flex;
    align-items: center;
}

.nav a {
    margin: 0 15px;
    text-decoration: none;
    color: black;
}

.nav input {
    margin-left: 15px;
    padding: 5px;
    height: 16px;
    font-size: 14px;
}

.nav button {
    margin-left: 10px;
    background-color: #f0f0f0; 
    color: black;               
    border: none;
    font-size: 14px;
    height: 30px;              
    padding: 5px 15px;
    cursor: pointer;
    margin-top: 0;
}

.nav button a {
    text-decoration: none;
    color: black;
    display: block;
    height: 100%;
    width: 100%;
}
.menu {
    background-color: white;
    padding: 10px 40px;
    margin: 20px;
    border-radius: 6px;
}

.menu a {
    margin: 10px;
    text-decoration: none;
    color: #333;
}

.products {
    background-color: white;
    padding: 20px;
    margin: 20px;
    border-radius: 6px;
}

.product {
    display: inline-block;
    width: 250px;
    margin: 10px;
    border: 1px solid #ccc;
    padding: 10px;
    vertical-align: top;
    text-align: center;
    background-color: #fafafa;
    border-radius: 8px;
}

.product img {
    width: 180px;
    height: 180px;
    object-fit: cover;
    display: block;
    margin: 0 auto 10px;
    border-radius: 8px;
}

button, .submit-button {
    background-color: #ff6a00;
    color: white;
    border: none;
    padding: 10px 25px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}
footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background: white;
      margin-top: 60px;
    }
.subcategory-title {
    margin-left: 40px;
    font-size: 18px;
    font-weight: bold;
}
    </style>

 
 <header>
    <div class="logo">University Stationary Hub</div>
    <nav class="nav">
        <a href="#">Home</a>
        <a href="#">Products</a>
        <a href="#">Contact Us</a>
        <input type="text" placeholder="Search in site" />
        <button onclick="window.location.href='signUpPage.html'">Sign Up</button>
    </nav>
</header>


<!-- Category -->
<div class="menu">
    <a href="?category=All">All</a>
    <a href="?category=Writing">Writing</a>
    <a href="?category=Notebooks">Notebooks</a>
    <a href="?category=Envelopes%20%26%20Packaging">Envelopes & Packaging</a>
    <a href="?category=Paper">Paper</a>
    <a href="?category=Office Product">Office Product</a>
    
</div>

<hr>
<?php if ($category == "Paper"): ?>
    <h3 class="subcategory-title">Subcategories for Paper</h3>

    <div class="menu">
        <a href="?category=Paper&subcategory=All">All</a>
        <a href="?category=Paper&subcategory=Coloured+Paper">Coloured Paper</a>
        <a href="?category=Paper&subcategory=Machine+Rolls">Machine Rolls</a>
    </div>
<?php elseif ($category == "Writing"): ?>
    <h3 class="subcategory-title">Subcategories for Writing</h3>
    <div class="menu">
        <a href="?category=Writing&subcategory=All">All</a>
        <a href="?category=Writing&subcategory=Pens">Pens</a>
        <a href="?category=Writing&subcategory=Pencils">Pencils</a>
        <a href="?category=Writing&subcategory=Highlighters">Highlighters</a>
    </div>
<?php elseif ($category == "Office Product"): ?>
    <h3 class="subcategory-title">Subcategories for Office Product</h3>
    <div class="menu">
        <a href="?category=Office+Product&subcategory=All">All</a>
        <a href="?category=Office+Product&subcategory=Scissors+%26+Cutters">Scissors & Cutters</a>
        <a href="?category=Office+Product&subcategory=adhesive%2C+binding+%26+fastenings">Adhesive, Binding & Fastenings</a>
    </div>
<?php endif; ?>

<hr>

<!-- Item list -->
<div class="products">
<?php
foreach ($products as $p) {
    $catMatch = ($category == "All" || $p["category"] == $category);
    $subcatMatch = ($subcategory == "All" || $subcategory == "" || (isset($p["subcategory"]) && $p["subcategory"] == $subcategory));
    
    if ($catMatch && $subcatMatch) {
        echo "<div class='product'>";
        echo "<img src='{$p["image"]}' alt='{$p["name"]}' width='150'><br>";
        echo "<strong>{$p["name"]}</strong><br>";
        echo "Price: \${$p["price"]}<br>";
        echo "</div>";
    }
}
?>
</div>
<footer>
  © University Stationary Hub. All Rights Reserved. |
  <a href="#">Privacy Policy</a> |
  <a href="#">Terms & Conditions</a>
</footer>

</body>
</html>
