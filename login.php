<?php
$mysql_server_name='localhost';
$mysql_username='root';
$mysql_password='123456';
$mysql_database='Mydb';

$conn = mysqli_connect($mysql_server_name, $mysql_username, $mysql_password);
if ($conn->connect_error) {die("ERROR: ".$conn->connect_error);}

mysqli_query($conn, "set names 'utf8'");
mysqli_select_db($mysql_database);

/***********************************************************************************************************************/

// Info speichern (registrieren)
if ($conn) {
    $sql = "INSERT INTO account (ID, Username, Password)
    	VALUES ('', '$username', '$password')";
}
else {
    die("Connection failed: " . mysqli_connect_error());
}
if (mysqli_query($conn, $sql)) {
    echo "Registration erfolgreich!";
}
else {
    echo "Error creating database: " . mysqli_error($conn);
}

$result = mysqli_query($conn, $sql);
if(!$result) {die('Error: '.mysqli_error($conn));}

/***********************************************************************************************************************/

// Info Lesen (login)
$sql = "SELECT Zeile1, Zeile2, Zeile3 FROM TabelleName";
$ergibnis = $conn->query($sql);

if (!empty($passwort) || !empty($username)) {                    // Wenn Password oder Username ist nicht leer, dann
    $sql = "SELECT Username, Password FROM account WHERE Username = '$username' AND Password = '$passwort'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error:%s\n", mysqli_error($conn));
        exit();
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $passwort_db = $row['Password'];
        $username_db = $row['Username'];
    }

/***********************************************************************************************************************/
}
mysqli_close();
function fensterOeffnen () {
    var text ='<p></p>';
    var Nachrichten = window.open("about:blank", "Nachrichten", "width=300,height=400,left=100,top=200");
    Nachrichten.document.write(text);
    Nachrichten.focus();
}
?>