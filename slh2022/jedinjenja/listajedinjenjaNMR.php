<?php
/*
 * @name Scientists little helper - PREGLED JEDINJENJA sa NMR
 * @author Branko Vujatovic
 * @date  01.08.2022.
 * @version 03
 * 
 * izvrseno dodavanje prikaza statusa NMR u naslovu
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
    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
    $NMR = isset($_POST['NMR'])? $_POST['NMR']:"";
   
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $datum = isset($_POST['datum'])?$_POST['datum']:"";
    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
    
    $kratakOpisSinteze = isset($_POST['kratakOpisSinteze'])?$_POST['kratakOpisSinteze']:"";
    $image = isset($_POST['image'])?$_POST['image']:"";
    $hrmsEsi = isset($_POST['hrmsEsi'])?$_POST['hrmsEsi']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
    $linker = isset($_POST['linker'])?$_POST['linker']:"";
    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
    
    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
    /*
     * provera statusa NMR
     */
    if(empty($NMR)){
        $dao=new DAO();
        $listajedinjenja=$dao->selectJedinjenje();
     // dodeljivanje promenljivoj p status NMR = prazno   
        $p = $NMR;
        
    }else {
        $statusNMR = $NMR;
        $dao=new DAO();
        $listajedinjenja=$dao->selectJedinjenjeDobarNMR($statusNMR);
    //dodeljivanje promenljivoj p status NMR = neka vrednost od 1 do 6   
        $p = $statusNMR;
    }
    
    
    $msg=isset($msg)?$msg:"";
    
    $errors = isset($errors)?$errors:array();
    
    
    
?>
<!DOCTYPE html>
<html lang="en, sr, el">
<head>

		<title>SLH-sva jedinjenja sa NMR</title>
		<?php include '../tema/head.php';?>
		<?php include '../tema/sadrzaj_posebni.php';?>
<body >


