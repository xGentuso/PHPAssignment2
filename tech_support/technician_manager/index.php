<?php
require('../model/database.php');

try {
  $query = 'SELECT * FROM technicians';
  $statement = $db->prepare($query);
  $statement->execute();
  $technicians = $statement->fetchAll();
  $statement->closeCursor();
} catch (PDOException $e) {
  echo 'Database Error: ' . $e->getMessage();
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Technician Manager</title>
  <link rel="stylesheet" type="text/css" href="/PHPAssignment2/tech_support/css/main.css">
</head>
<body>
  <?php include('../view/header.php'); ?>
  <main>
    <h1>Technicians List</h1>
    <table>
      <thead>
        <tr>
          <th>Technician ID</th>
          <th>First name</th>
          <th>Last name</th>
          <th>Email</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($technicians as $technician) : ?>
        <tr>
          <td><?php echo htmlspecialchars($technician['techID']); ?></td>
          <td><?php echo htmlspecialchars($technician['firstName']); ?></td>
          <td><?php echo htmlspecialchars($technician['lastName']); ?></td>
          <td><?php echo htmlspecialchars($technician['email']); ?></td>
          <td><?php echo htmlspecialchars($technician['phone']); ?></td>
          <td>
            <form action="delete_technician.php" method="post">
              <input type="hidden" name="technician_id" value="<?php echo htmlspecialchars($technician['techID']); ?>">
              <input type="submit" value="Delete">
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="/PHPAssignment2/tech_support/technician_manager/add_technician_form.php">Add Technician</a>
    <?php include('../view/footer.php'); ?>
  </main>
</body>
</html>
