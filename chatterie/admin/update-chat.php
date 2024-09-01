<!-- PAGE POUR MODIFIER UN CHAT DANS LA BASE DE DONNEES-->
<?php include("partials/menu.php"); ?>
  <div class="main-content">
    <div class="wrapper">
      <h1>Modifier le chat</h1><br/><br/>

      <?php 
        $id=$_GET['id'];
        if(isset($id)){
          $sql2="SELECT * FROM grL_Chat WHERE id=$id"; //Récupère les détails avec query
          $res2=mysqli_query($conn,$sql2);             //Exe le query
          if($res2==true){                             //Vérifie l'exe query
            $count= mysqli_num_rows($res2);            //Vérifie si data dispo
            if($count==1){
              $row2= mysqli_fetch_assoc($res2);
              $nom = $row2['nom'];
              $dateNaissance = $row2['dateNaissance']; 
              $description= $row2['description'];
              $prix = $row2['prix'];
              $categorie_now= $row2['categorie_id'];
              $status = $row2['status'];
              $nom_image = $row2['nom_image'];
              $featured = $row2['featured'];
              $active = $row2['active'];
            }else{
              $_SESSION['update'] = "<div class='error'>Erreur, ce chat n'a pas été trouvé.</div>";
              header('location:'.SITEURL.'admin/manage-chat.php');
            }
          }
        } else {
          header('location:'.SITEURL.'admin/manage-chat.php'); //Redirige si pas ?id=XXX
        }
      ?>


      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
              <td>Nom:</td>
              <td><input type="text" name="nom" placeholder="Nom du chat" value="<?php echo $nom; ?>"></td>
            </tr>
            <tr>
              <td>Date de naissance:</td>
              <td><input type="date" name="dateNaissance" value="<?php echo $dateNaissance; ?>"></td>
            </tr>
            <tr>
              <td>Description:</td>
              <td><textarea name="description" cols="30" rows="3" placeholder="Information(s) sur la couleur"><?php echo $description; ?></textarea></td>
            </tr>
            <tr>
              <td>Current image:</td>
              <td><?php
                  if($nom_image!=""){
                    ?>
                    <img src="<?php echo SITEURL; ?>images/chats/<?php echo $nom_image; ?>" width="150px">
                    <?php
                  }else{
                    echo "<div class='error'>Pas d'image ajoutée.</div>";
                  }
              ?></td>
            </tr>
            <tr>
              <td>Nouvelle image:</td>
              <td><input type="file" name="image"></td>
            </tr>

            <tr>
              <td>Categorie:</td>
              <td><select name="categorie_id">
                  <?php
                    $sql = "SELECT * FROM grL_Categorie WHERE active=1";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if($count>0){
                      while($row=mysqli_fetch_assoc($res)){
                        $categorie_id = $row['id'];
                        $categorie_nom = $row['nom'];
                        ?>
                        <option <?php if($categorie_now==$categorie_id){echo "selected";} ?>value="<?php echo $categorie_id; ?>"><?php echo $categorie_nom; ?></option>

                        <?php
                      }

                    } else {
                      echo "<option value='0'>Pas de catégorie</option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>Prix:</td>
              <td>
                <input type="number" name="prix" value="<?php echo $prix; ?>">
              </td>
            </tr>
            <tr>
              <td>Status:</td>
              <td><select name="status">
                <option <?php if($status=="disponible"){echo "selected";} ?> value="disponible" style="color: green;">disponible</option>
                <option <?php if($status=="réservé"){echo "selected";} ?> value="réservé" style="color: orange;">réservé</option>
                <option <?php if($status=="adopté"){echo "selected";} ?> value="adopté" style="color: blue;">adopté</option>
                <option <?php if($status=="reproduction"){echo "selected";} ?> value="reproduction" style="color: red;">reproduction</option>
              </select></td>
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
                <input type="submit" name="submit" value="Modifier le chat" class="btn-secondary">
              </td>
            </tr>
          </table>
        </form>

        <?php
          if(isset($_POST['submit'])){
            $id= $_POST['id'];
            $nom= mysqli_real_escape_string($conn,$_POST['nom']);
            $dateNaissance = mysqli_real_escape_string($conn,$_POST['dateNaissance']);
            $description= mysqli_real_escape_string($conn,$_POST['description']);
            $prix= $_POST['prix'];
            $categorie_id= $_POST['categorie_id'];
            $status= mysqli_real_escape_string($conn,$_POST['status']);
            $nom_image= mysqli_real_escape_string($conn,$_POST['nom_image']);
            $featured= $_POST['featured'];
            $active= $_POST['active'];

            //Vérifie si une nouvelle image a été sélectionnée
            if(isset($_FILES['image']['name'])){
              $nouvelle_image = $_FILES['image']['name'];
              if($nouvelle_image != ""){
                  //Nettoyage du nom de fichier pour éviter les problèmes
                  $nouvelle_image = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nouvelle_image);
                  $nouvelle_image = preg_replace('/[^A-Za-z0-9\.\-]/', '-', $nouvelle_image);

                  //Vérifier et créer le répertoire si nécessaire
                  $upload_dir = "../images/chats/";
                  if (!is_dir($upload_dir)) {
                      if (!mkdir($upload_dir, 0777, true)) {
                          $_SESSION['upload'] = "<div class='error'>Impossible de créer le répertoire de transfert.</div>";
                          header("location:".SITEURL.'admin/add-chat.php');
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
                      header("location:".SITEURL.'admin/manage-chat.php');
                      die();
                  }

                  //Supprime l'ancienne image si elle existe
                  $remove_path = $upload_dir.$nom_image;
                  if($nom_image != ""&& file_exists($remove_path)){
                    if (!unlink($remove_path)) {
                        $_SESSION['upload'] = "<div class='error'>Echec lors de la suppression de l'ancienne image.</div>";
                        header('location:'.SITEURL.'admin/manage-chat.php');
                        die();
                    }
                  }
              } else {
                  $nouvelle_image = $nom_image;
              }
            } else {
              $nouvelle_image = $nom_image;
            }

            $sql3 = "UPDATE grL_Chat SET
                nom = '$nom',
                dateNaissance = '$dateNaissance',
                description = '$description',
                prix = $prix,
                categorie_id = $categorie_id,
                status = '$status',
                nom_image = '$nouvelle_image',
                featured = '$featured',
                active = '$active'
                WHERE id = '$id'
              ";

            $res3 = mysqli_query($conn, $sql3);
            if($res3==true){
              $_SESSION['update'] = "<div class='success'>Le chat a bien été modifié.</div>";
            }else{
              $_SESSION['update'] = "<div class='error'>Erreur lors de la modification du chat.</div>";
            }
            header('location:'.SITEURL.'admin/manage-chat.php');
          }
        ?>
    </div>
  </div>
<?php include("partials/footer.php"); ?>