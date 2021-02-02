<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Schueler"]) {
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
            <a class="active_link">Materialliste</a>
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
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                ?> <br><br>
                <br><br>
                <div class="main__title">
                    <center>
                        <h1>Meine Anträge</h1>
                    </center>
                </div>
                <br><br>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <th>Gegenstand</th>
                        <th>Verliehen Von</th>
                        <th>Anzahl</th>
                        <th>Ausgeliehen am</th>
                        <th>Rückgabe ist</th>
                        <th>Rückgabe soll</th>
                        <th>Zurückgegeben</th>
                    </tr>

                    <tbody>
                    <?php
                    $sql_data = "SELECT * FROM verleihungen WHERE ID = '" . $_SESSION['ID'] . "' ";
                    $sql_data_res = mysqli_query($dbconnection, $sql_data);
                    $sql_array = mysqli_fetch_array($sql_data_res);
                    $sql_data2 = "SELECT * FROM verleihungen JOIN gegenstände ON verleihungen.ID = gegenstände.ID";
                    $sql_data_res2 = mysqli_query($dbconnection, $sql_data2);
                    $sql_array2 = mysqli_fetch_array($sql_data_res2);
                    $sql_data3 = "SELECT * FROM verleihungen JOIN personen ON verleihungen.ID = personen.ID";
                    $sql_data_res3 = mysqli_query($dbconnection, $sql_data3);
                    $sql_array3 = mysqli_fetch_array($sql_data_res3);
                    ?>
                    <tr>
                        <td><?php echo $sql_array2["Bezeichnung"]; ?></td>
                        <td><?php echo $sql_array3["Name"]; ?></td>
                        <td><?php echo $sql_array["Anzahl"]; ?></td>
                        <td><?php echo $sql_array["Ausleihdatum"]; ?></td>
                        <td><?php echo $sql_array["RückgabeIst"]; ?></td>
                        <td><?php echo $sql_array["Rückgabedatum"]; ?></td>
                        <td><?php if("1" == $sql_array["Rückgegeben"]){
                            echo "Ja";
                            }
                            elseif ("0" == $sql_array["Rückgegeben"]) {
                                echo "Nein";
                            }; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
    </main>
    <!-- Seitliche Navigation Links -->
    <div id="sidebar">
        <div class="user">
            <!-- Hier könnte man noch ein Profilbild einstllen-->
            <h1><?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?></h1>
        </div>

        <div class="sidebar_menu">
            <div class="sidebar_link active_menu_link">
                <i class="rechter_text"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <h2>Materialliste</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="Materialliste.php">Liste</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="anträge.php">Alle Anträge</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="neuerAntrag.php">Antrag stellen</a>
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
</body>
</html>
