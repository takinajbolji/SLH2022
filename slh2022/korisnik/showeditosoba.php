<?php

/*
 * @name SLH - izmene podataka osobe
 * @author Branko Vujatovic	
 * @date  28.06.2020.
 * @version 01
 */
	
if(!isset($_SESSION['ulogovan'])) {
	session_start();
}

$ulogovan=unserialize($_SESSION['ulogovan']);

$inactive = 900;

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
    $osobaulogovanog = $osoba['idosoba'];
	$username = $osoba['username'];
	$ime = $osoba['ime'];
	$prezime = $osoba['prezime'];
	$email = $osoba['email'];
	$mobilni = $osoba['mobilni'];
	$idstatusosobe = $osoba['idstatusosobe'];
	$idosoba=$osoba['idosoba'];
	
	$msg = isset($msg)?$msg:"";
	
	$errors = isset($errors)?$errors:array();
	
	
?>
<!DOCTYPE html>
<html lang="en, sr">

<head>
		<title>Scientists little helper - Promena podataka osobe</title>
		<?php include '../tema/head.php';?>
<body>

<?php include '../tema/sadrzaj_posebni.php';?>
<br><br><br><br>
<div class="naslov-text">
  	
  	<h3>- IZMENA PODATAKA KORISNIKA -</h3>
</div>
<div class="main">
<div class="wrapper container bg-faded text-center">   
  	<!-- centralni deo --> 
 	
			<form class="form-signin" action="../upravljanje/routes.php" method="post">
				
				<p><input class="form-control" id="ex2" type="text" name="username" placeholder="Korisnicko ime" value="<?php echo $username?>"></p>
				<a style="color:red; "><?php if(array_key_exists('username', $errors)) echo $errors['username']?></a>
				
				<p><input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php echo $ime?>"></p>
				<a style="color:red; "><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></a>
				
				<p><input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php echo $prezime?>"></p>
				<a style="color:red; "><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></a>
											
				<p><input class="form-control" id="ex2" type="text" name="email" placeholder="E-mail" value="<?php echo $email?>"></p>
				<a style="color:red; "><?php if(array_key_exists('email', $errors)) echo $errors['email']?></a>
							
				<p><input class="form-control" id="ex2" type="text" name="mobilni" placeholder="Mobilni" value="<?php echo $mobilni?>"></p>
				<a style="color:red; "><?php if(array_key_exists('mobilni', $errors)) echo $errors['mobilni']?></a>
				
				<?php if($statusulogovanog < $osoba['idstatusosobe']){?>
					<?php include '../korisnik/statusKorisnika.php';?>
				
					<br>
								
					<a style="color:red; "><?php if(array_key_exists('idstatusosobe', $errors)) echo $errors['idstatusosobe']?></a>
				<?php }?>
				<?php if($osobaulogovanog == $osoba['idosoba'] and $statusulogovanog <= $osoba['idstatusosobe']){?>
					<input type="hidden" name="idosoba" value="<?php echo $osoba['idosoba']?>">
					<input id="size" class="btn btn-outline-warning btn-block" type="submit" name="page" value="Izmeni">
				<?php }?>
    			<a style="color:red; ">	
    				<?php 
    					if(isset($msg)){
    						echo $msg;			
    					}		
    					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
    					echo $poruka;		
    				?>
    			</a>
    			<button id="size" class="btn btn-outline-dark btn-block" type="submit" name="page" value="Nazad">Nazad</button>
    			<button id="size" type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#myModal">Obrisi</button>
            
                      <!-- Model za potvrdu brisanja -->
                      <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                          <div class="modal-content">
                          
                            <!--Zaglavlje modela -->
                            <div class="modal-header">
                              <h4 class="modal-title">Brisanje korisnika - <?php echo $osoba['ime']." ".$osoba['prezime']  ?></h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Telo modela -->
                            <div class="modal-body">
                              Da li ste sigurni da zelite da obrisete korisnika 
                            </div>
                            
                            <!-- Podnozje modela -->
                            <div class="modal-footer">
                              <button type="button" class="close" data-dismiss="modal">Odustani</button>
                              <input type="hidden" name="idosoba" value="<?php echo $osoba['idosoba']?>">
                              <button type="submit" class="btn btn-danger" name="page" value="obrsiosobu">Obrisi</button>
                            </div>
                            
                          </div>
                        </div>
            		</div>
			</form>
						   
<?php 
	} else {
		header('Location:../upravljanje/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>				
</div>
</div>
<?php include '../tema/footer.php' ?>
</body>
	
</html>