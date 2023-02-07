<?php
/*
 *  name Scientists little helper - azuriranje unos 13CNMR
 *  author Branko Vujatovic
 *  date   09.11.2021
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
    
    $msg=isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    
    $nmr = isset($nmr)?$nmr:array();
    $jedinjenjeStruktura = isset($jedinjenjeStruktura)? $jedinjenjeStruktura:array();
    
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
    $opisSpektra13CNMR = isset($_POST['opisSpektra13CNMR'])?$_POST['opisSpektra13CNMR']:"";
    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
    $statusSpektra13CNMR = isset($_POST['statusSpektra1HNMR'])?$_POST['statusSpektra1HNMR']:"";
    $karakterizacija13CNMR = isset($_POST['karakterizacija13CNMR'])?$_POST['karakterizacija13CNMR']:"";
    
    $image = isset($_POST['image'])?$_POST['image']:"";
    
      
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - unos 13C NMR</title>
		<?php include '../tema/head.php';?>
	
<body>

<?php include '../tema/sadrzaj_posebni.php';?>


<br /><br /><br /><br>
<div class="naslov-text">
  	<h3>- Uns/Azuriranje 13C NMR -</h3>
</div>
<!-- srednji deo urediti za unos nmr  ... --> 
<div class="main"> 
<div class="wrapper container bg-faded text-left">
<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		Sifra NMR:
		<input id="ex2" class="form-control" type="text" name="sifraNMR" placeholder="Sifra NMR (pr. TVMVT-NMR-xxx/god)" value="<?php echo $sifraNMR ?>">
		<br>
		Slika spektra 13C NMR: 
		<br >
	
		<input type="hidden" name="size" value="1000000">
		<div class="zoom">
			<?php echo '<img src="../projekat/slike/13CNMR/'.$slikaSpektra13CNMR.'" >';?>
		</div>
		<br >
		<br >
		<input type="file" name="image" value='<?php echo  $image = $_FILES['image']['name'];?>'>
		<br >
		<br >		
		Opis spektra 13C NMR:
		<input id="ex2" class="form-control" type="text" name="opisSpektra13CNMR" placeholder="opis spektra 13C NMR" value="<?php echo $opisSpektra13CNMR ?>">
			
		<br>
		Status spektra 13C NMR:  
		<select id="ex2" class="form-control" name="statusSpektra13CNMR" placeholder="status spektra 13C NMR" value="<?php echo $statusSpektra13CNMR ?>">
			
        							<option value="<?php echo $statusSpektra13CNMR ?>">
        								<?php switch ($statusSpektra13CNMR){
        		   			   				case 1:
        		   			   					echo "Uradjen";
        		   			   					break;
        		   			   				case 2:					
        										echo "Ponovljen";
        										break;	
        		   			   				case 3:					
        										echo "Nije dobar";
        										break;
        					   				case 4:
        					   					echo "Spreman za slanje";
        					   					break;	   			
        					   				case 5:
        					   					echo "Ceka rezultate";
        					   					break;	
        					   				case 6:
        					   					echo "Poslat";
        					   					break;
        					   				}	 ?>
        					   		</option>
        							<option value='<?php echo $statusSpektra13CNMR=1?>'>Uradjen</option>
        							<option value='<?php echo $statusSpektra13CNMR=2?>'>Ponovljen</option>
        							<option value='<?php echo $statusSpektra13CNMR=3?>'>Nije dobar</option>
        							<option value='<?php echo $statusSpektra13CNMR=4?>'>Spreman za slanje</option>
        							<option value='<?php echo $statusSpektra13CNMR=5?>'>Ceka rezultate</option>
        							<option value='<?php echo $statusSpektra13CNMR=6?>'>Poslat</option>
        						
        	</select>	
		<br>
		Karakterizacija 13C NMR:<br> 
		<textarea rows="5" cols="40" name="karakterizacija13CNMR" placeholder="Karakterizacija 13C NMR" ><?php echo $karakterizacija13CNMR ?></textarea>
		<br>
 		<a title="Dodaj 13C NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="idnmr" value="<?php echo $idnmr; ?>">
             <input type="hidden" name="idosoba" value="<?php echo $idosoba; ?>">
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Dodaj_13C_NMR">Dodaj/Azuriraj</button>
       		
		</a>
		<a title="Analiza 13C NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="slikaStruktura" value="<?php echo $slikaStruktura ?>">
			 <input type="hidden" name="idnmr" value='<?php echo $idnmr; ?>'>
             <input type="hidden" name="idosoba" value='<?php echo $idosoba; ?>'>
             <input type="hidden" name="idjedinjenje" value='<?php echo $idjedinjenje?>'>
             <input type="hidden" name="sifraNMR" value='<?php echo $sifraNMR ?>'>
			 <input type="hidden" name="opisSpektra13CNMR" value='<?php echo $opisSpektra13CHNMR; ?>'>
             <input type="hidden" name="statusSpektra13CNMR" value='<?php echo $statusSpektra13CNMR; ?>'>
             <input type="hidden" name="slikaSpektra13CNMR" value='<?php echo $slikaSpektra13CNMR?>'>
             
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Analiza_13C">Analiza</button>
		</a>
		
			<button class="btn btn-outline-dark" type="submit" name="page" value="ListaJedinjenja">Nazad</button>		
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
	
		
			
			<?php
				if(isset($msg)){
					echo $msg;			
				}		
			?>
		
<?php 	
	} 
?>

</div>
</div>	
<script>
	$(document).ready(function(){
  	$('[data-toggle="popover"]').popover();   
	});
</script>

<?php include '../tema/footer.php' ?>

			
</body>
</html>	