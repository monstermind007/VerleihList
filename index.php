<?php session_start();
if (isset($_SESSION["login"])) {
    if ("1" == $_SESSION["Rechte"]) {
        header("Location:dashboard.php");
    } else {
        header("Loaction:dashboard2.php");
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
    <div class="Login">
        <h1>Login</h1>
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
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
                $_SESSION["Rechte"] = $sql_daten["IstLehrer"];
                $_SESSION["Name"] = $sql_daten["Name"];

                $_SESSION["login"] = true;
                if ("1" == $_SESSION["Rechte"]) {
                    header("Location: dashboard.php");
                } else {
                    header("Loaction:dashboard2.php");
                }
            } else {
                echo "Falsche Daten";

            }
        }
        ?>
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
    </div>
</body>
</html>
