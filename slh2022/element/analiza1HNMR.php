<?php
/*
 *  name Scientists little helper - karakterizacija 1HNMR
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
   $opisSpektra1HNMR = isset($_POST['opisSpektra1HNMR'])?$_POST['opisSpektra1HNMR']:"";
   $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
   $statusSpektra1HNMR = isset($_POST['statusSpektra1HNMR'])?$_POST['statusSpektra1HNMR']:"";
   $karakterizacija1HNMR = isset($_POST['karakterizacija1HNMR'])?$_POST['karakterizacija1HNMR']:"";
   
   $image = isset($_POST['image'])?$_POST['image']:"";
   
      
    
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - KARAKTERIZACIJA 1H NMR</title>
		<?php include '../tema/head.php';?>
		
<body>
<?php include '../tema/sadrzaj_posebni.php';?>
<br /><br /><br /><br>
<div class="naslov-text">
  	<h3>- Analiza 1H NMR -</h3>
</div>

<!-- srednji deo urediti za unos nmr  ... --> 

<div class="main"> 
<div class="wrapper container bg-faded text-left">  

<form action="../upravljanje/routes.php" method="post" enctype="multipart/form-data">
		
			<table>
    			<tr style="color:black; font-style:italic; text-align:center;"><b>Sifra NMR: </b><?php echo $sifraNMR ?></tr>
    			<tr>  </tr>
    			<tr style="color:black; font-style:italic; text-align:center;"><b> Slika spektra 1H NMR: </b><?php echo $slikaSpektra1HNMR?></tr> 
    			<th style="color:black; font-style:italic; ">
    				<div class="zoom"><?php echo '<img src="../projekat/slike/1HNMR/'.$slikaSpektra1HNMR.'" style="width: 150%; height: 100%;">';?></div>
    			</th>
    			<tr style="color:black; font-style:italic; text-align:center;">
					<th>Slika strukture Jedinjenja</th> 
					<th>Karakterizacija 1H NMR:</th>
				</tr>
			
    			<tr>
    				<td>
    					<div class="zoom"><?php echo $slikaStruktura?></div>
    				</td>
    				<td>		
    					<textarea rows="10" cols="40" name="karakterizacija1HNMR" placeholder="Karakterizacija 1H NMR" ><?php echo $karakterizacija1HNMR ?></textarea>
    				</td>
    			</tr>
			</table>
		<a title="Karakterizacija 1H NMR" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 <input type="hidden" name="size" value="1000000">
			 <input type="hidden" name="idnmr" value='<?php echo $idnmr; ?>'>
             <input type="hidden" name="idosoba" value='<?php echo $idosoba; ?>'>
			 <button class="btn btn-outline-primary" type="submit" name="page" value="Karakterizacija_1H">Azuriraj</button>
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