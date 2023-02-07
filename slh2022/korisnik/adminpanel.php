<?php
/*
 * @name Scientists little helper - adminpanel
 * @author Branko Vujatovic	
 * @date   01.08.2022.
 * @version 01
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
    $statusulogovanog = $ulogovan['idstatusosobe'];	
    $stausulogovan = $ulogovan['idosoba'];
    $sifraNMR = isset($sifraNMR)?$sifraNMR:"";
    $uradjenNMR = isset($uradjenNMR)?$uradjenNMR:"";
    $ukupnoNMR = isset($ukupnoNMR)?$ukupnoNMR:"";
    $ukupnoSinteze = isset($ukupnoSinteze)?$ukupnoSinteze:"";
    $ukupnoTakrin = isset($ukupnoTakrin)?$ukupnoTakrin:"";
    $ukupnoIC50 = isset($ukupnoIC50)?$ukupnoIC50:"";
    
    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
    $listakorisnika = isset($listakorisnika)?$listakorisnika:array();
    
    $dao=new DAO();
    $listajedinjenja=$dao->selectJedinjenjeSva();
    //$uradjenNMR = $listajedinjenja['uradjenNMR'];
    
    $dao=new DAO();
    $listakorisnika=$dao->selectOsoba();
    
    $msg=isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">
<head>

		<title>POCETNA</title>
		<?php include '../tema/head.php';?>
<body >

<?php include '../tema/adminMeni.php';?>

<br><br>
<div class="container pt-5 table-responsive">
<div class="naslov-text">
  	<h3>- PREGLED -</h3>
</div> 
 		
<table class="table table-hover table-sm">
				<thead>
					<tr style="background:#e5e5e5; color:black; font-style:italic; text-align:center;">
						<th>Ukupno jedinjenja</th>
						<th>Uradjenih NMR-ova</th>
						<th>Uradjen<br />opis sinteze</th>
						
						
					</tr>
				</thead>
				<tbody>
				<?php 
					
						
				?>
				
					<tr style="text-align:center;">
					
						<th ><?php echo count($listajedinjenja) ?></th>
						<th >
							<?php
							foreach ($listajedinjenja as $p) {
							   if($p['uradjenNMR'] == 1){
						          $ukupnoNMR++;
						      } 
						      
							}
							echo $ukupnoNMR;
						      ?>
						</th>
						<th >
							<?php
							foreach ($listajedinjenja as $p) {
							    if(!empty($p['kratakOpisSinteze'])){
						          $ukupnoSinteze++;
						      } 
						      
							}
							echo $ukupnoSinteze;
						      ?>
						</th>
						
						
					</tr>
				
				<?php 
							
					
				?>	
				</tbody>
							
			</table>
	
		
	

	

<?php 
	if(isset($msg)){
		echo $msg;			
	}		
	$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
	echo $poruka;		
?>
		

<?php 	
	} else {
		header('Location:../login/index.php?msg="Ne mozete pristupati strani direktno" ');
	}
?>	
</div>		


<?php include '../tema/footer.php';?>				
</body>
</html>	
				