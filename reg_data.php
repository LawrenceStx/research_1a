<?php
require 'config.php';

// Handle deletion of a user
if(isset($_GET["delete"])){
  $id = $_GET["delete"];
  mysqli_query($conn, "DELETE FROM tb_user WHERE id = '$id'");
  header("Location: admin.php");
}

// Handle editing of a user
if(isset($_GET["edit"])){
  $id = $_GET["edit"];
  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = '$id'");
  $row = mysqli_fetch_array($result);
  $name = $row["name"];
  $username = $row["username"];
  $email = $row["email"];
  $password = $row["password"];

  if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    mysqli_query($conn, "UPDATE tb_user SET name = '$name', username = '$username', email = '$email', password = '$password' WHERE id = '$id'");
    header("Location: admin.php");
  }

  // Display the form for editing a user
  echo "
    <form method='POST'>
      <label>Name:</label>
      <input type='text' name='name' value='$name' required>
      <br>
      <label>Username:</label>
      <input type='text' name='username' value='$username' required>
      <br>
      <label>Email:</label>
      <input type='email' name='email' value='$email' required>
      <br>
      <label>Password:</label>
      <input type='password' name='password' value='$password' required>
      <br>
      <button type='submit' name='submit'>Save</button>
    </form>
  ";
}

// Display search form
echo "
  <form method='GET'>
    <input type='text' name='q' placeholder='Search by name or email'>
    <button type='submit'>Search</button>
  </form>
";

// Display all the registered users in a table
echo "
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
";

$q = isset($_GET['q']) ? $_GET['q'] : '';
$where = '';
if ($q != '') {
  $where = "WHERE name LIKE '%$q%' OR email LIKE '%$q%'";
}
$result = mysqli_query($conn, "SELECT * FROM tb_user $where");
while($row = mysqli_fetch_array($result)){
  $id = $row["id"];
  $name = $row["name"];
  $username = $row["username"];
  $email = $row["email"];
  echo "
    <tr>
      <td>$id</td>
      <td>$name</td>
      <td>$username</td>
      <td>$email</td>
      <td>
        <a href='admin.php?edit=$id'>Edit</a>
        <a href='admin.php?delete=$id'>Delete</a>
      </td>
    </tr>
  ";
}

echo "</table>";
?>
