<?php
/*
 * @name SLH - dodavanje korisnika
 * @author Branko Vujatovic	
 * @date   06.03.2019
 * @version 01
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
		
	$username = isset($_POST['username'])?$_POST['username']:"";
	$ime = isset($_POST['ime'])?$_POST['ime']:"";
	$prezime = isset($_POST['prezime'])?$_POST['prezime']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	$mobilni = isset($_POST['mobilni'])?$_POST['mobilni']:"";
	$idstatusosobe = isset($_POST['idstatusosobe'])?$_POST['idstatusosobe']:"";
	
	
	$msg = isset($msg)?$msg:"";
	$errors = isset($errors)?$errors:array();
	
?>

<!DOCTYPE html>
<html lang="en, sr">
<head>
		<title>Scientists little helper - Dodavanje osobe</title>
		<?php include '../tema/head.php';?>

<body>

<?php include '../tema/sadrzaj_posebni.php';?>
<br><br /><br><br>
<div class="naslov-text">
  	<h3>- Novi korisnik -</h3>
</div>
<div style="overflow-x:auto;">
<div class="wrapper container bg-faded text-center">   
  	<!-- centralni deo --> 
 	
			<form class="form-signin" action="../upravljanje/routes.php" method="post">
				
				<input class="form-control" id="ex2" type="text" name="username" placeholder="Korisnicko ime" value="<?php echo $username ?>">
				<a style="color:red; "><?php if(array_key_exists('username', $errors)) echo $errors['username']?></a>
				<br>
				<input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php echo $ime?>">
				<a style="color:red; "><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></a>
				<br>
				<input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php echo $prezime?>">
				<a style="color:red; "><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></a>
				<br>							
				<input class="form-control" id="ex2" type="text" name="email" placeholder="E-mail" value="<?php echo $email?>">
				<a style="color:red; "><?php if(array_key_exists('email', $errors)) echo $errors['email']?></a>
				<br>			
				<input class="form-control" id="ex2" type="text" name="mobilni" placeholder="Mobilni" value="<?php echo $mobilni?>">
				<a style="color:red; "><?php if(array_key_exists('mobilni', $errors)) echo $errors['mobilni']?></a>
				<br>
				<?php include '../korisnik/statusKorisnika.php';?>
										
				<br>
      			<button id="size" class="btn btn-outline-primary btn-outline-warning" type="submit" name="page" value="Dodaj">Dodaj</button>
								
				<button id="size" class="btn btn-outline-primary btn-outline-dark" type="submit" name="page" value="Nazad">Nazad</button>
				<br>
			</form>
			<a style="color:red; ">	
				<?php 
					if(isset($msg)){
						echo $msg;			
					}		
					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
					echo $poruka;		
				?>
			</a>
			
		</div>
</div>		
<?php 
	} else {
		header('Location:../upravljanje/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>				

<?php include '../tema/footer.php' ?>
</body>
	
</html>