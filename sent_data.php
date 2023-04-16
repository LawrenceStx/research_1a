<?php
require 'config.php';

// check if the search term has been submitted
if(isset($_GET['search'])) {
  // sanitize the user input to prevent SQL injection attacks
  $search_term = mysqli_real_escape_string($conn, $_GET['search']);
  
  // create a query to search for data matching the search term
  $query = "SELECT * FROM tb_data WHERE id LIKE '%$search_term%' OR room LIKE '%$search_term%' OR building_letter LIKE '%$search_term%' OR building_floor LIKE '%$search_term%' OR latitude LIKE '%$search_term%' OR longitude LIKE '%$search_term%' OR info LIKE '%$search_term%' OR user_id LIKE '%$search_term%'";
  
  // execute the query and get the results
  $data_result = mysqli_query($conn, $query);
} else {
  // if the search term hasn't been submitted, get all data from tb_data table
  $data_result = mysqli_query($conn, "SELECT * FROM tb_data");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Data List</title>
  </head>
  <body>
    <form action="" method="get">
      <label for="search">Search:</label>
      <input type="text" name="search" id="search" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>">
      <button type="submit">Search</button>
    </form>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Room NO.</th>
          <th>Building Letter</th>
          <th>Building Floor</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th>Information</th>
          <th>User ID</th>
        </tr>
      </thead>
      <tbody>
        <?php while($data_row = mysqli_fetch_assoc($data_result)) { ?>
          <tr>
            <td><input type="checkbox" name="data_id[]" value="<?php echo $data_row['id']; ?>"></td>
            <td><?php echo $data_row["id"]; ?></td>
            <td><?php echo $data_row["room"]; ?></td>
            <td><?php echo $data_row["building_letter"]; ?></td>
            <td><?php echo $data_row["building_floor"]; ?></td>
            <td><?php echo $data_row["latitude"]; ?></td>
            <td><?php echo $data_row["longitude"]; ?></td>
            <td><?php echo $data_row["info"]; ?></td>
            <td><?php echo $data_row["user_id"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="logout.php">Logout</a>
  </body>
</html>
