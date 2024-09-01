<!-- EN TETE POUR CHAQUE PAGE, REPRENNANT LE TITRE DE LA PAGE, LE LOGO ET LES ONGLETS DE NAVIGATION -->
<?php include('config/constants.php') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatterie Maine coon des Collines</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <!-- Logo (photo) cliquable pour admin, barre de navigation -->
        <a class="navbar-brand" href="<?php echo SITEURL; ?>admin">
            <img src="<?php echo SITEURL; ?>images/logo.jpg" alt="Logo de la chatterie" width="60px">
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITEURL; ?>accueil">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITEURL; ?>categories">Catégories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITEURL; ?>chats">Chats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="informations">Informations</a>
            </li>
        </ul>
    </nav>