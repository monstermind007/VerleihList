<?php
@$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
if (!$dbconnection) {
    error_log("Fehler beim Verbinden der Datenbank");
    die("Verbindungsfehler");
}

$sql = "DELETE FROM `gegenstände` WHERE id ='".$_GET['id']."' ";

if (mysqli_query($dbconnection, $sql)) {
    header("Location: Materialliste.php");
} else {
    echo "Error deleting record" . $dbconnection->error;
}

$dbconnection->close();

?>