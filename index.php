<?php

$servername='134.255.220.55:3306';
$username='materiallisteDB';
$password='1McR2.71';
$database='materialverleihDB';

$conn = new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully<br>";
$sql = "SELECT EMail FROM personen WHERE Name='Admin'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "E-Mail: " . $row["EMail"]."<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
