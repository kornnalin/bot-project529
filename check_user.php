<?php
include("connectDB.php");
$sqlSelect = "SELECT * FROM User";
$result = mysqli_query($connect, $sqlSelect);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $userID = $row["userID"];
      $name = $row["name"];
      $status = $row["status"];
      echo "----------------------------<br>";
      echo $userID."<br>";
      echo $name."<br>";
      echo $status."<br>";
      echo "----------------------------<br>";
    }
}

?>
