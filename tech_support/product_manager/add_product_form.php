<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Product </title>
        <link rel="stylesheet" type="text/css" href="/PHPAssignment2/tech_support/css/main.css">
    </head>
<body>
    <?php
    include('../view/header.php');
    ?>
    <main>
    <h1>Add Product</h1>
    <form action="add_product.php" method="post" id="aligned">
        <label>Code:</label>
        <input type="text" name="code"><br>
        
        <label>Name:</label>
        <input type="text" name="name"><br>
        
        <label>Version:</label>
        <input type="number" name="version" step="0.1"><br>
        
        <label>Release Date:</label>
        <input type="date" name="release_date"> <br>
        
        <label>&nbsp;</label>
        <input type="submit" value="Add Product"><br>
    </form>
    <p><a href="tech_support/product_manager">View Product List</a></p>
    <?php
    include('../view/footer.php'); 
    ?>   
</main>
    
</body>