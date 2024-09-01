<!-- PAGE POUR QUE L ADMIN PUISSE VOIR ET GERER LES DEMANDES DE RESERVATION (modifier, supprimer) -->
<?php include('partials/menu.php') ?>
  <div class="main-content">
    <div class="wrapper">
      <h1>Gérer les demandes</h1><br/><br/>

      <?php //Zone de message de notification selon ce qu'il se passe dans update-commande.php
        if(isset($_SESSION['update'])){
          echo $_SESSION['update'];		//Display
          unset($_SESSION['update']);	//Remove
        }
      ?>
      <br/>

      <table class="tbl-full">
        <tr>
          <th>N°</th>
          <th>Date</th>
          <th>Status</th>
          <th>Chat</th>
          <th>Client</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Commentaire</th>
          <th>Actions</th>
        </tr>

        <?php //Requete avec jointure pour chercher le nom du chat selon son id
          $sql = "SELECT c.id, c.dateCommande, c.status, ch.nom AS chat_nom, c.nom_client, c.tel_client, c.mail_client, c.message_client
            FROM grL_Commande c JOIN grL_Chat ch ON c.chat_id = ch.id
            ORDER BY c.dateCommande ASC
          ";
          $res = mysqli_query($conn, $sql);
          $count = mysqli_num_rows($res);
          $sn=1;

          if($count>0){
            while($row=mysqli_fetch_assoc($res)){
              $id = $row['id'];
              $dateCommande = $row['dateCommande'];
              $status = $row['status'];
              $chat_nom  = $row['chat_nom'];
              $nom_client = $row['nom_client'];
              $tel_client = $row['tel_client'];
              $mail_client = $row['mail_client'];
              $message_client = $row['message_client'];
              ?>

              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $dateCommande; ?></td>
                <td><?php
                  if($status=="commandé"){
                    echo "<label style='color: green;'>$status</label>";
                  } elseif($status=="réservé"){
                    echo "<label style='color: orange;'>$status</label>";
                  } elseif($status=="adopté"){
                    echo "<label style='color: blue;'>$status</label>";
                  } elseif($status=="annulé"){
                    echo "<label style='color: red;'>$status</label>";
                  }  
                ?></td>				
                <td><?php echo $chat_nom ; ?></td>
                <td><?php echo $nom_client; ?></td>
                <td><?php echo $tel_client; ?></td>
                <td><?php echo $mail_client; ?></td>
                <td><?php echo $message_client; ?></td>			

                <td>
                  <a href="<?php echo SITEURL; ?>admin/update-commande.php?id=<?php echo $id; ?>" class="btn-secondary">Modifier</a>
                </td>
              </tr>

              <?php
            }
          } else {
            echo "<tr><td colspan='9'><div class='error'>Pas de commande disponible.</div></td></tr>";
          }
        ?>
      </table>
    </div>
  </div>
<?php include('partials/footer.php')?>