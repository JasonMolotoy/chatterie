<!-- CONSTANTES ET OUVERTURE DE LA BASE DE DONNEES LANCE DIRECTEMENT -->
<?php
    session_start();

    //Variables constantes utiles
    define('SITEURL','http://localhost/chatterie/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD','');
    define('DB_NAME','grL_Chatterie');

    //Connection à la database, puis vérifie
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
    if (!$conn) {
        die("Erreur de connection: " . mysqli_connect_error());
    }

    //Sélectionne la database, puis vérifie
    $db_select = mysqli_select_db($conn, DB_NAME);
    if (!$db_select) {
        die("Impossible de sélectionner cette base de données: " . mysqli_error($conn));
    }
?>