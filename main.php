<?php
require 'config.php';

if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = $id");
  $row = mysqli_fetch_assoc($result);
}
else{
  header("Location: login.php");
}

if(isset($_POST["submit"])){
  $room = $_POST["room"];
  $building_letter = $_POST["building_letter"];
  $building_floor = $_POST["building_floor"];
  $info = $_POST["info"];
  $latitude = $_POST["latitude"];
  $longitude = $_POST["longitude"];
  $user_id = $_SESSION["id"];

  $query = "INSERT INTO tb_data VALUES('', '$room', '$building_letter', '$building_floor', '$info', '$latitude', '$longitude', '$user_id')";
  mysqli_query($conn, $query);

  echo "<script> alert('Data Successfully Submitted'); </script>";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Index</title>
    <script>
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;
      }
    </script>
  </head>
  <body>
    <h1>Welcome <?php echo $row["name"]; ?></h1>

    <form method="post">
      <label for="room">Room NO.:</label>
      <input type="text" name="room" required><br>

      <label for="building_letter">Building Letter:</label>
      <select name="building_letter" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select><br>

      <label for="building_floor">Building Floor:</label>
      <select name="building_floor" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select><br>

      <button type="button" onclick="getLocation()">Get Location</button>
      <label for="latitude">Latitude:</label>
      <input type="text" name="latitude" id="latitude" required><br>
      <label for="longitude">Longitude:</label>
      <input type="text" name="longitude" id="longitude" required><br>

      <label for="info">Information:</label>
      <textarea name="info" required></textarea><br>

      <button type="submit" name="submit">Submit</button>
    </form>

    <a href="logout.php">Logout</a>
  </body>
</html>
