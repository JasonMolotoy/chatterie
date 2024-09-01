<!-- PAGE POUR MODIFIER LES DEMANDES DE RESERVATION (prix chat, status, info client) -->
<?php include('partials/menu.php') ?>
  <div class="main-content">
    <div class="wrapper">
      <h1>Modifier la réservation</h1><br/><br/>

      <?php 
        $id=$_GET['id'];
        if(isset($id)){
          $sql2="SELECT c.id, ch.nom AS chat_nom, ch.prix AS chat_prix, ch.description AS chat_desc, 
                c.chat_id, c.status, c.nom_client, c.tel_client, c.mail_client, c.message_client
              FROM grL_Commande c JOIN grL_Chat ch ON c.chat_id = ch.id 
              WHERE c.id=$id
          ";
          $res2=mysqli_query($conn,$sql2);
          if($res2==true){
            $count= mysqli_num_rows($res2);
            if($count==1){
              $row= mysqli_fetch_assoc($res2);
              $id = $row['id'];
              $chat_id = $row['chat_id'];
              $chat_nom  = $row['chat_nom'];
              $chat_desc  = $row['chat_desc'];
              $chat_prix  = $row['chat_prix'];

              $status = $row['status'];

              $nom_client = $row['nom_client'];
              $tel_client = $row['tel_client'];
              $mail_client = $row['mail_client'];
              $message_client = $row['message_client'];
            }else{
              $_SESSION['update'] = "<div class='error'>Erreur, cette réservation n'a pas été trouvée.</div>";
              header('location:'.SITEURL.'admin/manage-commande.php');
            }
          }
        } else {
          header('location:'.SITEURL.'admin/manage-commande.php'); //Redirige si pas ?id=XXX
        }
      ?>


      <form action="" method="POST">
        <table class="tbl-30">
            <tr>
              <td>Nom du chat:</td>
              <td><b><?php echo $chat_nom; ?></b></td>
            </tr>
            <tr>
              <td>Description:</td>
              <td><b><?php echo $chat_desc; ?></b></td>
            </tr>
            <tr>
              <td>Prix:</td>
              <td><input type="number" name="chat_prix" value="<?php echo $chat_prix; ?>">€</td>
            </tr>
            
            <tr>
              <td>Status</td>
              <td>
                <select name="status">
                  <option <?php if($status=="commandé"){echo "selected";} ?> value="commandé" style="color: green;">commandé</option>
                  <option <?php if($status=="réservé"){echo "selected";} ?> value="réservé" style="color: orange;">réservé</option>
                  <option <?php if($status=="adopté"){echo "selected";} ?> value="adopté" style="color: blue;">adopté</option>
                  <option <?php if($status=="annulé"){echo "selected";} ?> value="annulé" style="color: red;">annulé</option>
                </select>
              </td>
            </tr>

            <tr>
              <td>Client:</td>
              <td><input type="text" name="nom_client" value="<?php echo $nom_client; ?>"></td>
            </tr>
            <tr>
              <td>Téléphone:</td>
              <td><input type="text" name="tel_client" value="<?php echo $tel_client; ?>"></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td><input type="text" name="mail_client" value="<?php echo $mail_client; ?>"></td>
            </tr>
            <tr>
              <td>Commentaire:</td>
              <td><input type="text" name="message_client" value="<?php echo $message_client; ?>"></td>
            </tr>

            <tr>
              <td clospan="2">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Modifier la réservation" class="btn-secondary">
              </td>
            </tr>

          </table>
        </form>

        <?php //protection injection sql
          if(isset($_POST['submit'])){
            $id= $_POST['id'];
            $chat_prix = $_POST['chat_prix'];
            $status= mysqli_real_escape_string($conn,$_POST['status']);
            
            $nom_client= mysqli_real_escape_string($conn,$_POST['nom_client']);
            $tel_client= mysqli_real_escape_string($conn,$_POST['tel_client']);
            $mail_client= mysqli_real_escape_string($conn,$_POST['mail_client']);
            $message_client= mysqli_real_escape_string($conn,$_POST['message_client']);

            $sql3 = "UPDATE grL_Commande SET
                      status = '$status',
                      nom_client = '$nom_client',
                      tel_client = '$tel_client',
                      mail_client = '$mail_client',
                      message_client = '$message_client'
                    WHERE id = '$id'
            ";
            $res3 = mysqli_query($conn, $sql3);

            $sql4 = "UPDATE grL_Chat SET prix = '$chat_prix' WHERE id = (SELECT chat_id FROM grL_Commande WHERE id = '$id')";
            $res4 = mysqli_query($conn, $sql4);


            if($res3 && $res4){
              $_SESSION['update'] = "<div class='success'>La réservation a bien été modifiée.</div>";
            }else{
              $_SESSION['update'] = "<div class='error'>Erreur lors de la modification de la réservation.</div>";
            }
            header('location:'.SITEURL.'admin/manage-commande.php');
          }
        ?>
    </div>
  </div>
<?php include("partials/footer.php"); ?>