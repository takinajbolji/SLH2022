<?php
/*
 *  name Scientists little helper - azuriranje jedinjenja
 *  author Branko Vujatovic
 *  date   10.11.2021
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
    
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
    $preciscavanje = isset($_POST['preciscavanje'])?$_POST['preciscavanje']:"";
    $sistemTLC = isset($_POST['sistemTLC'])?$_POST['sistemTLC']:"";
    $agregatnoStanje = isset($_POST['agregatnoStanje'])?$_POST['agregatnoStanje']:"";
    $boja = isset($_POST['boja'])?$_POST['boja']:"";
    $sumirano = isset($_POST['sumirano'])?$_POST['sumirano']:"";
    $napomena = isset($_POST['napomena'])?$_POST['napomena']:"";
        
    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
    
    $dao = new DAO();
    $jedinjenje = $dao->selectJedinjenjeIdjedinjenje($idjedinjenje);
        
    $msg = isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    
    
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - Azuriranje jedinjenja 2 deo</title>
		<?php include '../tema/head.php';?>
		
<body>

<?php include '../tema/sadrzaj_posebni.php';?>
<br><br><br><br>
<div class="naslov-text">
  	<h3>- Ažuriranje jedinjenja-prečišćavanje -</h3>
</div>
<div class="container"> 
<div class="wrapper container bg-faded text-left">   
  	<!-- centralni deo --> 
 	<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		Šifra jedinjenja:
		<input id="ex2" class="form-control" type="text" name="sifraJedinjenje" placeholder="Sifra jedinjenja (pr. TVMVT nnn/god)" value="<?php echo $sifraJedinjenje ?>">
			<a style="color:red; "><?php if(array_key_exists('sifraJedinjenje', $errors)) echo $errors['sifraJedinjenje']?></a>
		
		preciscavanje: 
		<input id="ex2" class="form-control" type="text" name="preciscavanje" placeholder="Kristalizacija (Rastvarac)/Hromatografija (sistem rastvaraca)" value="<?php echo $preciscavanje?>">	
		<br />	
		Sistem za TLC: 
		<input id="ex2" class="form-control" type="text" name="sistemTLC" placeholder="Sistem rastvarača za detekciju na TLCu." value="<?php echo $sistemTLC;?>">
		<br />
		Fizicke karakteristike - agregatno stanje (Tt/Tk):
		<input id="ex2" class="form-control" type="text" name="agregatnoStanje" placeholder="Agregatno stanje (Tt/Tk)" value="<?php echo $agregatnoStanje;?>"> 	
		<br />
		
		Fizicke karakteristike - boja:  
		<input id="ex2" class="form-control" type="text" name="boja" placeholder="Fizicke karakteristike - boja" value="<?php echo $boja;?>"> 	
		<br />
			
			    	
		Sumirano:
		<textarea rows="5" cols="40" name="sumirano" placeholder="Sumiran izvestaj" ><?php echo $sumirano ?></textarea>
		<br>
		
		Napomena:
		<textarea rows="5" cols="40" name="napomena" placeholder="Napomena" ><?php echo $napomena ?></textarea>
		<br>
			
		<input type="hidden" name="idosoba" value="<?php echo $idosoba; ?>">								
		<input type="hidden" name="idjedinjenje" value="<?php echo $idjedinjenje ?>">
		<button id="size" class="btn btn-outline-primary" type="submit" name="page" value="AzurirajPreciscavanje">Azuriraj</button>
		<button class="btn btn-outline-dark" type="submit" name="page" value="jedinjenja">Nazad</button>
		
		          
        </form>
   </div>
   
  		
		
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


			

<?php include '../tema/footer.php' ?>
			
</body>
<?php 	
	} else {
		header('Location:../login/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>	
</html>	

