<?php

$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];

//echo "$username, $password, $gender, $email, $phoneCode; $phone";


if (!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phoneCode) || !empty($phone)) {
  $dbServer = "localhost";
  $dbUsername = "root";
  $dbPassword = "e1M9M7ya6";
  $dbName = "testing";

  //create connection
  $conn = new MySQLi($dbServer, $dbUsername, $dbPassword, $dbName);


  if (mysqli_connect_error()) {
      die('connect_error(' . mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
    $SELECT = "SELECT email FROM register WHERE email = ?";
    $SELECT1 = "SELECT username FROM register WHERE username = ?";
    $INSERT = "INSERT INTO register (username, password, gender, email, phoneCode, phone) VALUES (?,?,?,?,?,?)";

    //prepare statement email
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    //prepare statement $username
    $stmt1 = $conn->prepare($SELECT1);
    $stmt1->bind_param("s",$username);
    $stmt1->execute();
    $stmt1->bind_result($username);
    $stmt1->store_result();
    $rnum1 = $stmt1->num_rows;

    //echo 'Num rows: ' . $stmt->num_rows . "<BR />\n";

    if (($rnum + $rnum1)>0) {
        $stmt->close();
        $stmt1->close();

        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssssii", $username, $password, $gender, $email, $phoneCode, $phone);
        $stmt->execute();
        echo "New record inserted sucessfully";
      } else {
          echo "Someone already register using this email";
          //$error = $conn->errno . ' ' . $conn->error;
          //echo $error; // 1054 Unknown column 'foo' in 'field list'
      }
      $stmt->close();
      $conn->close();
    }
} else {
  echo "All field are required";
  die();
}

?>