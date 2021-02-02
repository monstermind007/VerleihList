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
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        p {
            color: black;
        }
    </style>
</head>
<body id="body">
<div class="container">
    <nav class="navigation_oben">
        <div class="nav_icon" onclick="toggleSidebar()">
        </div>
        <div class="navigation_oben__links">
            <a>Dashboard</a>
            <a>User</a>
            <a>Materialliste</a>
            <a class="active_link">Profil</a>
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
            <div class="Main">
                <div class="main__title">
                    <center>
                        <h1>Schüler Verwalten</h1>
                    </center>
                </div>
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }

                $sql_data = "SELECT * FROM `personen` WHERE `Vorname` = 'Leon'";
                $sql_data_res = mysqli_query($dbconnection, $sql_data);
                $sql_array = mysqli_fetch_array($sql_data_res);
                ?>
                <button class="accordion">
                    <?php
                    echo "<table>";
                    while($row = mysqli_fetch_array($sql_data_res)) {
                        echo "<tr>";
                        echo "<td>" . $row['Vorname'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Klasse'] . "</td>";
                        echo "<td>" . $row['Straße'] . "</td>";
                        echo "<td>" . $row['PLZ'] . "</td>";
                        echo "<td>" . $row['Ort'] . "</td>";
                        echo "<td>" . $row['EMail'] . "</td>";
                        echo "</tr>";
                        }
                        echo "</table>";
                        ?>
                </button>
                <div class="panel">
                    <p>
                        <?php
                        @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                        if (!$dbconnection) {
                            error_log("Fehler beim Verbinden der Datenbank");
                            die("Verbindungsfehler");
                        }

                        $sql_data = "SELECT * FROM `anträge` WHERE `Von` = 6";
                        $sql_data_res = mysqli_query($dbconnection, $sql_data);
                        $sql_array = mysqli_fetch_array($sql_data_res);

                        echo "<table>";
                        while($row = mysqli_fetch_array($sql_data_res)) {
                            echo "<tr>";
                            echo "<td>" . $row['Gegenstand'] . "</td>";
                            echo "<td>" . $row['Anzahl'] . "</td>";
                            echo "<td>" . $row['DatumNeu'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";

                        ?>
                    </p>
                </div>
                <script>
                    var acc = document.getElementsByClassName("accordion");
                    var i;

                    for (i = 0; i < acc.length; i++) {
                        acc[i].addEventListener("click", function() {
                            this.classList.toggle("active");
                            var panel = this.nextElementSibling;
                            if (panel.style.maxHeight) {
                                panel.style.maxHeight = null;
                            } else {
                                panel.style.maxHeight = panel.scrollHeight + "px";
                            }
                        });
                    }
                </script>
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