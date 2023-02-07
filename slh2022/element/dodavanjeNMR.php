<?php
/*
 *  name Scientists little helper - Dodavanje NMR
 *  author Branko Vujatovic
 *  date   19.08.2020
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
	
	$idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	$idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	$sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
	$opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
	$statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	$serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
	
	$dao = new DAO();
	$jedinjenja = $dao->selectJedinjenjeSva();
	
	
?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH-dodavanje NMR</title>
		<?php include '../tema/head.php';?>
		<?php include '../tema/sadrzaj_posebni.php';?>
<body>
<br /><br /><br /><br>
<div class="naslov-text">
  	<h3>- Dodavanje NMR -</h3>
</div>

<!-- srednji deo urediti za unos nmr gc/ms ir ... --> 

	<form class="form-signin" action="../upravljanje/routes.php" method="post" >
		Sifra NMR:
		<input id="ex2" class="form-control" type="text" name="sifraNMR" placeholder="Sifra NMR (pr. TVMVT-NMR-xxx/god)" value="<?php echo $sifraNMR ?>">
		<a style="color:red; "><?php if(array_key_exists('sifraNMR', $errors)) echo $errors['sifraNMR']?></a><br>
		
		Opis NMR:  
		<input id="ex2" class="form-control" type="text" name="opisNMR" placeholder="Tekstualni opis NMR" value="<?php echo $opisNMR ?>">
		<a style="color:red; "><?php if(array_key_exists('opisNMR', $errors)) echo $errors['opisNMR']?></a><br>
				
		Status NMR:  
		<select id="ex2" class="form-control" name="statusNMR" value="<?php echo $statusNMR ?>">
			
        							<option value="<?php echo $statusNMR ?>">
        								<?php switch ($statusNMR){
        		   			   				case 1:
        		   			   					echo "Dobar";
        		   			   					break;
        		   			   				case 2:					
        										echo "Ponovljen";
        										break;	
        		   			   				case 3:					
        										echo "Los";
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
        							<option value="<?php echo $statusNMR=1?>">Dobar</option>
        							<option value="<?php echo $statusNMR=2?>">Ponovljen</option>
        							<option value="<?php echo $statusNMR=3?>">Los</option>
        							<option value="<?php echo $statusNMR=4?>">Spreman za slanje</option>
        							<option value="<?php echo $statusNMR=5?>">Ceka rezultate</option>
        							<option value="<?php echo $statusNMR=6?>">Poslat</option>
        						
        	</select>
			<br>
			Serija NMR:  
			<input class="form-control" id="ex2" type="text" name="serijaNMR" placeholder="serija NMR" value="<?php echo $serijaNMR ?>">
			<br>
             <input type="hidden" name="idjedinjenje" value="<?php  echo $idjedinjenje; ?>">
             <input type="hidden" name="idosoba" value="<?php  echo $idosoba ?>">
			 <button class="btn btn-outline-primary" type="submit" name="page" value="NMR">Dodaj NMR</button>
			 <button class="btn btn-outline-dark" type="submit" name="page" value="jedinjenja">Nazad</button>
			 <a style="color:red; ">						
				<?php 
					if(isset($mg)){
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

<script>
	$(document).ready(function(){
  	$('[data-toggle="popover"]').popover();   
	});
</script>

<?php include '../tema/footer.php' ?>

			
</body>
</html>	