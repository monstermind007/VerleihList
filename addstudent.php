<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
</head>

<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a class="active_link">Schüler</a>
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
                $vorname = $_POST["vorname"];
                $nachname = $_POST["nachname"];
                $telefon = $_POST["telefon"];
                $klasse = $_POST["klasse"];
                $straße = $_POST["straße"];
                $plz = $_POST["plz"];
                $ort = $_POST["ort"];
                $email = $_POST["email"];
                $passwort = $_POST["passwort"];

                $dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if(!$dbconnection)
                {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                $eintrag = "INSERT INTO personen (Vorname, Name, Telefon, Klasse, Straße, PLZ, Ort, EMail, Password) VALUES ('$vorname', '$nachname', '$telefon', '$klasse', '$straße', '$plz', '$ort', '$email', '$passwort')";
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
                        <h1>Schüler Hinzufügen</h1>
                    </center>
                </div><br><br>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="Inputfield2">
                        <input type="digits" name="vorname" required autocomplete="off">
                        <label>Vorname</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="nachname" required autocomplete="off">
                        <label>Nachname</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="telefon" required autocomplete="off">
                        <label>Telefon</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="klasse" required autocomplete="off">
                        <label>Klasse</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="straße" required autocomplete="off">
                        <label>Straße & Hausnummer</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="plz" required autocomplete="off">
                        <label>PLZ</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="digits" name="ort" required autocomplete="off">
                        <label>Ort</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="email" name="email" required autocomplete="off">
                        <label>E-Mail</label>
                    </div>
                    <div class="Inputfield2">
                        <input type="passwort" name="passwort" required autocomplete="off">
                        <label>Passwort</label>
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
            <h1>(Fehlende Session)<?php '.$Vorname.' ?></h1>
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
                <a href="#">Schüler anlegen</a>
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
                <a href="profile.php">Daten ändern</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="profile_password.php">Passwort ändern</a>
            </div>
            <div class="sidebar_logout">
                <i class="rechter_text"></i>
                <a href="#">Log out</a>
            </div>
        </div>
    </div>
</div>
</body>

</html>
