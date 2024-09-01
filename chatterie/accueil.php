<!-- PAGE PRINCIPALE ET D ACCUEIL DU SITE, AFFICHANT LES CATEGORIES ET LES CHATS MIS EN AVANT AVEC FEATURED -->
<?php include('partials-front/menu.php') ?>
    <!--Zone de recherche selon encodage-->
    <section class="chats-recherche text-center py-5">
        <div class="container">
            <form action="<?php echo SITEURL; ?>chats-recherche.php" method="POST" class="form-inline justify-content-center">
                <input type="search" name="search" class="form-control mr-sm-2" placeholder="Cherchez le nom d'un chat ou sa couleur" required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>
    </section>

    <!--Zone d'affichage si la commande s'est bien déroulée ou non-->
    <?php if (isset($_SESSION['order'])): ?>
        <div class="container">
            <div class="alert alert-info text-center">
                <?php echo $_SESSION['order']; unset($_SESSION['order']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!--Zone d'affichage des catégories featured et active-->
    <section class="categories py-5">
        <div class="container">
            <h2 class="text-center">Parcourez nos catégories</h2>
            <div class="row">
                <?php
                    $sql = "SELECT * FROM grL_categorie WHERE active=1 AND featured=1";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $nom = $row['nom'];
                            $nom_image = $row['nom_image'];
                ?>
                <!-- Mise en place de la catégorie et la redirection sur la page des chats trié (selon son id) -->
                <div class="col-md-4 mb-4">
                    <a href="<?php echo SITEURL; ?>categorie-chats.php?categorie_id=<?php echo $id; ?>" class="text-decoration-none">
                        <div class="card">
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
                        echo "<div class='alert alert-danger'>Aucune catégorie disponible.</div>";
                    }
                ?>
            </div>
        </div>
    </section>

    <!-- Zone d'affichage des chats en vedette -->
    <section class="chat-accueil py-5">
        <div class="container">
            <h2 class="text-center">Découvrez nos chats en vedette</h2>
            <div class="row">
                <?php
                    $sql2 = "SELECT * FROM grL_Chat WHERE active=1 AND featured=1 ORDER BY status ASC";
                    $res2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_num_rows($res2);

                    if ($count2 > 0) {
                        while ($row = mysqli_fetch_assoc($res2)) {
                            $id = $row['id'];
                            $nom = $row['nom'];
                            $description = $row['description'];
                            $dateNaissance = date("d/m/y", strtotime($row['dateNaissance']));
                            $prix = $row['prix'];
                            $nom_image = $row['nom_image'];
                            $status = $row['status'];

                            $status_text = ($status == 'adopté') ? 'Adopté(e)' : ucfirst($status);
                ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <?php if ($nom_image != ""): ?>
                                    <img src="<?php echo SITEURL; ?>images/chats/<?php echo $nom_image; ?>" class="card-img-top" alt="<?php echo $nom; ?>">
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
                                        <h3 class="card-status"><?php echo $status_text; ?></h3>
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
                </div>
                <?php
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Pas de chats mis en avant.</div>";
                    }
                ?>
            </div>
            <div class="text-center mt-4">
                <a href="./chats.php" class="btn btn-secondary">Voir tous nos chats</a>
            </div>
        </div>
    </section>



<?php include('partials-front/footer.php') ?>
