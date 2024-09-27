<?php
  session_start();

  $code = filter_input(INPUT_POST, 'code');
  $name = filter_input(INPUT_POST, 'name');
  $version = filter_input(INPUT_POST, 'version', FILTER_VALIDATE_FLOAT);
  $release_date = filter_input(INPUT_POST, 'release_date');

  if ($code == NULL || $name == NULL || $version == NULL || $release_date == NULL) {
    $_SESSION['error_message'] = "Invalid product data. Check all fields and try again.";
    $url = '../errors/error.php';
    header("Location: " . $url);
    die();

  } else {
    try {
      require_once('../model/database.php');
      $query = 'INSERT INTO products (productCode, name, version, releaseDate) 
                VALUES (:code, :name, :version, :release_date)';

      $statement = $db->prepare($query);
      $statement->bindValue(':code', $code);
      $statement->bindValue(':name', $name);
      $statement->bindValue(':version', $version, PDO::PARAM_STR);
      $statement->bindValue(':release_date', $release_date);
      $statement->execute();
      $statement->closeCursor();

      // redirect to confirmation page
      $url = 'add_product_confirmation.php';
      header("Location: " . $url);
      die();
      
    } catch (PDOException $e) {
      // check if the error is due to a duplicate primary key
      if ($e->getCode() == 23000) { 
        $_SESSION['error_message'] = "The product code already exists. Please use a unique product code.";
        $url = '../errors/error.php';
        header("Location: " . $url);
        die();
      } else {
        // if some other database error occurred
        $_SESSION['error_message'] = "Database error: " . $e->getMessage();
        $url = '../errors/error.php';
        header("Location: " . $url);
        die();
      }
    }
  }
?>
