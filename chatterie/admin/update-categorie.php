<!-- PAGE POUR MODIFIER LES INFOS D UNE CATEGORIE -->
<?php include("partials/menu.php"); ?>
  <div class="main-content">
    <div class="wrapper">
      <h1>Modifier la catégorie</h1><br/><br/>

      <?php 
        $id=$_GET['id'];
        if(isset($id)){
          $sql="SELECT * FROM grL_Categorie WHERE id=$id";//Récupère les détails avec query
          $res=mysqli_query($conn,$sql);                  //Exe le query
          if($res==true){                                 //Vérifie l'exe query
            $count= mysqli_num_rows($res);                //Vérifie si data dispo
            if($count==1){
              $row= mysqli_fetch_assoc($res);
              $nom = $row['nom'];
							$nom_image = $row['nom_image'];
              $featured = $row['featured'];
              $active = $row['active'];
            }else{
              $_SESSION['update'] = "<div class='error'>La catégorie n'a pas été trouvée.</div>";
              header('location:'.SITEURL.'admin/manage-categorie.php');
            }
          }
        } else {
          header('location:'.SITEURL.'admin/manage-categorie.php'); //Redirige si pas ?id=XXX
        }
?>

      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
              <td>Nom:</td>
              <td><input type="text" name="nom" placeholder="New category title" value="<?php echo $nom; ?>"></td>
            </tr>

            <tr>
              <td>Image actuelle:</td>
              <td><?php
                  if($nom_image!=""){
                    ?>
                    <img src="<?php echo SITEURL; ?>images/categories/<?php echo $nom_image; ?>" width="150px">
                    <?php
                  }else{
                    echo "<div class='error'>Pas d'image ajoutée.</div>";
                  }
              ?></td>
            </tr>
            <tr>
              <td>Nouvelle image:</td>
              <td>
                <input type="file" name="image">
              </td>
            </tr>

            <tr>
              <td>A l'accueil:</td>
              <td>
                <input <?php if($featured==1){echo "checked";} ?> type="radio" name="featured" value=1> Oui
                <input <?php if($featured==0){echo "checked";} ?> type="radio" name="featured" value=0> Non
              </td>
            </tr>

            <tr>
              <td>Visible:</td>
              <td>
                <input <?php if($active==1){echo "checked";} ?> type="radio" name="active" value=1> Oui
                <input <?php if($active==0){echo "checked";} ?> type="radio" name="active" value=0> Non
              </td>
            </tr>

            <tr>
              <td>
                <input type="hidden" name="nom_image" value="<?php echo $nom_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Modifier la catégorie" class="btn-secondary">
              </td>
            </tr>
          </table>
        </form>

        <?php
          if(isset($_POST['submit'])){
            $id= $_POST['id'];
            $nom= mysqli_real_escape_string($conn,$_POST['nom']);
            $nom_image= mysqli_real_escape_string($conn,$_POST['nom_image']);
            $featured= $_POST['featured'];
            $active= $_POST['active'];

            //Vérifier si une nouvelle image a été sélectionnée
            if(isset($_FILES['image']['name'])){
              $nouvelle_image = $_FILES['image']['name'];
              if($nouvelle_image != ""){
                  //Nettoyage du nom de fichier pour éviter les problèmes
                  $nouvelle_image = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nouvelle_image);
                  $nouvelle_image = preg_replace('/[^A-Za-z0-9\.\-]/', '-', $nouvelle_image);

                  //Vérifier et créer le répertoire si nécessaire
                  $upload_dir = "../images/categories/";
                  if (!is_dir($upload_dir)) {
                      if (!mkdir($upload_dir, 0777, true)) {
                          $_SESSION['upload'] = "<div class='error'>Impossible de créer le répertoire de transfert.</div>";
                          header("location:".SITEURL.'admin/add-categorie.php');
                          die();
                      }
                  }

                  //Extraire l'extension du fichier
                  $exploded = explode('.', $nouvelle_image);
                  $base_name = $exploded[0]; // Nom de base
                  $ext = end($exploded); // Extension du fichier

                  //Compte les fichiers ayant un nom similaire existants dans le dossier
                  $files = glob($upload_dir.$base_name."*.$ext");
                  $count = count($files) + 1; // Increment basé sur le nombre de fichiers        
                  //Crée le nouveau nom du fichier [nom-00X.ext] (base, 3 digits, rempli avec 0)
                  $nouvelle_image = $base_name . "-" . str_pad($count, 3, '0', STR_PAD_LEFT) . '.' . $ext;

                  //Envoie de l'image
                  $source_path = $_FILES['image']['tmp_name'];
                  $destination_path = $upload_dir.$nouvelle_image;

                  //Transférer l'image
                  if(!is_uploaded_file($_FILES['image']['tmp_name'])) {
                    echo "Erreur: le fichier n'a pas été téléchargé correctement.";
                  }
                  if(!move_uploaded_file($source_path, $destination_path)){
                      $_SESSION['upload'] = "<div class='error'>Echec lors de l'ajout de l'image dû aux permissions du dossier ou de l'image.</div>";
                      header("location:".SITEURL.'admin/manage-categorie.php');
                      die();
                  }

                  //Supprime l'ancienne image si elle existe
                  $remove_path = $upload_dir.$nom_image;
                  if($nom_image != ""&& file_exists($remove_path)){
                    if (!unlink($remove_path)) {
                        $_SESSION['upload'] = "<div class='error'>Echec lors de la suppression de l'ancienne image.</div>";
                        header('location:'.SITEURL.'admin/manage-categorie.php');
                        die();
                    }
                  }
              } else {
                  $nouvelle_image = $nom_image;
              }
            } else {
              $nouvelle_image = $nom_image;
            }

            $sql2 = "UPDATE grL_Categorie SET
                nom = '$nom',
                featured = '$featured',
                active = '$active',
                nom_image = '$nouvelle_image'
                WHERE id = '$id'
              ";

            $res2 = mysqli_query($conn, $sql2);
            if($res2==true){
              $_SESSION['update'] = "<div class='success'>La catégorie a bien été modifiée.</div>";
            }else{
              $_SESSION['update'] = "<div class='error'>Erreur lors de la modification de la catégorie.</div>";
            }
            header('location:'.SITEURL.'admin/manage-categorie.php');
          }
?>
    </div>
  </div>
<?php include("partials/footer.php"); ?>