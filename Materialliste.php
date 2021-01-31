<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="style.css"/>
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
                $dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                ?>
                <br><br>
                <a onclick="window.open('printMaterialliste.php')" id="print">Drucken</a>
                <br><br>
                <div class="main__title">
                    <center>
                        <h1>Materialliste</h1>
                    </center>
                </div><br><br>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bezeichnung</th>
                        <th>Gesamtanzahl</th>
                        <th>Derzeitige Anzahl</th>
                        <th>Letzte Inventur</th>
                        <th>Lagerort</th>
                        <th>Kategorie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $ID = 1;
                    $user_qry = "SELECT * from gegenstände";
                    $user_res = mysqli_query($dbconnection, $user_qry);
                    while ($user_data = mysqli_fetch_assoc($user_res)) {
                        ?>
                        <tr>
                            <td><?php echo $user_data['ID']; ?></td>
                            <td><?php echo $user_data['Bezeichnung']; ?></td>
                            <td><?php echo $user_data['AnzahlGesamt']; ?></td>
                            <td><?php echo $user_data['AnzahlMomentan']; ?></td>
                            <td><?php echo $user_data['LetzteInventur']; ?></td>
                            <td><?php echo $user_data['Lagerort']; ?></td>
                            <td><?php echo $user_data['Kategorie']; ?></td>
                        </tr>
                        <?php
                        $ID++;
                    }
                    ?>
                    </tbody>
                </table>
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
            <div class="sidebar_link active_menu_link">
                <i class="rechter_text"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <h2>Schüler</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="#">Schüler Verwalten</a>
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
                <a href="#">Materialien anlegen</a>
            </div>
            <h2>Profil</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="#">Nachrichten</a>
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
                <?php
                if (isset($_POST["logoff"])) {
                    session_destroy();
                    header("Location:index.php");
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>