<?php
  session_start();
  
  // optional: Role-Based Access Control
  // ensure that only admins can delete technicians
  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error_message'] = "Unauthorized access.";
    header("Location: ../errors/error.php");
    exit();
  }
  
  // retrieve and sanitize the technician ID from POST data
  $tech_id = filter_input(INPUT_POST, 'technician_id', FILTER_VALIDATE_INT);
  
  if ($tech_id === NULL || $tech_id === FALSE) {
    $_SESSION['error_message'] = "Invalid Technician ID. Check all fields and try again.";
    include('../errors/error.php');
  } else {
    try {
      require_once('../model/database.php');
  
      // prepare the DELETE statement to remove the technician
      $query = 'DELETE FROM technicians WHERE techId = :tech_id';
      $statement = $db->prepare($query);
      $statement->bindValue(':tech_id', $tech_id, PDO::PARAM_INT);
      $statement->execute();
      $statement->closeCursor();
  
      // optionally log the deletion of a technician
      error_log("Technician with ID $tech_id has been deleted.");
  
      // redirect to confirmation page
      $url = 'delete_technician_confirmation.php';
      header("Location: " . $url);
      die();
  
    } catch (PDOException $e) {
      // log the detailed error message for debugging
      error_log("Database Error: " . $e->getMessage());
  
      // set a generic error message for the user
      $_SESSION['error_message'] = "An unexpected error occurred while deleting the technician. Please try again later.";
      $url = '../errors/error.php';
      header("Location: " . $url);
      die();
    }
  }
?>
