<?php

/*
 * @name Scientists little helper - registracija
 * @author Branko Vujatovic	
 * @date   23.06.2022.
 * @version 02
 */
	
	$username = isset($_POST['username'])?$_POST['username']:"";
	$ime = isset($_POST['ime'])?$_POST['ime']:"";
	$prezime = isset($_POST['prezime'])?$_POST['prezime']:"";
	$password = isset($_POST['password'])?$_POST['password']:"";
	$password1 = isset($_POST['password'])?$_POST['password']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	
	//$msg = isset($_POST['msg'])?$_POST['msg']:"";
	//$errors = isset($_POST['errors'])?$_POST['errors']:"";
	$msg = isset($msg)?$msg:"";
	$errors = isset($errors)?$errors:array();
	
	include '../login/loginHeader.php';
?>

<div class="wrapper container bg-faded text-center">
	<div class="main" align="center">   
  	<!-- centralni deo --> 
 	
			<form class="form-signin" action="../upravljanje/routes.php" method="post">
				<h2 class="form-signin-heading">Registracija</h2>
				<p><input class="form-control" id="ex2" type="text" name="username" placeholder="Korisnicko ime" value="<?php echo $username?>"></p>
				<a style="color:red; "><?php if(array_key_exists('username', $errors)) echo $errors['username']?></a>
				
				<p><input class="form-control" id="ex2" type="password" name="password" placeholder="Lozinka" value="<?php echo $password?>"></p>
				<a style="color:red; "><?php if(array_key_exists('password', $errors)) echo $errors['password']?></a>
				
				<p><input class="form-control" id="ex2" type="password" name="password1" placeholder="Lozinka" value="<?php echo $password1?>"></p>
				<a style="color:red; "><?php if(array_key_exists('password1', $errors)) echo $errors['password1']?></a>
				
				<p><input class="form-control" id="ex2" type="text" name="ime" placeholder="Ime" value="<?php echo $ime?>"></p>
				<a style="color:red; "><?php if(array_key_exists('ime', $errors)) echo $errors['ime']?></a>
				
				<p><input class="form-control" id="ex2" type="text" name="prezime" placeholder="Prezime" value="<?php echo $prezime?>"></p>
				<a style="color:red; "><?php if(array_key_exists('prezime', $errors)) echo $errors['prezime']?></a>
											
				<p><input class="form-control" id="ex2" type="text" name="email" placeholder="E-mail" value="<?php echo $email?>"></p>
				<a style="color:red; "><?php if(array_key_exists('email', $errors)) echo $errors['email']?></a>
							
				<input id="size" class="btn btn-lg btn-outline-warning btn-block" type="submit" name="page" value="Registracija">
				<input id="size" class="btn btn-lg btn-outline-primary btn-block" type="submit" name="page" value="Login">
    			<a style="color:red; ">	
    				<?php 
    					if(isset($msg)){
    						echo $msg;			
    					}		
    					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
    					echo $poruka;		
    				?>
    			</a>
			</form>
			
		</div>
		
			
</div>
<?php include '../login/footerLogovanje.php' ?>
</body>
	
</html>