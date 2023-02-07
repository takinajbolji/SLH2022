<?php
/*
 * @name Scientists little helper - PREGLED JEDINJENJA sva
 * @author Branko Vujatovic
 * @date  28.10.2021.
 * @version 02
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
       
    $stausulogovan = $ulogovan['idosoba'];
        
    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
    $vrednostNMR = isset($_POST['vrednostNMR'])?$_POST['vrednostNMR']:"";
        
    $datum = isset($_POST['datum'])?$_POST['datum']:"";
    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $kratakOpisSinteze = isset($_POST['kratakOpisSinteze'])?$_POST['kratakOpisSinteze']:"";
    $image = isset($_POST['image'])?$_POST['image']:"";
    $hrmsEsi = isset($_POST['hrmsEsi'])?$_POST['hrmsEsi']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
    $linker = isset($_POST['linker'])?$_POST['linker']:"";
    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
    $preciscavanje = isset($_POST['preciscavanje'])?$_POST['preciscavanje']:"";
    $sistemTLC = isset($_POST['sistemTLC'])?$_POST['sistemTLC']:"";
    $agregatnoStanje = isset($_POST['agregatnoStanje'])?$_POST['agregatnoStanje']:"";
    $boja = isset($_POST['boja'])?$_POST['boja']:"";
    $sumirano = isset($_POST['sumirano'])?$_POST['sumirano']:"";
    $napomena = isset($_POST['napomena'])?$_POST['napomena']:"";
    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
    
    $idnmr = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
   
    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
        $uradjenNMR==0;
        $dao=new DAO();
        $listajedinjenja=$dao->selectJedinjenjeUradjenNMR($uradjenNMR);
    
   /*else{
        $uradjenNMR=1;
        $dao = new DAO();
        $listajedinjenja =$dao->selectJedinjenjeUradjenNMR($uradjenNMR);
    }*/
   
    
    $msg=isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    
    
 ?>
<!DOCTYPE html>
<html lang="en, sr, el">
<head>

		<title>SLH-sva jedinjenja</title>
		<?php include '../tema/head.php';?>
<body >

