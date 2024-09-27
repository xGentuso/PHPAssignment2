<?php
  session_start();

  // retrieve and sanitize input data
  $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
  $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  // validate input data
  if ($first_name == NULL || $last_name == NULL || $email == NULL || $phone == NULL || $password == NULL) {
    $_SESSION['error_message'] = "Invalid technician data. Check all fields and try again.";
    $url = '../errors/error.php';
    header("Location: " . $url);
    die();
  } else {
    try {
      require_once('../model/database.php');

      $query = 'INSERT INTO technicians
        (firstName, lastName, email, phone, password) 
        VALUES (:first_name, :last_name, :email, :phone, :password)';

      $statement = $db->prepare($query);
      $statement->bindValue(':first_name', $first_name, PDO::PARAM_STR);
      $statement->bindValue(':last_name', $last_name, PDO::PARAM_STR);
      $statement->bindValue(':email', $email, PDO::PARAM_STR);
      $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
      $statement->bindValue(':password', $password, PDO::PARAM_STR);
      $statement->execute();
      $statement->closeCursor();

      // optionally log the addition of a new technician
      error_log("New technician added: " . $first_name . " " . $last_name . " (" . $email . ")");

      // redirect to confirmation page
      $url = 'add_technician_confirmation.php';
      header("Location: " . $url);
      die();

    } catch (PDOException $e) {
      // log the detailed error message for debugging
      error_log("Database Error: " . $e->getMessage());

      // set a generic error message for the user
      $_SESSION['error_message'] = "An unexpected error occurred while adding the technician. Please try again later.";
      $url = '../errors/error.php';
      header("Location: " . $url);
      die();
    }
  }
?>
