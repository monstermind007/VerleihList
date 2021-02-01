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
            <div class="main__title">
                <h1>Hallo <?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?> </h1>
            </div>
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                ?>
                <br>
                <table class="table table-bordered print">
                <thead>
                    <tr>
                        <th>Neuer Ausleihantrag</th>
                        <th>Antrag auf frühere Abgabe</th>
                    </tr>
                <tbody>
                    <tr>
                        <td>
                            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                                <select name="kategorie">
                                    <option value="" selected="selected">Kategorien</option>
                                    <?php
                                        for($i=0;$i<10;$i++){                                                           // Später Kategorien aus Datenbank hohlen,
                                            echo "<option value='$i'>$i</option>";                                      // erstmal eine placeholder Schleife.
                                        }
                                    ?>
                                </select>
                                <br>
                                <select name="gegenstand">
                                    <option value="" selected="selected">Gegenstände</option>
                                    <?php
                                    for($i=0;$i<10;$i++){                                                               // Später Gegenstände aus Datenbank hohlen,
                                        echo "<option value='$i'>$i</option>";                                          // erstmal eine placeholder Schleife.
                                    }                                                                                   // Linke ich zusammen sobald DB funktioniert
                                    ?>
                                </select>
                                <div class="Inputfield2">
                                    <input type="number" name="anzahl" required autocomplete="off">
                                    <label>Anzahl</label>
                                </div>
                                <input type="submit" value="Antrag Stellen" name="antragNeu" id="submit2">
                            </form>
                        </td>
                        <td>
                            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                                <div class="Inputfield2">
                                    <input type="date" name="test" required autocomplete="off">
                                    <label>Neues Abgabedatum</label>
                                </div>
                                <input type="submit" value="Antrag Stellen" name="antragAbgabe" id="submit2">
                            </form>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- Seitliche Navigation Links -->
    <div id="sidebar">
        <div class="user">
            <!-- Hier könnte man noch ein Profilbild einstllen-->
            <h1><?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?></h1>
        </div>

        <div class="sidebar_menu">
            <div class="sidebar_link">
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
                <a href="#">Alle Anträge</a>
            </div>
            <div class="sidebar_link active_menu_link">
                <i class="rechter_text"></i>
                <a href="#">Antrag stellen</a>
            </div>
            <h2>Profil</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="#">Nachrichten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="../Lehrer/daten.php">Profildaten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="../Lehrer/profile.php">Daten ändern</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="../Lehrer/profile_password.php">Passwort ändern</a>
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