<?php include '../tema/sadrzaj_posebni.php'; ?>
<!-- srednji deo --> 
<br><br><br><br>		
<div style="overflow-x:auto;">	
		
		<div class="naslov-text">
  			<h3>- PREGLED JEDINJENJA BEZ NMR-a -</h3>
			
		</div>
		<table class="table table-nobordered" id="myTable">
				<thead>
					
					<tr style="background:#e5e5e5; color:black; font-style:italic; text-align:center; width: 40px; ">
						<th style="background-color:#FFAF33; vertical-align:center;">R.br.</th>
						<?php foreach ($listajedinjenja as $pom) {?>
						<td style="color:black; font-style:italic; text-align:center;">
							<?php echo $pom['idjedinjenje']?>
						</td>
						<?php }?> 
					</tr> 
					 
					<tr style="color:black; font-style:italic; text-align:center; vertical-align:center;">
						<th style="background-color:#FFAF33; vertical-align:center;">
							<a title="Datum unosa" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Datum	
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  							<?php echo $pom['datum']?>
  						</td>
  						<?php }?> 
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="TVVMVT xxx/yyyy" data-content="Azuriranje jedinjenja" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Sifra jedinjenja
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
      						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
    					 		<input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
    					 		<input type="hidden" name="sifraJedinjenje" value="<?php  echo $pom['sifraJedinjenje']; ?>">
                				<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
                				<input type="hidden" name="datum" value="<?php  echo $pom['datum']; ?>">
                				<input type="hidden" name="molarnaMasa" value="<?php  echo $pom['molarnaMasa']; ?>">
                				<input type="hidden" name="hrmsEsi" value="<?php  echo $pom['hrmsEsi']; ?>">
                				<input type="hidden" name="prinos" value="<?php  echo $pom['prinos']; ?>">
                				<input type="hidden" name="aroil" value="<?php  echo $pom['aroil']; ?>">
    					 		<input type="hidden" name="fenil" value="<?php  echo $pom['fenil']; ?>">
    					 		<input type="hidden" name="takrin" value="<?php  echo $pom['takrin']; ?>">
                				<input type="hidden" name="linker" value="<?php  echo $pom['linker']; ?>">
                				<input type="hidden" name="kratakOpisSinteze" value="<?php echo $pom['kratakOpisSinteze'] ?>">
                				<input type="hidden" name="slikaStruktura" value="<?php echo $pom['slikaStruktura'] ?>">
    							<a title="Azuriraj jedinjenje" data-toggle="popover" data-placement="top" data-trigger="hover" >
    			 					<button class="btn btn-outline-secondary" style="border: 2px solid black;" type="submit" name="page" value="AzuriranjeJedinjenja"><?php echo $pom['sifraJedinjenje']?></button>
      							</a>
      						</form>
      					</td>
      					<?php }?> 
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="slika strukture" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Struktura
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<div class="zoom">
  								<?php echo "<img src='../projekat/slike/strukturaJedinjenja/".$pom['slikaStruktura']."' >";?>
  							</div>
  						</td>
  						<?php }?> 
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="M=zzz,zz (g/mol)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Molarna masa
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<?php echo $pom['molarnaMasa']?> g/mol
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="NMR status" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					NMR
  							</a>
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td><!-- azuriranje/dodavanje NMR -->
  						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
					 			
			 						<input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
            						<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
			 						<button class="btn btn-outline-secondary" style="background-color:red; border-color:none;" type="submit" name="page" value="NMR">Dodaj NMR</button>
			 					
  							</form> 	
					 							
  						</td>
  						<?php }?>
  					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Masa jona" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					HRMS Esi
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td><!-- masa jona HRM Esi -->
							<?php echo $pom['hrmsEsi']; ?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Kratak opis sinteze" data-content="Azuriranje opisa klikom na textualno polje"  data-toggle="popover"  data-placement="top" data-trigger="hover">
			 					Opis
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td><!-- opis sinteze -->
							<textarea  class="textarea"><?php echo $pom['kratakOpisSinteze']?></textarea>
						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Prinos sinteze u %" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Prinos
  							</a>
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td><!-- prinos -->
							<?php echo $pom['prinos']?> %
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Preciscavanje" data-content="Kristalizacija (Rastvarac)/Hromatografija (sistem rastvaraca)"  data-toggle="popover"  data-placement="top" data-trigger="hover">
			 					Preciscavanje
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
							<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
					 		    <input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
    					 		<input type="hidden" name="sifraJedinjenje" value="<?php  echo $pom['sifraJedinjenje']; ?>">
                				<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
                				
                				<input type="hidden" name="sistemTLC" value="<?php  echo $pom['sistemTLC']; ?>">
                				<input type="hidden" name="agregatnoStanje" value="<?php  echo $pom['agregatnoStanje']; ?>">
                				<input type="hidden" name="boja" value="<?php  echo $pom['boja']; ?>">
                				<input type="hidden" name="sumirano" value="<?php  echo $pom['sumirano']; ?>">
    					 		<input type="hidden" name="napomena" value="<?php  echo $pom['napomena']; ?>">
    					 		
								<a title="AÅ¾uriranje" data-content="podataka: preÄ�iÅ¡Ä‡avanje, sistem TLC, Agregatno stanje, Boja i sumirani izveÅ¡taj" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 						<button class="btn btn-outline" type="submit" name="page" value="Preciscavanje"><textarea rows="3" cols="20" style="border: 2px solid black;" name="preciscavanje" placeholder="Kristalizacija (Rastvarac)/Hromatografija (sistem rastvaraca)"><?php echo $pom['preciscavanje']?></textarea></button>
  								</a>
  							</form>
  						
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Sistem za TLC" data-content="Sistem rastvaraca za detekciju na TLCu." data-toggle="popover" data-placement="top" data-trigger="hover">
			 					TLC
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<?php echo $pom['sistemTLC']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							<a title="Fizicke karakteristike - (Tt/Tk)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Agregatno stanje
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<?php echo $pom['agregatnoStanje']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">  
  							<a title="Fizicke karakteristike - boja" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Boja
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<?php echo $pom['boja']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							Sumirano
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<textarea  class="textarea"><?php echo $pom['sumirano']?></textarea>
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#FFAF33">
							Napomena
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<textarea  class="textarea"><?php echo $pom['napomena']?></textarea>
  						</td>
  						<?php }?>
											
					</tr>
					
				</thead>
		</table>
					
</div>	
<code>	
			<?php 
				if(isset($msg)){
					echo $msg;			
				}		
				$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
				echo $poruka;		
			?>
</code>

<?php 	
} 
?>	

<?php include '../tema/footer.php' ?>
</body>
</html>				

