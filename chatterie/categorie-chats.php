<!-- PAGE DES CHATS VISIBLE SELON LA CATEGORIE QUI A ETE CLIQUE AVANT -->
<?php include('partials-front/menu.php'); ?>

    <?php
    //Vérifier si l'identifiant de catégorie est passé dans l'URL
    if (isset($_GET['categorie_id'])) {
        $categorie_id = $_GET['categorie_id'];
        
        //Requête SQL pour obtenir le nom de la catégorie sélectionnée
        $sql = "SELECT nom FROM grL_categorie WHERE id=$categorie_id";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $nom_categorie = $row['nom'];
     ?>

    <!-- Section pour afficher les chats par catégorie -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center">Chats dans "<?php echo $nom_categorie; ?>"</h2>

            <div class="row">
            <?php
                //Requête SQL pour obtenir les chats appartenant à la catégorie sélectionnée et visible
                $sql2 = "SELECT * FROM grL_Chat WHERE categorie_id=$categorie_id AND active=1 ORDER BY status ASC";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                //Si des chats sont trouvés, les afficher
                if ($count2 > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                        $id = $row['id'];
                        $nom = $row['nom'];
                        $description = $row['description'];
                        $dateNaissance = date("d/m/y", strtotime($row['dateNaissance']));
                        $prix = $row['prix'];
                        $nom_image = $row['nom_image'];
                        $status = $row['status'];

                        // Ajuster le texte du statut
                        if ($status == 'adopté') {
                            $status_text = 'Adopté(e)';
                        } else {
                            $status_text = ucfirst($status);
                        }
            ?>
            <div class="card mb-4">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <?php if ($nom_image != ""): ?>
                            <img src="<?php echo SITEURL; ?>images/chats/<?php echo $nom_image; ?>" class="card-img" alt="<?php echo $nom; ?>">
                        <?php else: ?>
                            <div class="card-body text-danger">Pas d'image ajoutée pour ce chat.</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $nom; ?></h5>
                            <p class="card-text"><?php echo $description; ?></p>
                            <p class="card-text"><small class="text-muted">Né(e) le <?php echo $dateNaissance; ?></small></p>
                            
                            <?php if ($status == 'adopté' || $status == 'reproduction'): ?>
                                <h3><?php echo $status_text; ?></h3>
                            <?php else: ?>
                                <p class="card-text"><?php echo $prix; ?>€</p>
                                <a href="<?php echo SITEURL; ?>commande.php?chat_id=<?php echo $id; ?>" class="btn btn-primary">
                                    <img src="<?php echo SITEURL; ?>images/sticker.png" style="width: 30px; height: 30px; vertical-align: middle;">
                                    Réserver
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    //Si aucun chat n'est trouvé
                    echo "<div class='alert alert-danger'>Aucun chat trouvé dans cette catégorie.</div>";
                }
            ?>
            </div>

            <?php
                } else {
                    echo "<div class='alert alert-danger'>Catégorie non trouvée.</div>";
                }
            ?>
        </div>
    </section>

<?php include('partials-front/footer.php'); ?>