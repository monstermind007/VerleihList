<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Admin"]){
    header('Location:../index.php');
}
if (isset($_POST["logoff"])) {
    session_destroy();
    header('Location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="../style.css"/>
</head>
<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a>User</a>
            <a>Materialliste</a>
            <a>Profil</a>
        </div>
        <!--Rechte Navigationsleiste mit Notification Symbol-->
        <div class="navigation_oben_rechts">
            <a class="active_link" href="support.php"><img src="support.png"></a>
            <a href="#">
                <i class="notification" aria-hidden="true"></i>
            </a>
            <!--Profilbild Datenbank wenn möglich-->
            </a>
        </div>
    </nav>

    <!--Hauptteil -->
    <main>
        <div class="main_container">
            <div class="main__title">
            </div>
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");    //Die momentane verbindung
                //@$dbconnection = mysqli_connect("localhost", "root", "", "materialverleihDB"); //Zum testen weil der Server weg ist
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                ?>
                <br>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <table class="table table-bordered">
                    <tr>
                        <th>Support Ticket von</th>
                        <th><h3>Betreff</h3> & Inhalt</th>
                        <th>Abschließen</th>
                    </tr>
                    <?php
                    $sql_support = "SELECT ID,Von,Betreff,Inhalt FROM support WHERE Bearbeitet=0";
                    $sql_data_support = mysqli_query($dbconnection,$sql_support);
                    $sql_array_support = mysqli_fetch_all($sql_data_support);
                    foreach ($sql_array_support as $val){
                        $valID = $val[0];
                        if(isset($_POST["$valID"])){
                            $sql_update_support = "UPDATE support SET Bearbeitet=1 WHERE ID=$valID";
                            if(mysqli_query($dbconnection,$sql_update_support)){
                                echo "Support Ticket mit der ID ".$valID." wurde erfolgreich als Bearbeitet markiert.";
                            } else {
                                echo "Fehler beim markieren des Support Tickets mit der ID ".$valID." : ".mysqli_error($dbconnection);
                            }
                        }
                    }
                    unset($val);
                    $sql_data_support = mysqli_query($dbconnection,$sql_support);
                    $sql_array_support = mysqli_fetch_all($sql_data_support);
                    $sql_rows_support = mysqli_num_rows($sql_data_support);
                    for ($i=0;$i<$sql_rows_support;$i++){
                        $k = $i+1;
                        $sql_personen = "SELECT Name,Vorname FROM personen WHERE ID=$k";
                        $sql_data_personen = mysqli_query($dbconnection,$sql_personen);
                        $sql_array_personen = mysqli_fetch_array($sql_data_personen);
                        echo "<tr>";
                            echo "<td style='min-width: 10em'>".$sql_array_personen[0].", ".$sql_array_personen[1]."</td>";
                            echo "<td style='text-align: justify;'><h3>".$sql_array_support[$i][2]."</h3><br>".$sql_array_support[$i][3]."</td>";
                            echo "<td><input type='submit' id='submit2' style='left: 0' value='Abschließen' name='".$sql_array_support[$i][0]."'></td>";
                        echo"</tr>";
                    }
                    ?>
                </table>
                </form>
            </div>
        </div>
    </main>
    <!-- Seitliche Navigation Links -->
    <div id="sidebar">
        <div class="user">
            <!-- Hier könnte man noch ein Profilbild einstllen-->
            <h1><?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?></h1>
        </div>

        <div class="sidebar_menu">
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <h2>User</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="students.php">Schüler Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addstudent.php">Schüler anlegen</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="teachers.php">Lehrer Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addteacher.php">Lehrer Anlegen</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="admins.php">Admins Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addadmin.php">Admin anlegen</a>
            </div>
            <h2>Materialliste</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="Materialliste.php">Liste</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addmaterials.php">Materialien anlegen</a>
            </div>
            <h2>Profil</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="messages.php">Nachrichten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="daten.php">Profildaten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="profile.php">Daten ändern</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="profile_password.php">Passwort ändern</a>
            </div>
            <div class="sidebar_logout">
                <i class="rechter_text"></i>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <input type="submit" value="Abmelden" name="logoff" id="logoff">
                </form>
            </div>
        </div>
    </div>
</div>
<script>history.pushState({}, "", "")</script>
</body>
</html>
