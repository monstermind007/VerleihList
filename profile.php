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
            <div class="main__title">
                <center>
                    <h1>Profil bearbeiten</h1>
                </center>
            </div>
            <div class="Eingabe_addStudents">
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
                    <input type="submit" value="Anlegen" name="registrierung" id="submit">
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
                <i class="fa fa-home"></i>
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
                <a href="#">Liste</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="#">Materialien Verwalten</a>
            </div>
            <h2>Profil</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="#">Nachrichten</a>
            </div>
            <div class="sidebar_link">
                <i class="fa fa-briefcase"></i>
                <a href="#">Daten ändern</a>
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
