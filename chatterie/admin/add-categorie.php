<!-- PAGE POUR AJOUTER UNE CATEGORIE DANS LA BASE DE DONNEES-->
<?php include("partials/menu.php"); ?>
  <div class="main-content">
    <div class="wrapper">
      <h1>Ajouter une categorie</h1><br/><br/>

      <?php
        if(isset($_SESSION['upload'])){
          echo $_SESSION['upload'];		//Display
          unset($_SESSION['upload']);	//Remove
        }
      ?>
      <br/>

      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
          <tr>
            <td>Nom:</td>
            <td><input type="text" name="nom" placeholder="Nom de la catégorie"></td>
          </tr>

          <tr>
            <td>Image:</td>
            <td><input type="file" name="image"></td>
          </tr>

          <tr>
            <td>A l'accueil:</td>
            <td>
              <input type="radio" name="featured" value=1> Yes
              <input type="radio" name="featured" value=0> No
            </td>
          </tr>

          <tr>
            <td>Visible:</td>
            <td>
              <input type="radio" name="active" value=1> Yes
              <input type="radio" name="active" value=0> No
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Ajouter la catégorie" class="btn-secondary">
            </td>
          </tr>
        </table>
      </form>

      <?php
        if(isset($_POST['submit'])){
          $nom= mysqli_real_escape_string($conn,$_POST['nom']);
          if(isset($_POST['featured'])){
            $featured = $_POST['featured'];
          } else {
              $featured = 0;
          }
          if(isset($_POST['active'])){
              $active = $_POST['active'];
          } else {
              $active = 0;
          }
          
          if(isset($_FILES['image']['name'])){
            $nom_image = $_FILES['image']['name'];
            if($nom_image != ""){
                //Nettoyage du nom de fichier pour éviter les problèmes
                $nom_image = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nom_image);
                $nom_image = preg_replace('/[^A-Za-z0-9\.\-]/', '-', $nom_image);
                
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
                $exploded = explode('.', $nom_image);
                $base_name = $exploded[0]; // Nom de base
                $ext = end($exploded); // Extension du fichier
        
                //Compte les fichiers ayant un nom similaire existants dans le dossier
                $files = glob($upload_dir.$base_name."*.$ext");
                $count = count($files) + 1; // Increment basé sur le nombre de fichiers        
                //Crée le nouveau nom du fichier [nom-00X.ext] (base, 3 digits, rempli avec 0)
                $nom_image = $base_name . "-" . str_pad($count, 3, '0', STR_PAD_LEFT) . '.' . $ext;
        
                //Chemin de destination
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = $upload_dir.$nom_image;
        
                //Transférer l'image
                if(!is_uploaded_file($_FILES['image']['tmp_name'])) {
                  echo "Erreur: le fichier n'a pas été téléchargé correctement.";
                }
                if(!move_uploaded_file($source_path, $destination_path)){
                    $_SESSION['upload'] = "<div class='error'>Echec lors de l'ajout de l'image dû aux permissions du dossier ou de l'image.</div>";
                    header("location:".SITEURL.'admin/add-categorie.php');
                    die();
                }
            }
        } else {
            $nom_image = "";
        }
        
        //SQL Query pour mettre dans la DB
        $sql = "INSERT INTO grL_Categorie SET
                nom = '$nom',
                nom_image = '$nom_image',
                featured = '$featured',
                active = '$active'
        ";
        $res = mysqli_query($conn, $sql);
        
        //check query exe & data ajoutée
        if($res == true){
            $_SESSION['add'] = "<div class='success'>La catégorie a bien été ajouté.</div>";
        } else {
            $_SESSION['add'] = "<div class='error'>Erreur lors de l'ajout de cette catégorie.</div>";          
        }
        header("location:".SITEURL.'admin/manage-categorie.php');
        }
      ?>
    </div>
  </div>
<?php include("partials/footer.php"); ?>