<!-- PAGE DE TOUS LES CHATS VISIBLE -->
<?php include('partials-front/menu.php') ?>

    <!-- Section pour afficher tous les chats -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center">Tous nos chats</h2>

            <div class="row" id="chat-list">
            <?php
                // Requête SQL pour obtenir tous les chats actifs
                $sql2 = "SELECT * FROM grL_Chat WHERE active=1 ORDER BY status ASC";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                // Si des chats sont trouvés, les afficher
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
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="row no-gutters">
                                <div class="col-md-12">
                                    <?php if ($nom_image != ""): ?>
                                        <img src="<?php echo SITEURL; ?>images/chats/<?php echo $nom_image; ?>" class="card-img-top" alt="<?php echo $nom; ?>">
                                    <?php else: ?>
                                        <div class="card-body text-danger">Pas d'image ajoutée pour ce chat.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nom; ?></h5>
                                <p class="card-text"><?php echo $description; ?></p>
                                <p class="card-text"><small class="text-muted">Né(e) le <?php echo $dateNaissance; ?></small></p>

                                <?php if ($status == 'adopté' || $status == 'reproduction'): ?>
                                    <h4 class="card-status"><?php echo $status_text; ?></h4>
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
            <?php
                    }
                } else {
                    // Si aucun chat n'est trouvé
                    echo "<div class='alert alert-danger'>Aucun chat trouvé.</div>";
                }
            ?>
            </div>
        </div>
    </section>

<?php include('partials-front/footer.php') ?>
