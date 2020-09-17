<?php
//INITIALISATION DE LA SESSION
session_start();


if(isset($_SESSION["firstname"])&&$_SESSION["firstname"]) /*si les variables existent*/ {
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>BIENVENUE <?php print $_SESSION['name'];print " "; print $_SESSION['firstname']; ?></h1>
        <form action="form.php" method="get">
            <p><input type="submit" value="Déconnexion" name="deconnecter"/></p>
        </form>           
    </body>
</html>

<?php } else {
        header("location:form.php");

    }


?>