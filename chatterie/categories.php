<!-- PAGE DES CATEGORIES DE CHATS VISIBLE MAIS PAS FORCEMENT MISE EN AVANT, PERMETTANT D ALLER SUR LA PAGE TRIEE SELON LE CLIQUE -->
<?php include('partials-front/menu.php'); ?>

    <!-- Section pour afficher toutes les catégories -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center">Toutes les catégories</h2>

            <div class="row">
            <?php
                // Requête SQL pour obtenir toutes les catégories actives
                $sql = "SELECT * FROM grL_categorie WHERE active=1";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    // Afficher chaque catégorie
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $nom = $row['nom'];
                        $nom_image = $row['nom_image'];
            ?>
                <div class="col-md-4">
                    <a href="<?php echo SITEURL; ?>categorie-chats.php?categorie_id=<?php echo $id; ?>" class="text-decoration-none">
                        <div class="card mb-4">
                            <?php if ($nom_image != ""): ?>
                                <img src="<?php echo SITEURL; ?>images/categories/<?php echo $nom_image; ?>" class="card-img-top" alt="<?php echo $nom; ?>">
                            <?php else: ?>
                                <div class="card-body text-danger">Pas d'image ajoutée pour cette catégorie.</div>
                            <?php endif; ?>
                            <div class="card-body bg-dark text-white">
                                <h5 class="card-title"><?php echo $nom; ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                    }
                } else {
                    // Si aucune catégorie n'est trouvée
                    echo "<div class='alert alert-danger'>Aucune catégorie trouvée.</div>";
                }
            ?>
            </div>
        </div>
    </section>

<?php include('partials-front/footer.php'); ?>
