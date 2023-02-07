<?php

/*
 * @name SLH - promena lozinke
 * @author Branko Vujatovic	
 * @date   23.11.2022
 * @version 01
 */
$msg = isset($_POST['msg'])?$_POST['msg']:"";
$errors = isset($_POST['errors'])?$_POST['errors']:"";
$msg = isset($msg)?$msg:"";
$errors = isset($errors)?$errors:array();

$username = isset($_POST['username'])?$_POST['username']:"";

$password = isset($_POST['password'])?$_POST['password']:"";
$password1 = isset($_POST['password'])?$_POST['password']:"";
$email = isset($_POST['email'])?$_POST['email']:"";
$korisnik = isset($_POST['korisnik'])?$_POST['korisnik']:array();
$korisnik=isset($korisnik)?$korisnik:array();




	
include '../login/loginHeader.php';
?>

<div class="wrapper container bg-faded text-center"> 
	<div class="main"  align="center">  
  	<!-- centralni deo --> 
 	
			<form class="form-signin" action="../upravljanje/routes.php" method="post">
				<h2 class="form-signin-heading">Promena lozinke</h2>
				<p><input class="form-control" id="ex2" type="text" name="username" placeholder="Korisnicko ime" value="<?php echo $username?>"></p>
				
				
				<p><input class="form-control" id="ex2" type="text" name="email" placeholder="E-mail" value="<?php echo $email?>"></p>

				
				<p><input class="form-control" id="ex2" type="password" name="password" placeholder="Lozinka" value="<?php echo $password?>"></p>
				
				<p><input class="form-control" id="ex2" type="password" name="password1" placeholder="Lozinka" value="<?php echo $password1?>"></p>
				
											
							
				<input id="size" class="btn btn-lg btn-outline-warning btn-block" type="submit" name="page" value="PromenaLozinke">
				<input id="size" class="btn btn-lg btn-outline-primary btn-block" type="submit" name="page" value="Login"><br />
				<a style="color:red; ">	
    				<?php 
    					if(isset($msg)){
    						echo $msg;			
    					}		
    					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
    					echo $poruka;		
    				?>
    			</a><br>
      		    
			</form>
			
		</div>
		
			
</div>
<?php include '../login/footerLogovanje.php' ?>
</body>
	
</html>
