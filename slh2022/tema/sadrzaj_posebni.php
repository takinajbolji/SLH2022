<?php
/*
 * @name zaglavlje posebnih strana
 * @author branko
 * @date   01.08.2022
 * @version 02
 * 
 * dodavanje linka za pocetnu stranu
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
        
    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
    $NMR = isset($_POST['NMR'])?$_POST['NMR']:"";
    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
    $dugme = isset($_POST['dugme'])?$_POST['dugme']:"";
    $vrednostNMR = isset($_POST['vrednostNMR'])?$_POST['vrednostNMR']:"";
?>


<!-- navigaciona traka -->
	

<nav class="navbar fixed-top"  style="background-color: #e5e5e5;" > 
	     
	   
			<?php 
	  		/* 
	  		 * provera statusa ulogovane osobe, u slucaju admin statusa 
	  		 * ima pravo dodavanja jedinjenja, azuriranje i brisanje, 
	  		 * 
	  		*/
	  		if($ulogovan['idstatusosobe'] <= 2){
	 
	  		?>
	  	
<nav>
		<menu>
			<menuitem>
        		<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                    <button type="submit" class="btn btn-outline-primary" style="background-color:#a4d2ff; border-color:none;" name="page" value="pocetna">POČETNA</button>		    	
                </form>	
            </menuitem>
			<menuitem id="demo1">
				<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                	    	<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" style="background-color:#EFEF01; border-color:none;" >KORISNICI</button>	
                </form>	    	
				<menu>
					<menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                	    	<button class="btn btn-outline-secondary"   type="submit" name="page" value="licaUradu">Korisnici u radu</button>
                        </form>
                    </menuitem>
                    <menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                	    	<button class="btn btn-outline-secondary"  type="submit" name="page" value="noviKorisnik">dodavanje korisnika</button>
                        </form>
                    </menuitem>
            	</menu>
			</menuitem>
			
			<menuitem id="demo1">
				<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                  	<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" style="background-color:#00E000;">JEDINJENJA</button>
                </form>	    	
				<menu>
					<menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
	      					<button class="btn btn-outline-secondary"  type="submit" name="page" value="jedinjenja">Sva Jedinjenja </button>
    	        		</form>
                    </menuitem>
                    <menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                        	 <input type="hidden" name="vrednostNMR" value="<?php echo $uradjenNMR==0; ?>">
                           	 <button type="submit" class="btn btn-outline-secondary" name="page" value="jedinjenjaBezNMR">Jedinjenja bez NMR-a</button>		    	
                        </form> 
                    </menuitem>
              
               <menuitem>
                  <form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                        <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" type="button">Jedinjenja sa NMR-om</button>
                  </form>                          	    		
                  <menu>
                     <menuitem>
                     	<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                            <input type="hidden" name="NMR" value="<?php echo $NMR=1; ?>">
                            <button class="btn btn-outline-secondary" type="submit" name="page" value="ListaJedinjenjaDobarNMRNaslov" >Dobar NMR</button>
                        </form>
                     </menuitem>
                     <menuitem>
                     	<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                     		<input type="hidden" name="NMR" value="<?php echo $NMR=2; ?>">
                     		<button class="btn btn-outline-secondary"  type="submit" name="page" value="ListaJedinjenjaDobarNMRNaslov" >Ponoviti NMR</button>
                        </form>
                     </menuitem>
                     <menuitem>
                     	<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                            <input type="hidden" name="NMR" value="<?php echo $NMR=3; ?>">
                            <button class="btn btn-outline-secondary"  type="submit" name="page" value="ListaJedinjenjaDobarNMRNaslov" >Loš NMR</button>
                        </form>
                     </menuitem>
                     <menuitem>
                     	<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                            <input type="hidden" name="NMR" value="<?php echo $NMR=5; ?>">
                            <button class="btn btn-outline-secondary"  type="submit" name="page" value="ListaJedinjenjaDobarNMRNaslov" >Čeka rezultate</button>
                        </form> 
                     </menuitem>
                  </menu>  
               </menuitem>
					
				</menu>
			</menuitem>
			<menuitem>
        		<form class="form-control-file" action="../upravljanje/routes.php" method="post" >	      				
                   	<button type="submit" class="btn btn-outline-primary " style="background-color:#124ACC; border-color:none;" name="page" value="dodajNovoJedinjenje">NOVO JEDINJENJE</button>
                </form>	
            </menuitem>
			<menuitem id="demo1">
				<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
             		<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" style="background-color:#FFAA00;" >Statistika</button>	
                </form>	    	
				<menu>
					<menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                	    	<button class="btn btn-outline-secondary" type="submit" name="page" value="statistika" >Po prinosu(rastuce)</button>
                        </form>
                    </menuitem>
                    <menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                	    	<input type="hidden" name="dugme" value="<?php echo $dugme=2; ?>">
                        	<button class="btn btn-outline-secondary"  type="submit" name="page" value="statistika" >Po prinosu(opadajuce)</button>
                       </form>
                    </menuitem>
                    <menuitem>
						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
                    		<input type="hidden" name="dugme" value="<?php echo $dugme=3; ?>">
                    		<button class="btn btn-outline-secondary"  type="submit" name="page" value="statistika" >Po IC50 (rastuce)</button>
                        </form>
                    </menuitem>
            	</menu>
			</menuitem>
        	
		</menu>
	</nav>


		   
			  <?php }elseif ($ulogovan['idstatusosobe'] >2 and $ulogovan['idstatusosobe'] <= 5 ){
			  	 	
			  	 	/* Saradnik ima pravo azuriranje jedinjenja
			  		 * bez prava otvaranja novog i menjanja dela zaglavlja projekta (naziv, struktura jedinjenja
			  		 * odgovorno lice za jedinjenja.
			  		 * Spoljni saradnik slicno saradniku
			  		 * Gost ima pravo samo da pregleda osnovne elemente jedinjenja
			  		 */
			  ?>
			  		<div class="btn-group">
	      				<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
    	      				<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" style="background-color:#FFAF33; border-color:none;">Jedinjenja</button>
    	      					<div class="dropdown-menu">
    	      						<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
        	      						<button type="submit" class="btn btn-outline-secondary" style="border-color:#f8f9fa;" name="page" value="jedinjenja">sa NMR-om</button>		    	
            	      				</form>
        	      					<form class="form-control-file" action="../upravljanje/routes.php" method="post" >
        	      						<input type="hidden" name="uradjenNMR" value="<?php echo $uradjenNMR=0; ?>">
            	    					<button type="submit" class="btn btn-outline-secondary" style="border-color:#f8f9fa;" name="page" value="jedinjenja">bez NMR-a</button>		    	
            	      				</form>
            	      				
            	      				 
            	      			</div>
            	      	</form>
	      				</div>
			  
			  	<?php }elseif ($ulogovan['idstatusosobe'] > 5){?>
				  	
				  	<div class="btn-group">
	      				<button type="button" class="btn btn-outline-primary " data-toggle="dropdown">Jedinjenja</button>
    	      				<div class="dropdown-menu">
    	        				<a class="dropdown-item" href="../upravljanje/routes.php?page=SvaJedinjenjaNaslovGost">Jedinjenja - Sva</a>
    	        				
    	        			</div>
	    			</div>
				 
			  <?php 	}?>
			
  			   
 

</nav>


 <?php 	}?>




		
