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
    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    
    $kratakOpisSinteze = isset($_POST['kratakOpisSinteze'])?$_POST['kratakOpisSinteze']:"";
    $image = isset($_POST['image'])?$_POST['image']:"";
    $hrmsEsi = isset($_POST['hrmsEsi'])?$_POST['hrmsEsi']:"";
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
		<title>SLH - Azuriranje jedinjenja</title>
		<?php include '../tema/head.php';?>
<body>

<?php include '../tema/sadrzaj_posebni.php';?>

<br /><br /><br /><br>

	<div class="naslov-text">
  			<h3>- AZURIRANJE JEDINJENJA -</h3>
	</div>

<div class="main"> 
<div class="wrapper container bg-faded text-left">  
  	<!-- centralni deo --> 
 	<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		Datum unosa jedinjenja:
		<input id="ex2" class="form-control" type="date" name="datum" placeholder="Datum formiranja jedinjenja" value="<?php echo $datum ?>">
				
		Sifra jedinjenja:
		<input id="ex2" class="form-control" type="text" name="sifraJedinjenje" placeholder="Sifra jedinjenja (pr. TVMVT nnn/god)" value="<?php echo $sifraJedinjenje ?>">
			<a style="color:red; "><?php if(array_key_exists('sifraJedinjenje', $errors)) echo $errors['sifraJedinjenje']?></a>
		
		Molarna masa: 
		<input id="ex2" class="form-control" type="text" name="molarnaMasa" placeholder="Molarna masa (M= xxx.xx g/mol)" value="<?php echo $molarnaMasa?>"> g/mol<br />	
			
		Prinos jedinjenja: 
		<input id="ex2" class="form-control" type="text" name="prinos" placeholder="Prinos jedinjenja (xxx.xx %)" value="<?php echo round($prinos, 2);?>"> %<br />	
		
		HRMS Esi - masa jona
		<input id="ex2" class="form-control" type="text" name="hrmsEsi" placeholder="Masa jona" value="<?php echo $hrmsEsi;?>"> 	
		
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
		<br />
		<input type="file" name="image" value='<?php echo  $image = $_FILES['image']['name'];?>'><br />

		Kratak opis sinteze:<br> 
		<textarea rows="5" cols="40" name="kratakOpisSinteze" placeholder="Opis sinteze" ><?php echo $kratakOpisSinteze ?></textarea>
		<br>
			
		<input type="hidden" name="idosoba" value="<?php echo $idosoba; ?>">								
		<input type="hidden" name="size" value="1000000">
		<input type="hidden" name="slikaStruktura" value="<?php echo $slikaStruktura; ?>">
		<input type="hidden" name="idjedinjenje" value="<?php echo $idjedinjenje ?>">
		<button id="size" class="btn btn-outline-primary" type="submit" name="page" value="azurirajJedinjenje">Azuriraj</button>
		<button class="btn btn-outline-dark" type="submit" name="page" value="jedinjenja">Nazad</button>
		
		<!-- Model za proveru sigurnosti radnje brisanja -->
         
         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Obrisi</button>
        
          <!-- Model za potvrdu brisanja -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!--Zaglavlje modela -->
                <div class="modal-header">
                  <h4 class="modal-title">Brisanje jedinjenja - <?php echo $sifraJedinjenje ?></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Telo modela -->
                <div class="modal-body">
                  Da li ste sigurni da zelite da obrisete jedinjenje 
                </div>
                
                <!-- Podnozje modela -->
                <div class="modal-footer">
                  <button type="button" class="close" data-dismiss="modal">Odustani</button>
                  <button type="submit" class="btn btn-danger" name="page" value="brisanjeJedinjenja">Obrisi</button>
                </div>
                
              </div>
            </div>
          </div>
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

