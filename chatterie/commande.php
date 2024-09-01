<?php
ob_start(); // Commence le tampon de sortie
include('partials-front/menu.php');
?>

<?php
// Récupération de l'ID du chat depuis l'URL
$chat_id = $_GET['chat_id'];
if(isset($chat_id)) {
    // Requête SQL pour récupérer les informations du chat
    $sql = "SELECT * FROM grL_Chat WHERE id=$chat_id AND active=1 AND (status='disponible' OR status='réservé')";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $nom = $row['nom'];
        $prix = $row['prix'];
        $description = $row['description'];
        $dateNaissance = date("d/m/Y", strtotime($row['dateNaissance']));
        $nom_image = $row['nom_image'];
    } else {
        // Redirection si le chat n'est pas trouvé ou n'est pas actif
        header('location:'.SITEURL.'accueil.php');
        exit(); // Arrête l'exécution du script
    }
} else {
    // Redirection si l'accès est direct sans ID de chat
    header('location:'.SITEURL.'accueil.php');
    exit(); // Arrête l'exécution du script
}
?>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Placez votre réservation</h2>
        <form action="" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="mb-4">
                        <legend class="mb-3">Détails du chat</legend>
                        <div class="mb-3">
                            <?php if($nom_image != ""): ?>
                                <img src="<?php echo SITEURL; ?>images/chats/<?php echo $nom_image; ?>" class="img-fluid rounded mb-3" alt="<?php echo $nom; ?>">
                            <?php else: ?>
                                <div class="alert alert-danger">Pas d'image disponible pour ce chat.</div>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo $nom; ?></h3>
                        <input type="hidden" name="chat_id" value="<?php echo $chat_id; ?>">
                        <p><strong>Né(e) le :</strong> <?php echo $dateNaissance; ?></p>
                        <p><?php echo $description; ?></p>
                        <p class="text-primary h5"><?php echo $prix; ?>€</p>
                        <input type="hidden" name="prix" value="<?php echo $prix; ?>">
                    </fieldset>
                </div>

                <div class="col-md-6">
                    <fieldset class="mb-4">
                        <legend class="mb-3">Détails de l'acheteur</legend>
                        <div class="form-group mb-3">
                            <label for="full-name">Nom et Prénom</label>
                            <input type="text" id="full-name" name="full-name" placeholder="Ex: Foucart Sabrina" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact">Numéro de téléphone</label>
                            <input type="tel" id="contact" name="contact" placeholder="Ex: 0487/43.47.58" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Ex: exemple@outlook.com" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message">Informations supplémentaires</label>
                            <textarea id="message" name="message" rows="5" placeholder="Ex: Je vous contacte demain vers 17h30..." class="form-control"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Réserver</button>
                    </fieldset>
                </div>
            </div>
        </form>

        <?php
        // Traitement du formulaire après la soumission
        if(isset($_POST['submit'])){
            // Récupération des données du formulaire
            $chat_id = $_POST['chat_id'];
            $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
            $contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $message = mysqli_real_escape_string($conn, $_POST['message']);
            $prix = $_POST['prix'];
            $dateCommande = date("Y-m-d H:i:s");

            // Insertion des données dans la base
            $sql2 = "INSERT INTO grL_Commande SET
                chat_id = '$chat_id',
                description = '$description',
                dateCommande = '$dateCommande',
                status = 'commandé',
                nom_client = '$full_name',
                tel_client = '$contact',
                mail_client = '$email',
                message_client = '$message',
                notification = 0";

            $res2 = mysqli_query($conn, $sql2);

            // Vérification de la réussite de l'insertion
            if($res2 == true){
                $_SESSION['order'] = "<div class='alert alert-success text-center'>La demande de réservation a bien été envoyée.</div>";
            } else {
                $_SESSION['order'] = "<div class='alert alert-danger text-center'>Erreur lors de la réservation.</div>";
            }
            header('location:'.SITEURL.'accueil.php');
            exit(); // Arrête l'exécution du script
        }
        ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
<?php ob_end_flush(); // Termine et envoie le contenu du tampon ?>
