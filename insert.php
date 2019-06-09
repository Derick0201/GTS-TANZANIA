<?php
$firstname = $_POST['First Name'];
$lastname = $_POST['Last Name'];
$Username = $_POST['Username'];
$Phonenumber = $_POST['Phone Number'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
if (!empty($firstname) || !empty($lastname) || !empty($Username) || !empty($Phonenumber) || !empty($Email) || !empty($Password)) {
 $host = "localhost";
    $dbUsername = "phpmyadmin";
    $dbPassword = "kitori";
    $dbname = "Registration";

    //create connection

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT Username From Registration Where Username = ? Limit 1";
     $INSERT = "INSERT Into Registration (firstname, lastname, Username, Phonenumber, Email, Password) values(?, ?, ?, ?, ?, ?)";

     //Prepare statement

     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $Username);
     $stmt->execute();
     $stmt->bind_result($Username);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssiss", $firstname, $lastname, $Username, $Phonenumber, $Email, $Password);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this Username";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>