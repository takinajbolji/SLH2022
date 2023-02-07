<?php
/*
 * @name Scientists little helper - lista korisnika
 * @author Branko Vujatovic
 * @date   28.06.2020.
 * @version 01
 *
 */

if(!isset($_SESSION['ulogovan'])) {
	session_start();
}

$ulogovan=unserialize($_SESSION['ulogovan']);

$inactive = 300;

if(isset($_SESSION['loginTime'])) {
	$session_life = time() - $_SESSION['loginTime'];
	
	if($session_life > $inactive) {
		session_destroy();
		header("Location: ../login/index.php");
	}
}

$_SESSION['loginTime']= time();

if($ulogovan) {
	$statusulogovanog = $ulogovan['idstatusosobe'];	
	
	$dao = new DAO();
	$listakorisnika=$dao->selectOsoba();
	
	$msg=isset($msg)?$msg:"";
	$errors = isset($errors)?$errors:array();		
?>
<!DOCTYPE html>
<html lang="en, sr">
<head>
		<title>Scientists little helper - Pregled korisnika</title>
		<?php include '../tema/head.php';?>

<body>

<?php include '../tema/sadrzaj_posebni.php';?>

<!-- glavni deo -->
<!-- centralni deo --> 
 <br><br><br><br>
 		<div class="naslov-text">
  			<h3>- PREGLED LICA -</h3>
		</div>
<div class="main">
	<div class="wrapper container bg-faded text-left">
		
 			<table class="table">
				<thead>
					<tr style="background:#e5e5e5; color:black; font-style:italic; text-align:center;">
						<th>Username</th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>E-mail</th>
						<th>mobilni</th>
						<th>Status korisnika</th>
						<th>Akcija</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					foreach ($listakorisnika as $pom) {
						
				?>
				<form class="form-signin" action="../upravljanje/routes.php" method="post">
					<tr style="text-align:left;">
					
						<th ><?php echo $pom['username']?></th>
						<th ><?php echo $pom['ime']?></th>
						<th ><?php echo $pom['prezime']?></th>
						<th ><?php echo $pom['email']?></th>
						<th ><?php echo $pom['mobilni']?></th>
						<th >
							<?php $status=$pom['idstatusosobe'];
								switch ($status){
		   			   				case 1:
		   			   					echo "Administrator";
		   			   					break;
		   			   				case 2:					
										echo "Admin projekta";
										break;	
		   			   				case 3:					
										echo "Saradnik";
										break;
					   				case 4:
					   					echo "Spoljni saradnik";
					   					break;	   			
					   				case 5:
					   					echo "Spoljni saradnik izvan RS";
					   					break;	
					   				case 6:
					   					echo "Gost";
					   					break;
								}
					   			?>
					   	</th>
											
						<th>
							<?php if ($statusulogovanog < $pom['idstatusosobe']){?>
							
								<input type="hidden" name="idosoba" value="<?php echo $pom['idosoba']?>">
								<input type="submit" class="btn btn-outline-warning btn-block" name="page" value="Azuriraj">
							
							<?php }?>
						</th>
					</tr>
				</form>	
				<?php 
							
					} 
				?>	
				</tbody>
							
			</table>
			
		</div>
			
			<?php
				if(isset($msg)){
					echo $msg;			
				}		
					
			?>
			

<?php 
	} else {
		header('Location:../upravljanje/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>	
	
</div>
<br><br><br><br>
<?php include '../tema/footer.php' ?>

			
</body>
</html>	