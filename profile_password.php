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
                <?php
                $dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                if (isset($_POST["ändern"])){
                    $id = $_SESSION["id"];
                    $passwordold = $_POST["passwordold"];
                    $passwordnew1 = $_POST["passwordnew1"];
                    $passwordnew2 = $_POST["passwordnew2"];

                    if ($passwordnew1 == $passwordold){
                        echo "Neues Passwort darf nicht dem alten entsprechen";
                    }
                    else {
                        if ($passwordnew1 == $passwordnew2){
                            $ändern = "UPDATE personen SET Password = '" . $passwordnew1 . "' WHERE ID = '" . $id . "'";
                            $sql_res_query = mysqli_query($dbconnection, $ändern);
                            echo "Passwort wurde erfolgreich geändert!";
                        }
                        else{
                            echo "Die Passwörter stimmen nicht überein";
                        }
                    }
                }
                ?>
                <div class="main__title">
                    <center>
                        <h1>Passwort ändern</h1>
                    </center><br>
                </div>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="Inputfield2">
                    <input type="digits" name="passwordold" required autocomplete="off">
                    <label>Aktuelles Passwort</label>
                </div>
                <div class="Inputfield2">
                    <input type="digits" name="passwordnew1" required autocomplete="off">
                    <label>Neues Passwort</label>
                </div>
                <div class="Inputfield2">
                    <input type="digits" name="passwordnew2" required autocomplete="off">
                    <label>Passwort bestätigen</label>
                </div>
                <input type="submit" value="Ändern" name="ändern" id="submit2">
                </form>
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
                    header("Location:index.php");
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
