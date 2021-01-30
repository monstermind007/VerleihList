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
                    $email = $_POST["email"];
                    $telefon = $_POST["telefon"];
                    $straße = $_POST["straße"];
                    $ort = $_POST["ort"];
                    $plz = $_POST["plz"];

                    $sql_ändern ="UPDATE personen SET EMail ='" . $email . "', Telefon='" . $telefon . "',Straße = '" . $straße . "', Ort= '" . $ort . "', PLZ = '" . $plz . "' WHERE id = '" . $_SESSION['id'] . "' ";
                    $db_ret_ändern = mysqli_query($dbconnection, $sql_ändern);
                    echo "Ihre Daten wurden geändert!";
                }
                
                ?>
                <div class="main__title">
                    <center>
                        <h1>Profil bearbeiten</h1>
                    </center>
                </div>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="Inputfield2">
                <input type="digits" id="email" placeholder="E-Mail">
                </div>
                <div class="Inputfield2">
                <input type="digits" id="telefon" placeholder="Telefonnr.">
                </div>
                <div class="Inputfield2">
                    <input type="digits" id="straße" placeholder="Straße & Hausnummer">
                </div>
                <div class="Inputfield2">
                    <input type="digits" id="ort" placeholder="Ort">
                </div>
                <div class="Inputfield2">
                    <input type="number" id="plz" placeholder="PLZ">
                </div>
                    <input type="submit" value="Ändern" name="ändern" id="submit2">
                </form>
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
