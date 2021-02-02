<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ausleihenliste</title>
    <script type="text/javascript">
      function exit() {
        TheForm.submit();
        window.opener=null;
        window.close();
      }
    </script>
    <style media="screen">
      table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
      }
    </style>
  </head>
  <body>
    <?php
      $mysql_server_name='134.255.218.71:3306';
      $mysql_username='materiallisteDB';
      $mysql_password='1McR2.71';
      $mysql_db='materialverleihDB';

      $conn = mysqli_connect($mysql_server_name, $mysql_username, $mysql_password, $mysql_db);
      if ($conn->connect_error) {die("ERROR: ".$conn->connect_error);}

      session_start();
      if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        if(isset($_SESSION['id'])) {
    ?>
          <center>
              <h2>Was habe ich ausgeliehen?</h2>
              <table>
                  <tr>
                      <th>ID</th>
                      <th>Gegenstand</th>
                      <th>VerliehenVon</th>
                      <th>VerliehenAn</th>
                      <th>Anzahl</th>
                      <th>Ausleihdatum</th>
                      <th>Rückgabedatum</th>
                      <th>Rückgegeben</th>
                  </tr>
        <?php
            $id = $_SESSION['id'];

            // WHERE Username = '$username' AND Password = '$passwort'";
            $sql = "SELECT * FROM verleihungen WHERE VerliehenAn = $id";
            $result = mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)){
                echo
                  "<tr>
                    <td>".$row["ID"]."</td>
                    <td>".$row["Gegenstand"]."</td>
                    <td>".$row["VerliehenVon"]."</td>
                    <td>".$row["VerliehenAn"]."</td>
                    <td>".$row["Anzahl"]."</td>
                    <td>".$row["Ausleihdatum"]."</td>
                    <td>".$row["Rückgabedatum"]."</td>
                    <td>".$row["Rückgegeben"]."</td>
                  <tr>";
            }
            mysqli_close($conn);
        ?>
            </table>

            <br><br><br>

            <h2>Frühere Rückgabe</h2>
            <p>Bitte geben sie die Objekt-ID und die Anzahl ein.</p>
            <form class="" action="Rückgabe.php" method="post">
               <input type="text" name="ObID" placeholder="Objekt ID">
               <input type="number" name="rückgabeanzahl" placeholder="Anzahl">
               <input type="submit" name="button" value="Zurückgeben">
            </form>
          </center>
      <?php
        }
        else {
          echo "<center>";
            echo "<h1>Error: Bitter versuchen sie nochmal anzumelden<h2>";
          echo "</center>";
        }
      }
      else {
        echo "<center>";
          echo "<h1>Melden Sie bitte zuerst an<h1>";
        echo "</center>";
      }
      ?>
  </body>
</html>
