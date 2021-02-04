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
    header("Location:../index.php");
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
            <div class="Hauptteil">
                <?php
                @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");    //Die momentane verbindung
                //@$dbconnection = mysqli_connect("localhost", "root", "", "materialverleihDB"); //Zum testen weil der Server weg ist
                if (!$dbconnection) {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
                function make_data_child_options($rows, $array): string
                {
                    $data_child_options="";
                    if($rows > 0 && $rows != 1) {
                        $data_child_options = $array[0][0] . "|#";
                    } elseif ($rows == 1){
                        $data_child_options = $array[0][0];
                    }
                    if($rows > 2) {
                        for ($j = 1; $j < $rows - 1; $j++) {
                            $data_child_options .= $array[$j][0] . "|#";
                        }
                    }
                    if($rows > 1) {
                        $data_child_options .= $array[$rows-1][0];
                    }
                    return $data_child_options;
                }
                $von = $_SESSION['ID'];
                $sql_push = "";
                $feedback = "";
                if(isset($_POST['antragNeu'])){
                    $gegenstand = $_POST['gegenstand'];
                    $anzahl = $_POST['anzahl'];
                    $datum0 = $_POST['abgabedatum0'];
                    $dateTime0 = DateTime::createFromFormat('Y-m-d',$datum0);
                    $heute = new DateTime("midnight");
                    $sql_item = "SELECT AnzahlGesamt,AnzahlMomentan FROM gegenstände WHERE ID='".$gegenstand."'";
                    $sql_data_item = mysqli_query($dbconnection,$sql_item);
                    $sql_array_item = mysqli_fetch_array($sql_data_item);
                    if($sql_array_item[0] < $anzahl){
                        $feedback = "Es gibt nicht genug von dem Gegenstand, welchen Sie ausleihen möchten.<br>Bitte wenden Sie sich an einen Lehrer wenn Sie mehr bestellen möchten.";
                        $sql_push = "";
                    } elseif ($sql_array_item[1] < $anzahl){
                        $feedback = "Momentan sind nicht genug Gegenstände dieser Art zur Verfügung.<br>Bitte warten Sie bis wieder genug zur verfügung stehen.";
                        $sql_push = "";
                    } elseif ($dateTime0<$heute) {
                        $feedback = "Ihr Abgabedatum ist in der Vergangenheit.<br>Bitte wählen Sie ein valides Datum";
                        $sql_push = "";
                    } else {
                        $sql_push = "INSERT INTO anträge (Von,Gegenstand,Anzahl,AbgabeDatum) VALUES ($von,$gegenstand,$anzahl,'" . $datum0 . "')";
                    }
                }
                if (isset($_POST['antragAbgabe'])){
                    $verleihung = $_POST['verleihung'];
                    $datumNeu = $_POST['abgabedatum'];
                    $dateTimeNeu = DateTime::createFromFormat('Y-m-d',$datumNeu);
                    $heute = new DateTime("midnight");
                    if($dateTimeNeu<$heute){
                        $feedback = "Ihr neues Abgabedatum ist in der Vergangenheit.<br>Bitte wählen Sie ein valides Datum";
                        $sql_push = "";
                    } else {
                        $sql_push = "INSERT INTO anträge (Von,Verleihung,DatumNeu) VALUES ($von,$verleihung,'" . $datumNeu . "')";
                    }
                }
                if((isset($_POST['antragNeu']) || isset($_POST['antragAbgabe'])) && $sql_push !== ""){
                    if(mysqli_query($dbconnection,$sql_push)){
                        $feedback = "Antrag wurde erfolgreich eingereicht.<br>Bitte warten Sie, bis ein Lehrer ihn bearbeitet.";
                    } else {
                        //$feedback = mysqli_error($dbconnection);                                                      Debug
                        $feedback = "Es gab einen Fehler beim Einreichen ihres Antrags.<br>Bitte überprüfen Sie ihre Daten und versuchen es erneut.<br>Sollte es weitere Probleme geben kontaktieren Sie bitte einen Admin.";
                    }
                }
                ?>
                <br><br><br><br>
                <div class="main__title">
                    <h1><center>Antrag stellen</center></h1><br><br>
                </div>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <th>Neuer Ausleihantrag</th>
                        <th>Antrag auf änderung des Abgabedatums</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td>
                            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                                <select name="Kategorie" id="kategorie" data-child-id="gegenstand" class="dependent-selects__parent">
                                    <option value="" selected="selected">- Kategorien -</option>
                                    <?php
                                    $sql_kategorie = "SELECT ID, Name FROM kategorien";
                                    $sql_data_kategorie = mysqli_query($dbconnection,$sql_kategorie);
                                    $sql_rows_kategorie = mysqli_num_rows($sql_data_kategorie);
                                    $sql_array_kategorie = mysqli_fetch_all($sql_data_kategorie,MYSQLI_BOTH);

                                    $sql_item = "SELECT ID, Bezeichnung FROM gegenstände";
                                    $sql_data_item = mysqli_query($dbconnection,$sql_item);
                                    $sql_rows_item = mysqli_num_rows($sql_data_item);
                                    $sql_array_item = mysqli_fetch_all($sql_data_item,MYSQLI_BOTH);
                                    $data_child_options = make_data_child_options($sql_rows_item,$sql_array_item);
                                    echo "<option value='0' data-child-options='$data_child_options'>Alle Kategorien</option>";

                                    for($i=0;$i<$sql_rows_kategorie;$i++){
                                        $k = $i+1;                                                                  // Leider ist Mathematik in sql befehlen nicht möglich -.-
                                        $sql_item = "SELECT ID, Bezeichnung FROM gegenstände WHERE Kategorie='$k'";
                                        $sql_data_item = mysqli_query($dbconnection,$sql_item);
                                        $sql_rows_item = mysqli_num_rows($sql_data_item);
                                        $sql_array_item = mysqli_fetch_all($sql_data_item,MYSQLI_BOTH);

                                        $data_child_options = make_data_child_options($sql_rows_item,$sql_array_item);

                                        $data1 = $sql_array_kategorie[$i][0];
                                        $data2 = $sql_array_kategorie[$i][1];
                                        echo "<option value='$data1' data-child-options='$data_child_options'>$data2</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <select name="gegenstand" id="gegenstand" class="dependent-selects__child" required>
                                    <!--Placeholder Option, muss einfach nur existieren-->
                                    <option value=""></option>
                                    <?php
                                    $sql_item = "SELECT ID, Bezeichnung, AnzahlGesamt, AnzahlMomentan FROM gegenstände";
                                    $sql_data_item = mysqli_query($dbconnection,$sql_item);
                                    $sql_rows_item = mysqli_num_rows($sql_data_item);
                                    $sql_array_item = mysqli_fetch_all($sql_data_item,MYSQLI_BOTH);

                                    for($l=0;$l<$sql_rows_item;$l++){
                                        $data1 = $sql_array_item[$l][0];
                                        $data2 = $sql_array_item[$l][3]."/".$sql_array_item[$l][2]." : ".$sql_array_item[$l][1];
                                        echo "<option value='$data1'>$data2</option>>";
                                    }
                                    ?>
                                </select><br><br>
                                <div class="Inputfield2">
                                    <input type="number" name="anzahl" required autocomplete="off">
                                    <label>Anzahl</label>
                                </div>
                                <div class="Inputfield2">
                                    <p>Abgabedatum</p>
                                    <input type="date" name="abgabedatum0" required autocomplete="off">
                                </div>
                                <input type="submit" value="Antrag Stellen" name="antragNeu" id="submit2">
                            </form>
                        </td>
                        <td>
                            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                                <select name="verleihung" id="verleihung" required>
                                    <option value="">- Verleihung -</option>
                                <?php
                                $sql_verleihung = "SELECT ID, Gegenstand, Anzahl, Rückgabedatum FROM verleihungen WHERE VerliehenAn='".$_SESSION['ID']."'";
                                $sql_data_verleihung = mysqli_query($dbconnection,$sql_verleihung);
                                $sql_rows_verleihung = mysqli_num_rows($sql_data_verleihung);
                                $sql_array_verleihung = mysqli_fetch_all($sql_data_verleihung,MYSQLI_BOTH);

                                for($m=0;$m<$sql_rows_verleihung;$m++){
                                    $build_content_name = "";

                                    $sql_item = "SELECT Bezeichnung FROM gegenstände WHERE ID='".$sql_array_verleihung[$m][1]."'";
                                    $sql_data_item = mysqli_query($dbconnection,$sql_item);
                                    $sql_array_item = mysqli_fetch_all($sql_data_item,MYSQLI_BOTH);

                                    $build_content_name .= $sql_array_verleihung[$m][3];
                                    $build_content_name .= " : ";
                                    $build_content_name .= $sql_array_verleihung[$m][2];
                                    $build_content_name .= "x ";
                                    $build_content_name .= $sql_array_item[0][0];
                                    $data = $sql_array_verleihung[$m][0];
                                    echo "<option value='$data'>$build_content_name</option>";
                                }
                                ?>
                                </select>
                                <div class="Inputfield2">
                                    <p>Neues Abgabedatum</p>
                                    <input type="date" name="abgabedatum" required autocomplete="off">
                                </div>
                                <input type="submit" value="Antrag Stellen" name="antragAbgabe" id="submit2">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $feedback; ?></td>
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