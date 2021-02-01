<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
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
            <a>Schüler</a>
            <a>Materialliste</a>
            <a class="active_link">Profil</a>
        </div>
        <!--Rechte Navigationsleiste mit Notification Symbol-->
        <div class="navigation_oben_rechts">
            <a href="#">
                <i class="notification" aria-hidden="true"></i>
            </a>
            <!--Profilbild Datenbank wenn möglich-->
        </div>
    </nav>

    <!--Hauptteil -->
    <main>
        <div class="main_container">
            <div class="Main">
                <div class="main__title">
                    <center>
                        <h1>Profil Daten</h1>
                    </center>
                </div>
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                $sql_data = "SELECT * FROM personen WHERE ID = '" . $_SESSION['ID'] . "' ";
                $sql_data_res = mysqli_query($dbconnection, $sql_data);
                $sql_array = mysqli_fetch_array($sql_data_res);
                ?>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <td>Nutzer-ID</td>
                        <td><?php echo $sql_array["ID"]; ?></td>
                    </tr>
                    <tr>
                        <td>Vorname</td>
                        <td><?php echo $sql_array["Vorname"]; ?></td>
                    </tr>
                    <tr>
                        <td>Nachname</td>
                        <td><?php echo $sql_array["Name"]; ?></td>
                    </tr>
                    <tr>
                        <td>Klasse</td>
                        <td><?php echo $sql_array["Klasse"]; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $sql_array["EMail"]; ?></td>
                    </tr>
                    <tr>
                        <td>Telefonnr.</td>
                        <td><?php echo $sql_array["Telefon"]; ?></td>
                    </tr>
                    <tr>
                        <td>Straße</td>
                        <td><?php echo $sql_array["Straße"]; ?></td>
                    </tr>
                    <tr>
                        <td>PLT</td>
                        <td><?php echo $sql_array["PLZ"]; ?></td>
                    </tr>
                    <tr>
                        <td>Ort</td>
                        <td><?php echo $sql_array["Ort"];?></td>
                    </tr>
                    </thead>
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
                <a href="#">Liste</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="Materialliste.php">Materialien anlegen</a>
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
                    header("Location:../index.php");
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
