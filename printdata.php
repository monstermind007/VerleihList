<?php
//Datenbank Anbindung
                $dbconnection = mysqli_connect("134.255.220.55:3306", "materiallisteDB", "1McR2.71", "materialverleihDB");
                if(!$dbconnection)
                {
                    error_log("Fehler beim Verbinden der Datenbank");
                    die("Verbindungsfehler");
                }
?>
    <!DOCTYPE html>
    <html>
    <head>
        //Design für das Drucklayout
        <title>PHP Print</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="print.css" media="print">
    </head>
    <body>

    <div class="container">
        <div class="row">
            <div class="col-md-12"> //Tabelle Erzeugen
                <h2>gegenstände</h2>
                <table class="table table-bordered print">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bezeichnung</th>
                        <th>AnzahlGesamt></th>
                        <th>LetzteInventur</th>
                        <th>Lagerort</th>
                        <th>Kategorie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php // Datenbank Anbindung zur gewünschten Tabelle
                    $ID=1;
                    $user_qry="SELECT * from gegenstände";
                    $user_res=mysqli_query($dbconnection,$user_qry);
                    while($user_data=mysqli_fetch_assoc($user_res))
                    {
                        ?>
                        <tr>//Daten aus der Datenbank ausgeben
                            <td><?php echo $ID; ?></td>
                            <td><?php echo $user_data['ID']; ?></td>
                            <td><?php echo $user_data['Bezeichnung']; ?></td>
                            <td><?php echo $user_data['AnzahlGesamt']; ?></td>
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

                <div class="text-center">
                    // Erstellt ein Button der ein Fenster zum drucken öffnet
                    <button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