<!-- srednji deo --> 
<br /><br><br><br>
<div style="overflow-x:auto;">	
	
		<div class="naslov-text">
  			<h3>- Status NMR = <i><b>
                      				<?php
                      				
                      				// provra stanja promenljive p
                      				
                      				if (empty($p)){
                      				    echo "Uradjen"; 
                      				}else{
                      				    
                      				//dodeljivanje vrednosti promeljnivoj p u tex obliku
                      				
                      				    switch ($p){
                      				        case 1:
                      				            echo "Dobar";
                      				            break;
                      				        case 2:
                      				            echo "Ponovljen";
                      				            break;
                      				        case 3:
                      				            echo "Loš";
                      				            break;
                      				        case 4:
                      				            echo "Spreman za slanje";
                      				            break;
                      				        case 5:
                      				            echo "Čeka rezultate";
                      				            break;
                      				        case 6:
                      				            echo "Poslat";
                      				    }
                      				}?>
                      			</b></i> -</h3>
		</div>
	
		<table class="table table-nobordered" id="myTable">
				<thead>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66; width: 60px;" >
							<a title="Datum unosa" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Datum	
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td>
  							<?php echo $pom['datum']?>
  						</td>
  						<?php }?> 
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="TVVMVT xxx/yyyy" data-content="Azuriranje jedinjenja" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Sifra jedinjenja
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  						<!-- azuriranje jedinjenja -->
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
								<a title="Azuriranje jedinjenja" data-content="podataka: Šifra jedinjenja, Slika strukture, Molarna masa, HRMS-Esi, Opis, Prinos" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 						<button class="btn btn-outline-secondary"  style="border: 2px solid black;" type="submit" name="page" value="AzuriranjeJedinjenja"><?php echo $pom['sifraJedinjenje']?></button>
  								</a>
  							</form>
  						</td>	
      					<?php }?> 
  					<tr style="color:black; font-style:italic; text-align:center; text-vertical-align:center;">
						<th style="background-color:#66ff66">
							<a title="slika strukture" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Struktura
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  							<div class="zoom">
  								<?php echo "<img src='../projekat/slike/strukturaJedinjenja/".$pom['slikaStruktura']."' >";?>
  							</div>
  						</td>
  						<?php }?> 
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="M=zzz,zz (g/mol)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Molarna masa
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  							<?php echo $pom['molarnaMasa']?> g/mol
  						</td>
  						<?php }?>
  					</tr>
  					<tr  style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="NMR sifra"  data-toggle="popover" data-placement="top" data-trigger="hover">
			 					NMR
  							</a>
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  						<!-- azuriranje NMR -->							
  							<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
  									<input type="hidden" name="idnmr" value="<?php echo $pom['idnmr']; ?>">
  									<input type="hidden" name="sifraNMR" value="<?php echo $pom['sifraNMR']; ?>">
  									<input type="hidden" name="opisNMR" value="<?php echo $pom['opisNMR']; ?>">
  									<input type="hidden" name="statusNMR" value="<?php echo $pom['statusNMR']; ?>">
  									<input type="hidden" name="serijaNMR" value="<?php echo $pom['serijaNMR']; ?>">
  									
                                   	<input type="hidden" name="size" value="1000000">
			 						<input type="hidden" name="slikaSpektra1HNMR" value="<?php echo "<img src='../projekat/slike/1HNMR/".$pom['slikaSpektra1HNMR']."' >";?>">
			 						<input type="hidden" name="slikaSpektra13CNMR" value="<?php echo "<img src='../projekat/slike/13CNMR/".$pom['slikaSpektra13CNMR']."' >";?>">
					 		   		<input type="hidden" name="slikaStruktura" value="<?php echo "<img src='../projekat/slike/strukturaJedinjenja/".$pom['slikaStruktura']."' >";?>">
			 						
					 		   		<input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
            						<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
            						<a title="Azuriranje podataka  NMR, 1H i 13C" data-content="Status NMR = 
                                						<?php switch ($pom['statusNMR']){
                                        						    case 1:
                                        						        echo "Dobar";
                                        						        break;
                                        						    case 2:
                                        						        echo "Ponovljen";
                                        						        break;
                                        						    case 3:
                                        						        echo "Loš";
                                        						        break;
                                        						    case 4:
                                        						        echo "Spreman za slanje";
                                        						        break;
                                        						    case 5:
                                        						        echo "Čeka rezultate";
                                        						        break;
                                        						    case 6:
                                        						        echo "Poslat";
                                        						        break;
                                						}?>; Serija NMR = <?php echo $pom['serijaNMR'];?>" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 						<button class="btn btn-outline-secondary" style="border: 2px solid black;" type="submit" name="page" value="AzurirajNMR"><?php echo $pom['sifraNMR']?></button>
  									</a>
  							</form>  							
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66; vertical-align:center;">
							<a title="1H NMR opis" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					1H NMR
  							</a>
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  						<!-- azuriranje 1H NMR -->								
  							<?php echo $pom['opisSpektra1HNMR'];?>
                       	</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="13C NMR opis" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					13C NMR
  							</a>
						
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  						<!-- azuriranje 13C NMR -->
  							<?php echo $pom['opisSpektra13CNMR'];?>
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Masa jona" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					HRMS Esi
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  						<!-- masa jona HRM Esi -->
							<?php echo $pom['hrmsEsi']; ?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Kratak opis sinteze" data-content="Azuriranje opisa klikom na textualno polje"  data-toggle="popover"  data-placement="top" data-trigger="hover">
			 					Opis
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  						<!-- opis sinteze -->
							<textarea  class="textarea"><?php echo $pom['kratakOpisSinteze']?></textarea>
						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Prinos sinteze u %" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Prinos
  							</a>
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  						<!-- prinos -->
							<?php echo $pom['prinos']?> %
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Preciscavanje" data-content="Kristalizacija (Rastvarac)/Hromatografija (sistem rastvaraca)"  data-toggle="popover"  data-placement="top" data-trigger="hover">
			 					Preciscavanje
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
							<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
					 		    <input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
            					<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
								<a title="Ažuriranje" data-content="podataka: prečišćavanje, sistem TLC, Agregatno stanje, Boja i sumirani izveštaj" data-toggle="popover" data-placement="top" data-trigger="hover" >
			 						<button class="btn btn-outline" type="submit" name="page" value="Preciscavanje"><textarea rows="3" cols="20" style="border: 2px solid black;" name="sumirano" placeholder="Kristalizacija (Rastvarac)/Hromatografija (sistem rastvaraca)"><?php echo $pom['preciscavanje']?></textarea></button>
  								</a>
  							</form>
  						
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Sistem za TLC" data-content="Sistem rastvaraca za detekciju na TLCu." data-toggle="popover" data-placement="top" data-trigger="hover">
			 					TLC
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  							<?php echo $pom['sistemTLC']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							<a title="Fizicke karakteristike - (Tt/Tk)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Agregatno stanje
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  							<?php echo $pom['agregatnoStanje']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">  
  							<a title="Fizicke karakteristike - boja" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Boja
  							</a>
  						</th>
  						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  							<?php echo $pom['boja']?>
  						</td>
  						<?php }?>
  					</tr>
  					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							Sumirano
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="color:black; font-style:italic; text-align:center;">
  							<textarea  class="textarea"><?php echo $pom['sumirano']?></textarea>
  						</td>
  						<?php }?>
					</tr>
					<tr style="color:black; font-style:italic; text-align:center;">
						<th style="background-color:#66ff66">
							Napomena
						</th>
						<?php foreach ($listajedinjenja as $pom) {?>
  						<td style="background-color:#e5e5e5; color:black; font-style:italic; text-align:center;">
  							<textarea  class="textarea"><?php echo $pom['napomena']?></textarea>
  						</td>
  						<?php }?>
											
					</tr>
				</thead>				
			</table>
			
			
		
		<code>	
			<?php 
				if(isset($msg)){
					echo $msg;			
				}		
				$poruka=isset($_POST["msg"])?$_POST["msg"]:"";
				echo $poruka;		
			?>
		</code>
</div>
	

<?php include '../tema/footer.php' ?>
</body>
</html>	
<?php 
   
}

?>				
