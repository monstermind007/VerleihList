<?php session_start();
if (isset($_SESSION["login"])) {
    if ("1" == $_SESSION["Lehrer"]) {
        header("Location: Lehrer/dashboard.php");
    } elseif ("1" == $_SESSION["Schueler"]) {
        header("Loaction:Schueler/dashboard.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
    <?php
    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        @$dbconnection = mysqli_connect("134.255.218.71:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
        if (!$dbconnection) {
            error_log("Fehler beim Verbinden der Datenbank");
            die("Verbindungsfehler");
        }
        $sql_abfrage = "SELECT * FROM personen WHERE EMail = '" . $email . "'";
        $sql_res_email = mysqli_query($dbconnection, $sql_abfrage);
        $sql_daten = mysqli_fetch_array($sql_res_email);

        if ($sql_daten["Password"] == $password) {
            $_SESSION["EMail"] = $sql_daten["EMail"];
            $_SESSION["ID"] = $sql_daten["ID"];
            $_SESSION["Lehrer"] = $sql_daten["IstLehrer"];
            $_SESSION["Admin"] = $sql_daten["IstAdmin"];
            $_SESSION["Schueler"] = $sql_daten["IstSchüler"];
            $_SESSION["Name"] = $sql_daten["Name"];
            $_SESSION["Vorname"] = $sql_daten["Vorname"];
            $_SESSION["Telefon"] = $sql_daten["Telefon"];
            $_SESSION["Straße"] = $sql_daten["Straße"];
            $_SESSION["Ort"] = $sql_daten["Ort"];
            $_SESSION["PLZ"] = $sql_daten["PLZ"];
            $_SESSION["Klasse"] = $sql_daten["Klasse"];
            $_SESSION["login"] = true;
            if ("1" == $_SESSION["Lehrer"]) {
                header("Location:Lehrer/dashboard.php");
            } elseif ("1" == $_SESSION["Schueler"]) {
                header("Loaction:Schueler/dashboard.php");
            }
        } else {
            echo "Falsche Daten";

        }
    }
    ?>
    <div class="Login">
        <h1>Login</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <div class="Inputfield">
                <input type="email" name="email" required autocomplete="off">
                <label>E-Mail</label>
            </div>
            <div class="Inputfield">
                <input type="password" name="password" required autocomplete="off">
                <label>Passwort</label>
            </div>
            <input type="submit" value="Login" name="login" id="submit">
        </form>
    </div>
</center>
</body>
</html>

