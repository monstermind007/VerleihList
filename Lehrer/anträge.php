<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Lehrer"]){
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
            <a class="active_link">Dashboard</a>
            <a>Schüler</a>
            <a>Materialliste</a>
            <a>Profil</a>
        </div>
        <!--Rechte Navigationsleiste mit Notification Symbol-->
        <div class="navigation_oben_rechts">
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
                <h1>Hallo <?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?> </h1>
            </div>
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");    //Die momentane verbindung
                //@$dbconnection = mysqli_connect("localhost", "root", "", "materialverleihDB"); //Zum testen weil der Server weg ist
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                function makeArrayFrom($db,$sql): ?array
                {
                    $sql_data = mysqli_query($db,$sql);
                    return mysqli_fetch_array($sql_data);
                }
                ?>
                <br>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <table class="table table-bordered">
                    <tr>
                        <th>Antrag von</th>
                        <th>Antrag Typ</th>
                        <th>Inhalt</th>
                        <th>Aktionen</th>
                    </tr>
                    <?php
                    $sql_antraege = "SELECT * FROM anträge WHERE Angenommen=0";                                         // db Befehle für anträge
                    $sql_data_antraege = mysqli_query($dbconnection,$sql_antraege);
                    $sql_array_antraege = mysqli_fetch_all($sql_data_antraege);

                    $bearbeiten = null;
                    foreach ($sql_array_antraege as $antrag){
                        $button_name = "yes".$antrag[0];
                        if(isset($_POST[$button_name])){
                            if($antrag[5] == null){
                                $sql = "INSERT INTO verleihungen (Gegenstand, VerliehenVon, VerliehenAn, Anzahl, Ausleihdatum, Rückgabedatum) 
                                VALUES ('".$antrag[2]."','".$_SESSION['ID']."','".$antrag[1]."','".$antrag[3]."',CURRENT_DATE,'".$antrag[4]."')";
                            } else {
                                $sql = "UPDATE verleihungen SET Rückgabedatum='".$antrag[6]."' WHERE ID='".$antrag[5]."'";
                            }
                            if(mysqli_query($dbconnection,$sql)) {
                                mysqli_query($dbconnection, "UPDATE anträge SET Angenommen=1 WHERE ID='" . $antrag[0] . "'");
                            }
                            break;
                        }
                        $button_name = "no".$antrag[0];
                        if(isset($_POST[$button_name])){
                            mysqli_query($dbconnection,"DELETE FROM anträge WHERE ID='".$antrag[0]."'");
                            break;
                        }
                        $button_name = "change".$antrag[0];
                        if(isset($_POST[$button_name])){
                            $bearbeiten = $antrag[0];
                            break;
                        }
                        $button_name = "ok".$antrag[0];
                        if(isset($_POST[$button_name])){
                            if(isset($_POST['anzahl'])) {
                                mysqli_query($dbconnection, "UPDATE anträge SET Anzahl='" . $_POST['anzahl'] . "' WHERE ID='" . $antrag[0] . "'");
                            } elseif (isset($_POST['abgabedatum'])) {
                                mysqli_query($dbconnection, "UPDATE anträge SET DatumNeu='" . $_POST['abgabedatum'] . "' WHERE ID='" . $antrag[0] . "'");
                            }
                            break;
                        }
                    }

                    $sql_data_antraege = mysqli_query($dbconnection,$sql_antraege);
                    $sql_array_antraege = mysqli_fetch_all($sql_data_antraege);
                    $sql_rows_antraege = mysqli_num_rows($sql_data_antraege);
                    $sql_array_person = makeArrayFrom($dbconnection,"SELECT Zuständig FROM personen WHERE ID='".$_SESSION['ID']."'");
                    for($i=0;$i<$sql_rows_antraege;$i++){
                        $sql_array_person2 = makeArrayFrom($dbconnection, "SELECT Name, Vorname FROM personen WHERE ID='".$sql_array_antraege[$i][1]."'");
                        if($sql_array_antraege[$i][2] == null && $sql_array_antraege[$i][3] == null && $sql_array_antraege[$i][4] == null){ // gucken welche art von Antrag es ist
                            $antrag_typ = "Abgabedatum ändern";
                        } else {
                            $antrag_typ = "Gegenstand ausleihen";
                        }
                        if($antrag_typ == "Gegenstand ausleihen"){
                            $sql_array_item = makeArrayFrom($dbconnection,"SELECT Bezeichnung, Kategorie FROM gegenstände WHERE ID='".$sql_array_antraege[$i][2]."'"); // db Befehle für gegenstände, mithilfe der Funktion in Zeile 56 verkürzt
                            if($sql_array_item[1] == $sql_array_person[0]){
                                echo "<tr>";
                                    echo "<td>".$sql_array_person2[0].", ".$sql_array_person2[1]."</td>";
                                    echo "<td>".$antrag_typ."</td>";
                                    echo "<td>".$sql_array_antraege[$i][3]."x ".$sql_array_item[0]." zu ".$sql_array_antraege[$i][4]."</td>";
                            }
                        } else {
                            $sql_array_verleihung = makeArrayFrom($dbconnection,"SELECT Gegenstand, Anzahl, Rückgabedatum FROM verleihungen WHERE ID='".$sql_array_antraege[$i][5]."'");
                            $sql_array_item = makeArrayFrom($dbconnection, "SELECT Bezeichnung, Kategorie FROM gegenstände WHERE ID='".$sql_array_verleihung[0]."'");
                            if($sql_array_item[1] == $sql_array_person[0]){
                                echo "<tr>";
                                    echo "<td>".$sql_array_person2[0].", ".$sql_array_person2[1]."</td>";
                                    echo "<td>".$antrag_typ."</td>";
                                    echo "<td>".$sql_array_verleihung[1]."x ".$sql_array_item[0]." von ".$sql_array_verleihung[2]." zu ".$sql_array_antraege[$i][6]."</td>";
                            }
                        }
                        if($sql_array_item[1] == $sql_array_person[0]) {
                            if($bearbeiten == $sql_array_antraege[$i][0] && $antrag_typ == "Gegenstand ausleihen"){
                                echo "<td>
                                    <div class='Inputfield2' style='left: 0'>
                                    <input type='number' name='anzahl' autocomplete='off'>
                                    <label>Neue Anzahl</label>
                                </div>
                                <input type='submit' id='submit2' style='left: 0' value='Ok' name='ok" . $sql_array_antraege[$i][0] . "'>
                                </td>";
                            } elseif ($bearbeiten == $sql_array_antraege[$i][0] && $antrag_typ == "Abgabedatum ändern") {
                                echo "<td>
                                    <div class='Inputfield2' style='left: 0'>
                                    <p>Neues Abgabedatum</p>
                                    <input type='date' name='abgabedatum' autocomplete='off'>
                                </div>
                                <input type='submit' id='submit2' style='left: 0' value='Ok' name='ok" . $sql_array_antraege[$i][0] . "'>
                                </td>";
                            }
                            else {
                                echo "<td>
                                        <input type='submit' id='submit2' style='left: 0' value='Akzeptieren' name='yes" . $sql_array_antraege[$i][0] . "'>
                                        <input type='submit' id='submit2' style='left: 0' value='Ablehnen' name='no" . $sql_array_antraege[$i][0] . "'>
                                        <input type='submit' id='submit2' style='left: 0' value='Bearbeiten' name='change" . $sql_array_antraege[$i][0] . "'>     
                                        </td>";
                                echo "</tr>";
                            }
                        }
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
                <a href="addstudent.php">Schüler Verwalten</a>
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
