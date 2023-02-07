<?php
/*
 @name admin meni
 @author branko
 @date   01.08.2022
 @version 01
 
 admin navigacioni meni */

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
    
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
    $dugme = isset($_POST['dugme'])?$_POST['dugme']:"";
    
    ?>
<!-- navigaciona traka -->
	
<!--  meni -->
 
      <nav class="navbar navbar-expand-sm bg-light fixed-top"  style="background-color: #e5e5e5;" > 
		
  	 
  		    <ul class="navbar-nav "> 
    	    	<li class="nav-item">
      		   		 <a class="nav-link" >Dobro došli: <?php echo $ulogovan['ime']." ".$ulogovan['prezime']?></a>
	    	    </li>
	       </ul>		 
	      
	   
			<?php 
	  		/* 
	  		 * provera statusa ulogovane osobe, u slucaju admin statusa 
	  		 * ima pravo dodavanja jedinjenja, azuriranje i brisanje, 
	  		 * 
	  		*/
	  		if($ulogovan['idstatusosobe'] <= 2){
	 
	  		?> 
	  		
	  			 <div class="container">
	  			 	<div class="btn-group">	
    			    	<form class="form-control-file" action="../upravljanje/routes.php" method="post" >	
    	      				<button type="submit" class="btn btn-outline-primary" style="background-color:LightGray;" name="page" value="licaUradu">Lica u radu</button>
    	      			</form>
	      				      				
	      				<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
	      				
	    					<button type="submit" class="btn btn-outline-primary" style="background-color:#FFAF33;" name="page" value="jedinjenja">Jedinjenja</button>		    	
	      				</form>
	      				
    	      			<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
	    					<button class="btn btn-outline-secondary"  type="submit" name="page" value="statistika" >Pregled</button>
            	      	</form>
	      					      			
    	      				
    	        	</div>
	    		
			   
			  <?php }elseif ($ulogovan['idstatusosobe'] >2 and $ulogovan['idstatusosobe'] <= 5 ){
			  	 	
			  	 	/* Saradnik ima pravo azuriranje jedinjenja
			  		 * bez prava otvaranja novog i menjanja dela zaglavlja projekta (naziv, struktura jedinjenja
			  		 * odgovorno lice za jedinjenja.
			  		 * Spoljni saradnik slicno saradniku
			  		 * Gost ima pravo samo da pregleda osnovne elemente jedinjenja
			  		 */
			  ?>
			  		<div class="btn-group">
	      				<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">Jedinjenja</button>
    	      				<div class="dropdown-menu">
    	        				<a class="dropdown-item" href="../upravljanje/routes.php?page=SvaJedinjenjaNaslovSaradnik">Jedinjenja</a>
    	        			</div>
	    			</div>
			  
			  	<?php }elseif ($ulogovan['idstatusosobe'] > 5){?>
				  	
				  	<div class="btn-group">
	      				<button type="button" class="btn btn-outline-primary " data-toggle="dropdown">Jedinjenja</button>
    	      				<div class="dropdown-menu">
    	        				<a class="dropdown-item" href="../upravljanje/routes.php?page=SvaJedinjenjaNaslovGost">Jedinjenja - Sva</a>
    	        				
    	        			</div>
	    			</div>
			 </div>	 
			  <?php 	}?>
			 
			  <a href="../upravljanje/routes.php?page=logout"><span style='font-size:20px;'>&#10060;</span></a>
  			   
 </nav>

<br /><br />


 <?php 	}?>




		
