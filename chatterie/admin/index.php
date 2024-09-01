<!-- PAGE PRINCIPALE DES ADMINS, AFFICHE LE NOMBRE DE CATEGORIES, CHATS, COMMANDES EFFECTUEES ET REVENUES -->
<?php include('partials/menu.php')?>
		 <div class="main-content">
		 	<div class="wrapper">
				<h1>Tableau de bord</h1>
				
				<br/>
				<?php
					if(isset($_SESSION['login'])){
						echo $_SESSION['login'];		//Display login OK
						unset($_SESSION['login']);	//Remove
					}
      	?>
				<br/>

				<div class="col-4 text-center">
					<?php
						$sql = "SELECT * FROM grL_Categorie";
						$res = mysqli_query($conn, $sql);
						$count = mysqli_num_rows($res);
					?>
					<h1><?php echo $count; ?></h1> <br/>
					Categories
				</div>

				<div class="col-4 text-center">
					<?php
						$sql2 = "SELECT * FROM grL_Chat";
						$res2 = mysqli_query($conn, $sql2);
						$count2 = mysqli_num_rows($res2);
					?>
					<h1><?php echo $count2; ?></h1> <br/>
					Chats
				</div>

				<div class="col-4 text-center">
					<?php
						$sql3 = "SELECT * FROM grL_Commande";
						$res3 = mysqli_query($conn, $sql3);
						$count3 = mysqli_num_rows($res3);
					?>
					<h1><?php echo $count3; ?></h1> <br/>
					Commandes
				</div>

				<div class="col-4 text-center">
					<?php
						$sql4 = "SELECT SUM(prix) AS Total FROM grL_Chat WHERE status='adopté'";
						$res4 = mysqli_query($conn, $sql4);
						$row4 = mysqli_fetch_assoc($res4);
						$total_revenue = $row4['Total'];
					?>
					<h1><?php echo $total_revenue.'€'; ?></h1> <br/>
					Revenues
				</div>

				<div class="clearfix"></div>
			</div>
		 </div>

<?php include('partials/footer.php')?>
		
