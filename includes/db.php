
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "my_library";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    error_log("Erreur de connexion à la base de données.");
    die("Impossible de se connecter à la base de données.");
}
?>
