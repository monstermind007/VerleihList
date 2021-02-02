<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Rückgabe</title>
  </head>
  <body>
    <?php
      $mysql_server_name='134.255.218.71:3306';
      $mysql_username='materiallisteDB';
      $mysql_password='1McR2.71';
      $mysql_db='materialverleihDB';

      $conn = mysqli_connect($mysql_server_name, $mysql_username, $mysql_password, $mysql_db);
      if ($conn->connect_error) {die("ERROR: ".$conn->connect_error);}

      $sql = "SELECT Anzahl FROM verleihungen WHERE ID={$_POST['ObID']}";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_array($result)) {
        $Anzahl_DB = array($row['Anzahl']);
      }
      echo $Anzahl_DB[0];

      $Anzahl = $Anzahl_DB[0] - $_POST['rückgabeanzahl'];

      if ($Anzahl == 0) {
        $sql = "DELETE FROM verleihungen WHERE ID={$_POST['ObID']}";
        $result = mysqli_query($conn, $sql);
      }
      elseif ($Anzahl >= 1) {
        $sql = "UPDATE verleihungen SET Anzahl=$Anzahl WHERE ID={$_POST['ObID']}";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE verleihungen SET Rückgegeben=GETDDATE() WHERE ID={$_POST['ObID']}";
        $result = mysqli_query($conn, $sql);
      }
      elseif ($Anzahl <= -1) {
        echo "Sie haben nicht so viele gelehen!";
      }

      mysqli_close($conn);

      header("Location: /verleihen/Ausleihenliste.php\n");
      exit;
    ?>
  </body>
</html>
