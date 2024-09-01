<!-- EN TETE POUR CHAQUE PAGE, REPRENNANT LES ONGLETS DE NAVIGATION -->
<?php include('../config/constants.php');
	include('login-check.php');
?>

<html>
    <head>
        <title>Chatterie Maine coon des Collines</title>        
				<link rel="stylesheet" href="..\css\admin.css">
    </head>

	<body>
		 <div class="menu text-center">
			<div class="wrapper">
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="manage-admin.php">Admins</a></li>
					<li><a href="manage-categorie.php">Categories</a></li>
					<li><a href="manage-chat.php">Chats</a></li>
					<li><a href="manage-commande.php">Commandes</a></li>
					<li><a href="logout.php">Deconnexion</a></li>
				</ul>
			</div>
		 </div>