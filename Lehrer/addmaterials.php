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
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../style.css" />
</head>

<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a class="active_link">Materialliste</a>
            <a>Materialliste</a>
            <a>Profil</a>
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
            <?php
            if (isset($_POST["registrierung"])) {
                $id = $_POST["material_id"];
                $bezeichnung = $_POST["bezeichnung"];
                $anzahlGesamt = $_POST["anzahlGesamt"];
                $anzahlMomentan = $_POST["anzahlMomentan"];
                $letzteInventur = $_POST["letzteInventur"];
                $lagerort = $_POST["lagerort"];
                $kategorie = $_POST["kategorie"];

                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if(!$dbconnection)
                {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                $eintrag = "INSERT INTO gegenstände (ID, Bezeichnung, AnzahlGesamt, AnzahlMomentan, LetzteInventur, Lagerort, Kategorie)
                VALUES ('$id','$bezeichnung', '$anzahlGesamt', '$anzahlMomentan', '$letzteInventur', '$lagerort', '$kategorie')";
                $result = mysqli_fetch_assoc($eintrag);
                $num = mysqli_num_rows($eintrag);
                if($num) {
                    "UPDATE gegenstände SET ID = $id , Bezeichnung = $bezeichnung , AnzahlGesamt = $anzahlGesamt , AnzahlMomentan = $anzahlMomentan , LetzteInventur = $letzteInventur , Lagerort = $lagerort , Kategorie = $kategorie WHERE ID = '".$result['material_id']."'";
                } else {
                    "INSERT INTO gegenstände (ID, Bezeichnung, AnzahlGesamt, AnzahlMomentan, LetzteInventur, Lagerort, Kategorie) VALUES ('$id','$bezeichnung', '$anzahlGesamt', '$anzahlMomentan', '$letzteInventur', '$lagerort', '$kategorie')";
                }

                if (mysqli_query($dbconnection, $eintrag)){
                    print("Erfolgreich eingetragen");
                }
                else {
                    die("Fehler!");
                }
            }
            ?>
            <div class="Main">
                <div class="main__title">
                    <center>
                        <h1>Materialien anlegen</h1>
                    </center>
                </div><br><br>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="Inputfield2">
                        <input type="digits" name="material_id" required autocomplete="off">
                        <label>ID</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="bezeichnung" required autocomplete="off">
                        <label>Bezeichnung</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="anzahlGesamt" required autocomplete="off">
                        <label>AnzahlGesamt</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="number" name="anzahlMomentan" required autocomplete="off">
                        <label>AnzahlMomentan</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="date" name="letzteInventur" required autocomplete="off">
                        <label>LetzteInventur</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="lagerort" required autocomplete="off">
                        <label>Lagerort</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="number" name="kategorie" required autocomplete="off">
                        <label>Kategorie</label>
                    </div>
                    <input type="submit" value="Anlegen" name="registrierung" id="submit2">
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
            <div class="sidebar_link active_menu_link">
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
</body>
</html>
