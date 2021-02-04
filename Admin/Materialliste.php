<?php
// Wenn nicht Angemeldet weiterleitung zur Hauptseite
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:../index.php');
}
if ("1" != $_SESSION["Admin"]){
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
            <a>User</a>
            <a class="active_link">Materialliste</a>
            <a>Profil</a>
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
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
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
            <h1><?php echo $_SESSION["Vorname"], " ", $_SESSION["Name"]; ?></h1>
        </div>

        <div class="sidebar_menu">
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="dashboard.php">Dashboard</a>
            </div>
            <h2>User</h2>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="students.php">Schüler Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addstudent.php">Schüler anlegen</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="teachers.php">Lehrer Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addteacher.php">Lehrer Anlegen</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="admins.php">Admins Verwalten</a>
            </div>
            <div class="sidebar_link">
                <i class="rechter_text"></i>
                <a href="addadmin.php">Admin anlegen</a>
            </div>
            <h2>Materialliste</h2>
            <div class="sidebar_link active_menu_link">
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
        <script>history.pushState({}, "", "")</script>
    </div>
</div>
</body>
</html>