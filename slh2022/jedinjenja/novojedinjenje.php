<?php
/*
 * @name SLH - novo jedinjnje
 * @author Branko Vujatovic	
 * @date   03.07.2020.
 * @version 01
 */
require_once '../model/DAO.php';

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

if($ulogovan) {
		
    $idosoba=$ulogovan['idosoba'];
    
    $dao=new DAO();
    $osoba=$dao->selectOsoba();
    
    $osoba = isset($osoba)?$osoba:array();
    
    $datum = isset($_POST['datum'])?$_POST['datum']:"";
    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
    $linker = isset($_POST['linker'])?$_POST['linker']:"";
    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $image = isset($_POST['image'])?$_POST['image']:"";
        
    $msg = isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
	
	
?>
<!DOCTYPE html>
<html lang="sr,en,el">

<head>
		<title>SLH - novo jedinjenje</title>
		<?php include '../tema/head.php';?>
<body>		
		<?php include '../tema/sadrzaj_posebni.php';?>
<br><br><br><br>
<div class="naslov-text">
  	<h3>- Novo jedinjenje -</h3>
</div>
<div class="main"> 
<div class="wrapper container bg-faded text-center">   
  	<!-- centralni deo --> 
 	<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		Datum unosa jedinjenja:
		<input id="ex2" class="form-control" type="date" name="datum" placeholder="Datum formiranja jedinjenja" value="<?php echo $datum ?>">
		<a style="color:red; "><?php if(array_key_exists('datum', $errors)) echo $errors['datum']?></a>
	
		Sifra jedinjenja:
		<input id="ex2" class="form-control" type="text" name="sifraJedinjenje" placeholder="Sifra jedinjenja (pr. TVMVT nnn/god)" value="<?php echo $sifraJedinjenje ?>">
			<a style="color:red; "><?php if(array_key_exists('sifraJedinjenje', $errors)) echo $errors['sifraJedinjenje']?></a>
		
		Molarna masa (g/mol): 
		<input id="ex2" class="form-control" type="text" name="molarnaMasa" placeholder="Molarna masa (M= xxx.xx g/mol)" value="<?php echo $molarnaMasa?>">
				
		Prinos jedinjenja (%): 
		<input id="ex2" class="form-control" type="text" name="prinos" placeholder="Prinos jedinjenja (xxx.xx %)" value='<?php echo $prinos ?>'>
		
		Aroil:
		<input id="ex2" class="form-control" type="text" name="aroil" placeholder="Aroil" value='<?php echo $aroil ?>'>		
		
		Fenil:
		<input id="ex2" class="form-control" type="text" name="fenil" placeholder="Fenil" value='<?php echo $fenil ?>'>	
		
		Linker:
		<input id="ex2" class="form-control" type="text" name="linker" placeholder="Linker" value='<?php echo $linker ?>'>	
		
		Takrin:
		<input id="ex2" class="form-control" type="text" name="takrin" placeholder="Takrin" value='<?php echo $takrin ?>'>	
			
		<!-- Unos slike jedinjenja -->
		
		Izbor slike strukture jedinjenja:  
		
		<input type="hidden" name="size" value="1000000">
		<input type="file" name="image" value='<?php echo  $image=$_FILES['image']['name'];?>'><br />
		<br>		
			
		<input type="hidden" name="idosoba" value='<?php  echo $idosoba; ?>'>
		<input type="hidden" name="size" value="1000000">
		<input type="hidden" name="image" value='<?php echo $image;?>'>
		<button id="size" class="btn btn-outline-primary" type="submit" name="page" value="Novo_jedinjenje">Novo jedinjenje</button>
		<button class="btn btn-outline-dark" type="submit" name="page" value="jedinjenja">Nazad</button>
		<br />
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
		
<?php 	
	} else {
		header('Location:../login/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>		

<?php include '../tema/footer.php' ?>
</body>
	
</html>
