<!DOCTYPE html>
<!--presentation/boekenlijst.php-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Boeken</title>
        <style>
            table {border-collapse: collapse; }
            td, th {border:1px solid black; padding:3px; }
            th {background-color: #ddd; }
        </style>
    </head>
    <body>
        <h1>Boekenlijst</h1>
        
        <table>
            <tr>
                <th>Titel</th>
                <th>Genre</th>
            </tr>
            <?php
            foreach($boekenLijst as $boek) {
                ?>
            <tr>
                <td>
                    <?php print($boek->getTitel());?>
                </td>
                <td>
                    <?php print($boek->getGenre()->getGenreNaam());?>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </body>
</html>
