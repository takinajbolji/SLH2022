<?php
/*
 *  name Scientists little helper - azuriranje jedinjenja
 *  author Branko Vujatovic
 *  date   10.05.2022
 *  version 01
 *
 */
if(!isset($_SESSION['ulogovan'])) {
    session_start();
}
$ulogovan=unserialize($_SESSION['ulogovan']);
$inactive = 300;//vreme zadrzavanja sesije u sekundama

if(isset($_SESSION['loginTime'])) {
    $session_life = time() - $_SESSION['loginTime'];
    if($session_life > $inactive) {
        session_destroy();
        header("Location: ../login/index.php");
    }
}
$_SESSION['loginTime']= time();

if($ulogovan){
    
    $idosoba=$ulogovan['idosoba'];
    
    $stausulogovan = $ulogovan['idosoba'];
    $sifraNMR = isset($sifraNMR)?$sifraNMR:"";
    $uradjenNMR = isset($uradjenNMR)?$uradjenNMR:"";
    
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $datum = isset($_POST['datum'])?$_POST['datum']:"";
    
    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    
    $image = isset($_POST['image'])?$_POST['image']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
    $linker = isset($_POST['linker'])?$_POST['linker']:"";
    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
    
    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
    
    $dao = new DAO();
    $jedinjenje = $dao->selectJedinjenjeIdjedinjenje($idjedinjenje);
    
    $msg = isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    
    
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - Azuriranje AFLT </title>
		<?php include '../tema/head.php';?>
<body>

<?php include '../tema/sadrzaj_posebni.php';?>

<br><br><br><br>

	<div class="naslov-text">
  			<h3>- AZURIRANJE AFLT -</h3>
  			<h5>(Aroil, Fenil, Linker, Takrin)</h5>
	</div>

<div class="main"> 
<div class="wrapper container bg-faded text-left">   
  	<!-- centralni deo --> 
 	<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		
		Sifra jedinjenja:
		<input id="ex2" class="form-control" type="text" name="sifraJedinjenje" placeholder="Sifra jedinjenja (pr. TVMVT nnn/god)" value="<?php echo $sifraJedinjenje ?>">
			<a style="color:red; "><?php if(array_key_exists('sifraJedinjenje', $errors)) echo $errors['sifraJedinjenje']?></a>
		
		Aroil:
		<input id="ex2" class="form-control" type="text" name="aroil" placeholder="Aroil" value='<?php echo $aroil ?>'><br />		
		
		Fenil:
		<input id="ex2" class="form-control" type="text" name="fenil" placeholder="Fenil" value='<?php echo $fenil ?>'><br />	
		
		Linker:
		<input id="ex2" class="form-control" type="text" name="linker" placeholder="Linker" value='<?php echo $linker ?>'><br />	
		
		Takrin:
		<input id="ex2" class="form-control" type="text" name="takrin" placeholder="Takrin" value='<?php echo $takrin ?>'><br />	
			
		<!-- Unos slike jedinjenja -->
		Slika strukture jedinjenja:  
		<br>
		<input type="hidden" name="size" value="1000000">
		<div class="zoom">
			<?php echo '<img src="../projekat/slike/strukturaJedinjenja/'.$slikaStruktura.'" >';?>
		</div>
				
		<br>
		<input type="hidden" name="idosoba" value="<?php echo $idosoba; ?>">								
		<input type="hidden" name="idjedinjenje" value="<?php echo $idjedinjenje ?>">
		<button id="size" class="btn btn-outline-primary" type="submit" name="page" value="azurirajJedinjenjeAFLT">Azuriraj</button>
		<button class="btn btn-outline-dark" type="submit" name="page" value="statistika">Nazad</button>
	</form>
  

  
		
			<a style="color:red; ">						
				<?php 
					if(isset($mg)){
						echo $msg;			
					}		
					$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
					echo $poruka;		
				?>
			</a>

</div>
</div>


		

<?php include '../tema/footer.php' ?>
			
</body>
<?php 	
	} else {
		header('Location:../login/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>	
</html>	


