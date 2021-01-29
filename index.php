<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center>
    <div class="Login">
        <h1>Login</h1>
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
</body>
</html>
