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
    header("Location:../index.php");
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
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                ?>
                <br><br><br><br>
                <div class="main__title">
                    <h1><center>Nachrichten</center></h1><br><br>
                </div>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Von</th>
                        <th>Gegenstand</th>
                        <th>Anzahl</th>
                        <th>Abgabe-Datum</th>
                        <th>Angenommen</th>
                        <th>Select</th>
                        <th>Bestätigen</th>
                        <th>Bearbeiten</th>
                    </tr>

                    <tbody>
                    <?php
                    $ID = 1;
                    $user_qry = "SELECT * FROM `anträge` WHERE GelesenLehrer= 0";
                    $user_res = mysqli_query($dbconnection, $user_qry);
                    while ($user_data = mysqli_fetch_assoc($user_res)) {
                    ?>
                    <tr>
                        <td><?php echo $user_data['ID']; ?></td>
                        <td><?php echo $user_data['Von']; ?></td>
                        <td><?php echo $user_data['Gegenstand']; ?></td>
                        <td><?php echo $user_data['Anzahl']; ?></td>
                        <td><?php echo $user_data['AbgabeDatum']; ?></td>
                        <td><?php echo $user_data['Angenommen']; ?></td>

                        <td><center><input type="checkbox" value="<?php $user_data['ID'];?>" required></center></td>
                        <td><center><input type="submit" value="Bestätigen"</center></td>
                        <td><center><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
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
            <div class="sidebar_link active_menu_link">
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
<script defer src="../dependent-selects.js"></script>
<script>history.pushState({}, "", "")</script>
</body>
</html>
