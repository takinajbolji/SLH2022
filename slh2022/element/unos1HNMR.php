<?php
/*
 *  name Scientists little helper - azuriranje unos 1HNMR
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
    $opisSpektra1HNMR = isset($_POST['opisSpektra1HNMR'])?$_POST['opisSpektra1HNMR']:"";
    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
    $statusSpektra1HNMR = isset($_POST['statusSpektra1HNMR'])?$_POST['statusSpektra1HNMR']:"";
    $karakterizacija1HNMR = isset($_POST['karakterizacija1HNMR'])?$_POST['karakterizacija1HNMR']:"";
    
    $image = isset($_POST['image'])?$_POST['image']:"";
        
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - unos 1H NMR</title>
		<?php include '../tema/head.php';?>
		
<body>
<?php include '../tema/sadrzaj_posebni.php';?>
<!-- srednji deo urediti za unos nmr  ... --> 

<br /><br /><br /><br>
<div class="naslov-text">
  	<h3>- Uns/Azuriranje 1H NMR -</h3>
</div>

<div class="main"> 
<div class="wrapper container bg-faded text-left">
<form class="form-signin" action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		Sifra NMR:
		<input id="ex2" class="form-control" type="text" name="sifraNMR" placeholder="Sifra NMR (pr. TVMVT-NMR-xxx/god)" value="<?php echo $sifraNMR ?>">
		<br>
		Slika spektra 1H NMR: 
		<br >
		<input type="hidden" name="size" value="1000000">
		<div class="zoom">
			<?php echo '<img src="../projekat/slike/1HNMR/'.$slikaSpektra1HNMR.'" >';?>
		</div>
		<br >
		<br >
		<input type="file" name="image" value='<?php echo  $image = $_FILES['image']['name'];?>'>
		<br >
		<br >		
		Opis spektra 1H NMR:
		<input id="ex2" class="form-control" type="text" name="opisSpektra1HNMR" placeholder="opis spektra 1H NMR" value="<?php echo $opisSpektra1HNMR ?>">
			
		<br>
		Status spektra 1H NMR:  
		<select id="ex2" class="form-control" name="statusSpektra1HNMR" placeholder="status spektra 1H NMR" value="<?php echo $statusSpektra1HNMR ?>">
			
        							<option value="<?php echo $statusSpektra1HNMR ?>">
        								<?php switch ($statusSpektra1HNMR){
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
        							<option value='<?php echo $statusSpektra1HNMR=1?>'>Uradjen</option>
        							<option value='<?php echo $statusSpektra1HNMR=2?>'>Ponovljen</option>
        							<option value='<?php echo $statusSpektra1HNMR=3?>'>Nije dobar</option>
        							<option value='<?php echo $statusSpektra1HNMR=4?>'>Spreman za slanje</option>
        							<option value='<?php echo $statusSpektra1HNMR=5?>'>Ceka rezultate</option>
        							<option value='<?php echo $statusSpektra1HNMR=6?>'>Poslat</option>
        						
        	</select>	
		<br>
		Karakterizacija 1H NMR:<br> 
		<textarea rows="5" cols="40" name="karakterizacija1HNMR" placeholder="Karakterizacija 1H NMR" ><?php echo $karakterizacija1HNMR ?></textarea>
		<br>
		
 		<a title="Dodaj 1H NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="idnmr" value="<?php echo $idnmr; ?>">
             <input type="hidden" name="idosoba" value="<?php echo $idosoba; ?>">
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Dodaj_1H_NMR">Dodaj/Azuriraj</button>
       	</a>
		<a title="Analiza 1H NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="slikaStruktura" value="<?php echo $slikaStruktura ?>">
			 <input type="hidden" name="idnmr" value='<?php echo $idnmr; ?>'>
             <input type="hidden" name="idosoba" value='<?php echo $idosoba; ?>'>
             <input type="hidden" name="idjedinjenje" value='<?php echo $idjedinjenje?>'>
             <input type="hidden" name="sifraNMR" value='<?php echo $sifraNMR ?>'>
			 <input type="hidden" name="opisSpektra1HNMR" value='<?php echo $opisSpektra1HNMR; ?>'>
             <input type="hidden" name="statusSpektra1HNMR" value='<?php echo $statusSpektra1HNMR; ?>'>
             <input type="hidden" name="slikaSpektra1HNMR" value='<?php echo $slikaSpektra1HNMR?>'>
             
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Analiza_1H">Analiza</button>
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


<?php include '../tema/footer.php' ?>

			
</body>
</html>	