<?php

/*
 *name:"Scientists little helper - STATISTIKA"
 *author: Branko Vujatovic
 *date: 06.08.2022.
 *version: 01
 *
 */
if (! isset($_SESSION['ulogovan'])) {
    session_start();
}
$ulogovan = unserialize($_SESSION['ulogovan']);
$inactive = 300; // vreme zadrzavanja sesije u sekundama

if (isset($_SESSION['loginTime'])) {
    $session_life = time() - $_SESSION['loginTime'];
    if ($session_life > $inactive) {
        session_destroy();
        header("Location: ../login/index.php");
    }
}
$_SESSION['loginTime'] = time();

if ($ulogovan) {

    $stausulogovan = $ulogovan['idosoba'];
    $sifraNMR = isset($sifraNMR)?$sifraNMR:"";
    $statusNMR = isset($statusNMR)? $statusNMR:"";
    
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $datum = isset($_POST['datum'])?$_POST['datum']:"";
    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
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
   
    $dugme = isset($dugme)?$dugme:"";
    
    if (empty($dugme)) {
        
        $dao = new DAO();
        $listajedinjenja = $dao->selectJedinjenjePoPrinosuRastuce();
        
    } elseif($dugme=2) {
        
        $dao = new DAO();
        $listajedinjenja = $dao->selectJedinjenjePoPrinosuOpadajuce();
        
    } 
    /*elseif($dugme=3){
        
        $dao =new DAO();
        $listajedinjenja = $dao->selectJedinjenjeSva();
    }*/
    
    $msg = isset($msg) ? $msg : "";
    $errors = isset($errors) ? $errors : array();
   
 ?>
    
<!DOCTYPE html>
<html lang="en, sr, el">
<head>

<title>SLH-statistika</title>
		<?php include '../tema/head.php';?>

</head>
<body>

<?php include '../tema/sadrzaj_posebni.php';?>
<!-- srednji deo -->
<br><br>
	
	<div class="container pt-5 table-responsive">

		<div class="naslov-text">
			<h3>- TABELA SUPSTITUCIJE JEDINJENJA -</h3>
		</div>
		<p>
			TAKRIN<br />Jedinjenje: supstituenti
		</p>

		<table class="table table-hover table-sm">
		
			<thead>
			<div class="header" id="myHeader">
				<tr class="header" id="myHeader" style="background: #e5e5e5; color: black; font-style: italic; text-align: center;">
					<th>Sifra<br />jedinjenja</th>
					<th>aroil</th>
					<th>fenil</th>
					<th>linker</th>
					<th>takrin</th>
					<th style="text-align: center;">Prinos reakcije<br />(%)</th>
					<th style="text-align: center;">IC50<br />(nM)</th>

				</tr>
				</div>
			</thead>
		
			<div class="content">
			<tbody>
			<?php foreach ($listajedinjenja as $pom) {?>
				
				<!-- Proverava da li je jedinjenju dodeljen linker, ne prikazuju se jedinjenja bez linkera -->
				<?php //if(!empty($pom['linker'])){?>
				
				<tr class="content" style="text-align: center;">



					<th>
						<form class="form-control-file" action="../upravljanje/routes.php"	method="post">
							<input type="hidden" name="idjedinjenje" value="<?php  echo $pom['idjedinjenje']; ?>">
    					 		<input type="hidden" name="sifraJedinjenje" value="<?php  echo $pom['sifraJedinjenje']; ?>">
                				<input type="hidden" name="idosoba" value="<?php  echo $pom['idosoba']; ?>">
                				<input type="hidden" name="aroil" value="<?php  echo $pom['aroil']; ?>">
    					 		<input type="hidden" name="fenil" value="<?php  echo $pom['fenil']; ?>">
    					 		<input type="hidden" name="takrin" value="<?php  echo $pom['takrin']; ?>">
                				<input type="hidden" name="linker" value="<?php  echo $pom['linker']; ?>">
                				<input type="hidden" name="kratakOpisSinteze" value="<?php echo $pom['kratakOpisSinteze'] ?>">
                				<input type="hidden" name="slikaStruktura" value="<?php echo $pom['slikaStruktura'] ?>">
								<a title="Sifra jedinjenja" data-content="Azuriraj <?php echo $pom['sifraJedinjenje']?>"data-toggle="popover" data-placement="top" data-trigger="hover">
									<button class="btn btn-outline-secondary" type="submit" name="page" value="azuriranjeAFLT"><?php echo $pom['sifraJedinjenje']?></button>
								</a>
						</form>
					</th>

					<th><?php echo $pom['aroil']?></th>
					<th><?php echo $pom['fenil']?></th>
					<th><?php echo $pom['linker']?></th>
					<th><?php echo $pom['takrin']?></th>
					<!-- Provera prinosa i dodeljjivanje pozadinske boje -->
    						<?php if ($pom['prinos']<10 ) { 
    							echo "<th>".$pom['prinos']."</th>";
    						 }elseif ($pom['prinos']>=10 and $pom['prinos']<30 ) { 
    							echo '<th style="background-color: LightGray;">'.$pom['prinos'].'</th>';
    						 }elseif ($pom['prinos']>=30 and $pom['prinos']<50) { 
    							echo '<th style="background-color: #FF7A75;">'.$pom['prinos'].'</th>';
    						 }elseif ($pom['prinos']>=50 and $pom['prinos']<70  ) { 
    							echo '<th style="background-color: #FFAF33;">'.$pom['prinos'].'</th>';
    						 }elseif ($pom['prinos']>=70 ) {
    							echo '<th style="background-color: #66ff66;">'.$pom['prinos'].'</th>';
    						 } ?>
						
					<th><?php 	?></th>
				</tr>
			<?php }//} ?>	
			</tbody>
</div>

		</table>
<code>	
	<?php
    if (isset($msg)) {
        echo $msg;
    }
    $poruka = isset($_POST["msg"]) ? $_POST["msg"] : "";
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