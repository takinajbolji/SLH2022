<?php
/*
 * @name Scientists little helper - ulazak
 * @author Branko Vujatovic	
 * @date   23.11.2022
 * @version 02
 *  
 */
$msg = isset($_POST['msg'])?$_POST['msg']:"";
$msg = isset($msg)?$msg:"";
include '../login/loginHeader.php';
?>
<body>
<br>
<div class="main">

<div class="wrapper container bg-faded text-center">


  	<form class="form-signin" action="../upravljanje/routes.php" method="post">
  	<!-- centralni deo --> 
 
		
	      	<h5 class="form-signin-heading">Molim, ulogujte se</h5>
	    	<input type="text" class="form-control" name="username" placeholder="Korisnicko ime"/><br>
	      	<input type="password" class="form-control" name="password" placeholder="Lozinka"/><br>     
	      	<label class="checkbox">
	        	<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Zapamti me
	      	</label><br><br> 
	      	<button class="btn btn-lg btn-primary btn-block" type="submit" name="page" value="Login">Prijavi se</button> <br>
	      	
	      	<p class="message">
	    	<a style="color:red; ">
		    	<?php 
					if(isset($msg)){
						echo $msg;			
					}		
					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
					echo $poruka;		
				?>
			</a></p>
			
	   			<p class="message">Nemate nalog? <a href="../korisnik/registracija.php">Kreiraj nalog</a></p>
	   			<p class="message"><a href="../korisnik/promenalozinke.php">Dodavanje ili promena lozinke!</a></p>
	</form>
</div>
</div>
<br><br><br>

</body>

<?php include '../login/footerLogovanje.php' ?>

</html>	
		