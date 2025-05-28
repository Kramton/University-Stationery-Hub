<?php

$products = [
    ["name" => "Pen Set", "price" => "29.99", "category" => "Writing","subcategory" => "Pens", "image" => "pen sets.png"],
    ["name" => "Eco-Friendly Notebook", "price" => "8.99", "category" => "Notebooks", "image" => "notebook.png"],
    ["name" => "Pencil Case", "price" => "10.00", "category" => "Cases", "image" => "pencilcase1.png"],
    ["name" => "Pink Scissors", "price" => "15.00", "category" => "Office Product","subcategory" => "Scissors & Cutters", "image" => "pink scissors.png"],
    ["name" => "Croxley Envelops C4 Peel & Seal Non Window White Pack 25", "price" => "12.49", "category" => "Envelopes & Packaging", "image" => "category/CroxleyC425.png"],
    ["name" => "Kaskad Paper A4 80gsm Assorted Brights Pack 30", "price" => "7.79",  "category" => "Paper", "subcategory" => "Coloured Paper", "image" => "kaskadA430.png"],
    ["name" => "Okin Thermal Roll BPA Free 80x80mm, Pack of 5", "price" => "20.99",  "category" => "Paper", "subcategory" => "Machine Rolls", "image" => "okin80.png"],
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
<html>
<head>
    <title>Product Categories</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .menu a { margin: 10px; text-decoration: none; }
       .product { display: inline-block; width: 200px; margin: 10px; border: 1px solid #ccc; padding: 10px; vertical-align: top; text-align: center;}
       .product img { width: 180px; height: 180px;object-fit: cover; display: block; margin: 0 auto; border-radius: 8px; 
}




    </style>
</head>
<body>


<h2>University Stationary Hub</h2>

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
    <h3>Subcategories for Paper</h3>
    <div class="menu">
        <a href="?category=Paper&subcategory=All">All</a>
        <a href="?category=Paper&subcategory=Coloured+Paper">Coloured Paper</a>
        <a href="?category=Paper&subcategory=Machine+Rolls">Machine Rolls</a>
    </div>
<?php elseif ($category == "Writing"): ?>
    <h3>Subcategories for Writing</h3>
    <div class="menu">
        <a href="?category=Writing&subcategory=All">All</a>
        <a href="?category=Writing&subcategory=Pens">Pens</a>
        <a href="?category=Writing&subcategory=Pencils">Pencils</a>
        <a href="?category=Writing&subcategory=Highlighters">Highlighters</a>
    </div>
<?php elseif ($category == "Office Product"): ?>
    <h3>Subcategories for Office Product</h3>
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

</body>
</html>
