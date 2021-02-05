<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Lehrer"]) {
    header('Location:../index.php');
}
if (isset($_POST["logoff"])) {
    session_destroy();
    header("Location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="../style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a>Schüler</a>
            <a class="active_link">Materialliste</a>
            <a>Profil</a>
        </div>
        <!--Rechte Navigationsleiste mit Notification Symbol-->
        <div class="navigation_oben_rechts">
            <a class="active_link" href="support.php"><img src="support.png"></a>
            <a href="messages.php">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <div class="count-container hidden" data-region="count-container">0</div>
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
                            <th>Von</th>
                            <th>Gegenstand</th>
                            <th>Anzahl</th>
                            <th>Abgabedatum</th>
                            <th>Annehmen</th>
                        </tr>
                        <?php
                        $sql_antrag = "SELECT ID,Von,Gegenstand,Anzahl,AbgabeDatum,Angenommen  FROM anträge WHERE Angenommen=0";
                        $sql_data_antrag = mysqli_query($dbconnection, $sql_antrag);
                        $sql_array_antrag = mysqli_fetch_all($sql_data_antrag, MYSQLI_BOTH);
                        foreach ($sql_array_antrag as $val) {
                            $valID = $val[0];
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                if (isset($_POST[$valID])) {
                                    $sql_update_antrag_angenommen = "UPDATE anträge SET Angenommen = 1 WHERE ID= $valID";
                                    $sql_update_antrag_notification = "UPDATE anträge SET GelesenSchüler = 0 WHERE ID= $valID";
                                    if (mysqli_query($dbconnection, $sql_update_antrag_angenommen)) {
                                        echo "Antrag wurde erfolgreich bestätigt!";
                                    } else {
                                        echo "Antrag konnte nicht bestätigt werden." . mysqli_error($dbconnection);
                                    }
                                }
                            }
                        }
                        unset($val);
                        $sql_data_antrag = mysqli_query($dbconnection,$sql_antrag);
                        $sql_array_antrag = mysqli_fetch_all($sql_data_antrag, MYSQLI_BOTH);
                        foreach($sql_array_antrag as $antrag){
                            $sql_personen = "SELECT * FROM personen WHERE ID = {$antrag['Von']}";
                            $sql_data_personen = mysqli_query($dbconnection,$sql_personen);
                            $sql_array_personen = mysqli_fetch_all($sql_data_personen, MYSQLI_BOTH);
                            $sql_gegenstand = "SELECT * FROM gegenstände WHERE ID={$antrag['Gegenstand']}";
                            $sql_data_gegenstand = mysqli_query($dbconnection,$sql_gegenstand);
                            $sql_array_gegenstand = mysqli_fetch_all($sql_data_gegenstand, MYSQLI_BOTH);
                            echo "<tr>";
                            echo "<td style='min-width: 10em'>".$sql_array_personen[0]["Vorname"]."</td>";
                            echo "<td style='text-align: justify;'><h3>".$antrag['Gegenstand']."</td>";
                            echo "<td style='text-align: justify;'><h3>".$antrag['Anzahl']."</h3></td>";
                            echo "<td style='text-align: justify;'><h3>".$antrag['AbgabeDatum']."</td>";
                            echo "<td><input type='submit' id='submit2' style='left: 0' value='Annehmen' name={$antrag["ID"]}></td>";
                            echo"</tr>";
                        }
                        /*
                        $sql_rows_antrag = mysqli_num_rows($sql_data_antrag);
                        for ($i=0;$i<$sql_rows_antrag;$i++){
                            $k = $i+1;
                            $sql_personen = "SELECT Name,Vorname FROM personen WHERE ID=$k";
                            $sql_data_personen = mysqli_query($dbconnection,$sql_personen);
                            $sql_array_personen = mysqli_fetch_all($sql_data_personen, MYSQLI_BOTH);
                            $sql_gegenstand = "SELECT Bezeichnung FROM gegenstände WHERE ID=$k";
                            $sql_data_gegenstand = mysqli_query($dbconnection,$sql_gegenstand);
                            $sql_array_gegenstand = mysqli_fetch_array($sql_data_gegenstand);
                            echo "<tr>";
                            echo "<td style='min-width: 10em'>".$sql_array_personen[0]["Vorname"]."</td>";
                            echo "<td style='text-align: justify;'><h3>".$sql_array_antrag[$i][2]."</td>";
                            echo "<td style='text-align: justify;'><h3>".$sql_array_antrag[$i][3]."</h3></td>";
                            echo "<td style='text-align: justify;'><h3>".$sql_array_antrag[$i][4]."</td>";
                            echo "<td><input type='submit' id='submit2' style='left: 0' value='Annehmen' name='".$sql_array_antrag[$i][0]."'></td>";
                            echo"</tr>";
                        }
                        */
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
            <h1><?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"];?></h1>
        </div>

        <div class="sidebar_menu">
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <h2>Schüler</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="students.php">Schüler Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addstudent.php">Schüler anlegen</a>
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
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="anträge.php">Offene Anträge</a>
            </div>
            <h2>Profil</h2>
            <div class="sidebar_link active_menu_link">
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
</body>
</html>