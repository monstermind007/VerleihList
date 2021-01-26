<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
    <div class="Login">
        <form action="<?php echo$_SERVER["PHP_SELF"] ?>" method="post">
            <div class="Inputfield">
                <input type="email" name="email" required autocomplete="off">
                <label>E-Mail</label>
            </div>
            <div class="Inputfield">
                <input type="password" name="password" required autocomplete="off">
                <label>Passwort</label>
            </div>
            <input type="submit" value="Login" id="submit">
    </div>
</center>
<?php
$servername = "localhost";
$username = "";
$password = "1McR2.71";
$dbname = "materialverleihDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}




?>
</body>
</html>
