
<?php
/*
 *  @name Scientists little helper - azuriranje NMR i unos spektara
 *  @author Branko Vujatovic
 *  @date   05.11.2021
 *  @version 01
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
   
    
    $msg=isset($msg)?$msg:"";
    $errors = isset($errors)?$errors:array();
    $NMR = isset($_POST['NMR'])?$_POST['NMR']:"";
    
    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
    $jedinjenja = isset($jedinjenja)?$jedinjenja:array();
    $azuriranje_nmr = isset($azuriranje_nmr)?$azuriranje_nmr:array();
    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
    
    $dao = new DAO();
    $pregledNMR =$dao->selectNmrPregledSifraIdJedinjenje($idjedinjenje);
    
    //$statusNMR = $pregledNMR['statusNMR'];
    
    $karakterizacija1HNMR =  $pregledNMR['karakterizacija1HNMR'];
    $slikaSpektra1HNMR =   $pregledNMR['slikaSpektra1HNMR'];
    $opisSpektra1HNMR =   $pregledNMR['opisSpektra1HNMR'];
    $statusSpektra1HNMR =  $pregledNMR['statusSpektra1HNMR'];
   
    $karakterizacija13CNMR =  $pregledNMR['karakterizacija13CNMR'];
    $slikaSpektra13CNMR =   $pregledNMR['slikaSpektra13CNMR'];
    $opisSpektra13CNMR =   $pregledNMR['opisSpektra13CNMR'];
    $statusSpektra13CNMR =  $pregledNMR['statusSpektra13CNMR'];
   
    
    ?>
<!DOCTYPE html>
<html lang="en, sr, el">

<head>
		<title>SLH - Azuriranje NMR</title>
		<?php include '../tema/head.php';?>
		
	
<body>
<?php include '../tema/sadrzaj_posebni.php';?>
<br /><br /><br /><br>
<div class="naslov-text">
  	<h3>- Azuriranje NMR -</h3>
</div>
<div class="main"> 
<div class="wrapper container bg-faded text-left">  	
<!-- osnovni podaci projekta za azuriranje --> 
<form class="form-signin" action="../upravljanje/routes.php" method="post" >
		Sifra NMR:
		<input class="form-control" id="ex2" type="text" name="sifraNMR" placeholder="sifra NMR" value="<?php echo $sifraNMR?>">
		<br>
		
		Opis NMR:  
		<input class="form-control" id="ex2" type="text" name="opisNMR" placeholder="opis NMR" value="<?php echo $opisNMR ?>">
		<br>
				
		Status NMR:  
		<select class="form-control" id="ex2" name="statusNMR" placeholder="status NMR" value="<?php echo $statusNMR ?>">
			
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
			<input class="form-control" id="ex2" type="text" name="serijaNMR" placeholder="serija NMR" value='<?php echo $serijaNMR ?>'>
			
        	<br>
				
             <input type="hidden" name="idjedinjenje" value="<?php  echo $idjedinjenje; ?>">
             <input type="hidden" name="idosoba" value="<?php  echo $idosoba ?>">
             <input type="hidden" name="idnmr" value="<?php echo $idnmr ?>">
             <button class="btn btn-outline-primary" type="submit" name="page" value="IzmeniNMR">Azuriraj</button>
      		 
      		 <input type="hidden" name="idjedinjenje" value="<?php  echo $idjedinjenje; ?>">
             <input type="hidden" name="slikaStruktura" value="<?php echo $slikaStruktura; ?>">           
			 <input type="hidden" name="idosoba" value="<?php  echo $idosoba ?>">
             <input type="hidden" name="idnmr" value="<?php echo $idnmr ?>">
			 <input type="hidden" name="sifraNMR" value="<?php echo $sifraNMR ?>">
			 <input type="hidden" name="opisSpektra1HNMR" value="<?php echo $opisSpektra1HNMR; ?>">
			 <input type="hidden" name="slikaSpektra1HNMR" value="<?php echo $slikaSpektra1HNMR; ?>">
			 <input type="hidden" name="statusSpektra1HNMR" value="<?php  echo $statusSpektra1HNMR; ?>">
             <input type="hidden" name="karakterizacija1HNMR" value="<?php  echo $karakterizacija1HNMR ?>">
             <button class="btn btn-outline-primary" type="submit" name="page" value="1H_NMR">1HNMR</button>
			 
      		 <input type="hidden" name="idjedinjenje" value="<?php  echo $idjedinjenje; ?>">
             <input type="hidden" name="slikaStruktura" value="<?php echo $slikaStruktura; ?>">           
			 <input type="hidden" name="idosoba" value="<?php  echo $idosoba ?>">
             <input type="hidden" name="idnmr" value="<?php echo $idnmr ?>">
			 <input type="hidden" name="sifraNMR" value="<?php echo $sifraNMR ?>">
			 <input type="hidden" name="opisSpektra13CNMR" value="<?php echo $opisSpektra13CNMR; ?>">
			 <input type="hidden" name="slikaSpektra13CNMR" value="<?php echo $slikaSpektra13CNMR; ?>">
			 <input type="hidden" name="statusSpektra13CNMR" value="<?php  echo $statusSpektra13CNMR; ?>">
             <input type="hidden" name="karakterizacija13CNMR" value="<?php  echo $karakterizacija13CNMR ?>">
             <button class="btn btn-outline-primary" type="submit" name="page" value="13C_NMR">13CNMR</button>
			 
			
      		 <button class="btn btn-outline-dark" type="submit" name="page" value="ListaJedinjenjaNaslov">Nazad</button>
		
			 <!-- Model za proveru sigurnosti radnje brisanja -->
                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Obrisi</button>
                
                  <!-- Model za potvrdu brisanja -->
                  <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                      
                        <!--Zaglavlje modela -->
                        <div class="modal-header">
                          <h4 class="modal-title">Brisanje NMR - <?php echo $sifraNMR ?></h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Telo modela -->
                        <div class="modal-body">
                          Da li ste sigurni da zelite da obrisete NMR 
                        </div>
                        
                        <!-- Podnozje modela --><!-- Podnozje modela -->
               
                        <div class="modal-footer">
                          <button type="button" class="close" data-dismiss="modal">Odustani</button>
                          <input type="hidden" name="idjedinjenje" value="<?php  echo $idjedinjenje; ?>">
           				  <input type="hidden" name="idnmr" value="<?php echo $idnmr ?>">
                          <button type="submit" class="btn btn-danger" name="page" value="BrisanjeNMR">Obrisi</button>
                        </div>
                        
                      </div>
                    </div>
                  </div>
			 
			
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

	
<script>
	$(document).ready(function(){
  	$('[data-toggle="popover"]').popover();   
	});
</script>			

<?php include '../tema/footer.php' ?>
			
</body>
</html>	