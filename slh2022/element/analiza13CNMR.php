<?php
/*
 *  name Scientists little helper - karakterizacija 13C NMR
 *  author Branko Vujatovic
 *  date   04.04.2022
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
    $statusSpektra13CNMR = isset($_POST['statusSpektra13CNMR'])?$_POST['statusSpektra13CNMR']:"";
    $karakterizacija13CNMR = isset($_POST['karakterizacija13CNMR'])?$_POST['karakterizacija13CNMR']:"";
    
    $image = isset($_POST['image'])?$_POST['image']:"";
    
   
    
   
    
    
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - KARAKTERIZACIJA 13CNMR</title>
		<?php include '../tema/head.php';?>
		
<body>
<?php include '../tema/sadrzaj_posebni.php';?>
<br /><br /><br><br>
<div class="naslov-text">
  	<h3>- Analiza 13C NMR -</h3>
</div>
<!-- srednji deo urediti za unos nmr  ... --> 
<div class="main"> 
<div class="wrapper container bg-faded text-left">  

<form action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		
			<table style="position: left:250px;">
    			<tr style="color:black; font-style:italic; text-align:center;"><b>Sifra NMR: </b><?php echo $sifraNMR ?></tr>
    			<tr>  </tr>
    			<tr style="color:black; font-style:italic; text-align:center;"> <b> Slika spektra 13CNMR: </b> <?php echo $slikaSpektra13CNMR ?></tr>
    			<tr style="color:black; font-style:italic; ">
    				<div class="zoom"><?php echo '<img src="../projekat/slike/13CNMR/'.$slikaSpektra13CNMR.'" style="width: 40%; height: auto;">';?></div>
    			</tr>
    			<tr style="color:black; font-style:italic; text-align:center;">
					<th>Slika strukture Jedinjenja</th> 
					<th>Karakterizacija 13CNMR:</th>
				</tr>
			
    			<tr>
    				<td>
    					<div class="zoom">
    						<?php echo $slikaStruktura?>
    					</div>
    				</td>
    				<td>		
    					<textarea rows="10" cols="50" name="karakterizacija13CNMR" placeholder="Karakterizacija 13CNMR" ><?php echo $karakterizacija13CNMR ?></textarea>
    				</td>
    			</tr>
			</table>
		<a title="Karakterizacija 13C NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="idnmr" value='<?php echo $idnmr; ?>'>
             <input type="hidden" name="idosoba" value='<?php echo $idosoba; ?>'>
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Karakterizacija_13C">Azuriraj</button>
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
</div>
</div>	
		<?php
				if(isset($msg)){
					echo $msg;			
				}		
			?>
		
<?php 	
	} 
?>





<?php include '../tema/footer.php' ?>

			
</body>
</html>	