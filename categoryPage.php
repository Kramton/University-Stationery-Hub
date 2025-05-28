<?php

$products = [
    ["name" => "Pen Set", "price" => "29.99", "category" => "Writing", "image" => "pen sets.png"],
    ["name" => "Eco-Friendly Notebook", "price" => "8.99", "category" => "Notebooks", "image" => "notebook.png"],
    ["name" => "Pencil Case", "price" => "10.00", "category" => "Cases", "image" => "pencilcase1.png"],
    ["name" => "Pink Scissors", "price" => "15.00", "category" => "Office Product", "image" => "pink scissors.png"],
    ["name" => "Croxley Envelops C4 Peel & Seal Non Window White Pack 25", "price" => "12.49", "category" => "Envelopes & Packaging", "image" => "CroxleyC425.png"],
    ["name" => "Kaskad Paper A4 80gsm Assorted Brights Pack 30", "price" => "7.79",  "category" => "Paper", "subcategory" => "Coloured Paper", "image" => "kaskadA430.png"],
    ["name" => "Okin Thermal Roll BPA Free 80x80mm, Pack of 5", "price" => "20.99",  "category" => "Paper", "subcategory" => "Machine Rolls", "image" => "okin80.png"],
   // ["name" => "Pencil Case", "price" => "10.00", "category" => "Cases", "image" => "pencilcase1.png"],

];

//  (?category=Pens)
$category = $_GET['category'] ?? 'All';
$subcategory = $_GET['subcategory'] ?? 'All';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Categories</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .menu a { margin: 10px; text-decoration: none; }
        .product { display: inline-block; width: 200px; margin: 10px; border: 1px solid #ccc; padding: 10px; }
        .product img { width: 100%; height: auto; }
    </style>
</head>
<body>

<h2>University Stationary Hub</h2>

<!-- Category -->
<div class="menu">
    <a href="?category=All">All</a>
    <a href="?category=Writing">Writing</a>
    <a href="?category=Notebooks">Notebooks</a>
    <a href="?category=Envelopes & Packaging">Envelopes & Packaging</a>
    <a href="?category=Paper">Paper</a>
    <a href="?category=Office Product">Office Product</a>
    
</div>

<hr>
<?php if ($category == "Paper"): ?>
    <h3>Subcategories for Paper</h3>
    <div class="menu">
        <a href="?category=Paper&subcategory=All">All</a>
        <a href="?category=Paper&subcategory=Coloured+Paper">Coloured Paper</a>
        <a href="?category=Paper&subcategory=Machine+Rolls">Machine Rolls</a>
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

</body>
</html>
