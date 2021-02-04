<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Schueler"]){
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a>Materialliste</a>
            <a class="active_link">Profil</a>
        </div>
        <!--Rechte Navigationsleiste mit Notification Symbol-->
        <div class="navigation_oben_rechts">
            <a class="active_link" href="support.php"><img src="support.png"></a>
            <a href="messages.php">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <div class="count-container hidden" data-region="count-container">0</div>
            </a>
            <!--Profilbild Datenbank wenn möglich-->
            </a>
        </div>
    </nav>

    <!--Hauptteil -->
    <main>
        <div class="main_container">
            <div class="Main">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                if (isset($_POST["ändern"])){
                    $id = $_SESSION["ID"];
                    $betreff = $_POST["betreff"];
                    $inhalt = $_POST["inhalt"];

                    $support = "INSERT INTO support (Von, Betreff, Inhalt) VALUES ('$id', '$betreff', '$inhalt')";
                if (mysqli_query($dbconnection, $support)){
                    print("<center>Support Ticket wurde übermittelt.</center>");
                }
                else {
                    print("<center>Fehler</center>");
                }
                }
                ?><br><br><br><br>
                <div class="main__title">
                    <center>
                        <h1>Support Ticket</h1>
                    </center><br>
                </div>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                    <div class="Inputfield2">
                        <input type="digits" name="betreff" required autocomplete="off">
                        <label>Betreff</label>
                    </div>
                    <textarea maxlength="5000" name="inhalt" placeholder="Problem beschreiben:"></textarea>
                    <br><br>
                    <input type="submit" value="Ändern" name="ändern" id="submit2">
                </form>
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