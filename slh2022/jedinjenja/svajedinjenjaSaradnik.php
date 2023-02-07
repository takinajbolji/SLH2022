<?php
/*
 * @name Scientists little helper - PREGLED JEDINJENJA sva Saradnik
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
    $sifraNMR = isset($sifraNMR)?$sifraNMR:"";
    $uradjenNMR = isset($uradjenNMR)?$uradjenNMR:"";
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
    
    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
   
    $dao=new DAO();
    $listajedinjenja=$dao->selectJedinjenje();
    
    $i=1;
    $msg=isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
 ?>
<!DOCTYPE html>
<html lang="en, sr, el">
<head>

		<title>SLH-sva jedinjenja</title>
		<?php include '../tema/head.php';?>
<body >

<?php include '../tema/sadrzaj_posebni.php';?>
<!-- srednji deo -->  	
	
<div class="main">
	
	<div>
		<input class="form-control" id="myInput" type="text" placeholder="Pronadji ..">
 			<table class="table">
				<thead>
					<tr style="background:#e5e5e5; color:black; font-style:italic; text-align:center;">
						<th>Redni<br>broj</th>
						<th>
							<a title="Datum poslednje izmene" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Datum	
  							</a>
  						</th>
						<th>
							<a title="TVVMVT xxx/yyyy" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Sifra jedinjenja
  							</a>
  						</th>
						<th><a title="slika strukture" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Struktura
  							</a>
  						</th>
						<th>
							<a title="M=zzz,zz (g/mol)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Molarna masa
  							</a>
  						</th>
						<th>
							<a title="NMR status" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					NMR
  							</a>
						</th>
						<th>
							<a title="Masa jona" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					HRMS Esi
  							</a>
  						</th>
						<th>
							<a title="Kratak opis sinteze" data-content="Azuriranje opisa klikom na textualno polje"  data-toggle="popover"  data-placement="top" data-trigger="hover">
			 					Opis
  							</a>
  						</th>
						<th>
							<a title="Prinos sinteze u %" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Prinos
  							</a>
						</th>
						<th>Preciscavanje</th>
						<th>
							<a title="Sistem za TLC" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					TLC
  							</a>
  						</th>
						<th>
							<a title="Fizicke karakteristike - (Tt/Tk)" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Agregatno stanje
  							</a>
  						</th>
  						<th>  
  							<a title="Fizicke karakteristike - boja" data-toggle="popover" data-placement="top" data-trigger="hover">
			 					Boja
  							</a>
  						</th>
						<th>Sumirano</th>
											
					</tr>
				</thead>
				<tbody>
				
				
				<?php 
					foreach ($listajedinjenja as $pom) {
					
				?>
					<tr style="text-align:center;">
						<td ><?php echo $i++ ?></td>
						<td><?php echo $pom['datum']?></td>
						<td><!-- jedinjenja -->
							<button class="btn btn-outline" type="submit" name="page" value=""><?php echo $pom['sifraJedinjenje']?></button>
  						</td>	
  						
						<td><!-- slika jedinjenja -->
							<button class="btn btn-outline" type="submit" name="page" value=""><?php echo "<img src='../projekat/slike/strukturaJedinjenja/".$pom['slikaStruktura']."' >";?></button>
  						</td>
  						
						<td><!--  molarna masa -->
							<button class="btn btn-outline" type="submit" name="page" value=""><?php echo $pom['molarnaMasa']?></button>
  						</td>
  						
					 	<td><!-- NMR -->
					 		<?php if ($pom['uradjenNMR']==0){?>
			 					<button class="btn btn-outline" type="submit" name="page" value="">potreban NMR</button>
			 				<?php }else {?>
			 					<button class="btn btn-outline" type="submit" name="page" value="">uradjen NMR</button>
			 				<?php }?>  								
					 	</td> 
					 	
						<td><!--  masa jona HRM Esi -->
							<button class="btn btn-outline" type="submit" name="page" value=""><?php echo $pom['hrmsEsi']?></button>
  						</td>
  						
						<td><!-- opis sinteze -->
							<button class="btn btn-outline" type="submit" name="page" value="AzuriranjeJedinjenja">
			 					<textarea  class="textarea"><?php echo $pom['kratakOpisSinteze']?></textarea>
							</button>  														
						</td>
						
						<td><!-- prinos -->
							<button class="btn btn-outline" type="submit" name="page" value=""><?php echo $pom['prinos']?></button>
  						</td>
						<td><?php echo $pom['preciscavanje']?></td>
						<td><?php echo $pom['sistemTLC']?></td>
						<td><?php echo $pom['agregatnoStanje']?></td>
						<td><?php echo $pom['boja']?></td>
						<td><?php echo $pom['sumirano']?></td>
						
					</tr>
					<?php } ?>
				</tbody>				
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
	
<!-- za pretragu u tabeli -->	
<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
<!-- za iskacuce obavestenje iznad teksta -->
<script>	
	$(document).ready(function(){
  	$('[data-toggle="popover"]').popover();   
	});
</script>		
<?php 	
} 
?>	

</div>

<?php include '../tema/footer.php' ?>
</body>
</html>				

