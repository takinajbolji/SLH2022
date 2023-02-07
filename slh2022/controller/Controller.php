<?php
/*
 * Controller - SLH
 * @author branko
 * @date   11.05.2021.
 * @version 01
 * 
 * logika izvrsenja radnji na stranicama
 * 
 */

require_once '../model/DAO.php';

class Controller{
	/*
	 * PRIJAVLJIVANJE, ODJAVLJIVANJE, PROMENA LOZINKE, REGISTRACIJA
	*/
	
	// prijavljivanje 
	public function login(){
	    //$msg = isset($_POST['msg'])?$_POST['msg']:"";
	    $msg = isset($msg)?$msg:"";
	    
		$username=isset($_POST['username'])?$_POST['username']:"";
		$password=isset($_POST['password'])?$_POST['password']:"";
		
		$ulogovan=isset($ulogovan)?$ulogovan:array();		
			
			if(!empty($username)&&!empty($password)){
						$password = md5($password);
						$dao=new DAO();
						$osoba=$dao->selectOsobaByUsernameAndPassword($username, $password);
						if($osoba){	
							// logovanje proslo
							session_start();
							$_SESSION['ulogovan']=serialize($osoba);
						   
							/* 
							 * pakuje celu osobu sa svim njenim podacima u jednu sesiju
							 * dodatno da bi proverili nivo pristupa ulogovanog sa promenljivom konsum
							 * 							  
							 */
						
							$ulogovan=unserialize($_SESSION['ulogovan']);
							$status=$ulogovan['idstatusosobe'];
	   			   			switch ($status){
	   			   				case 1:
	   			   					include '../korisnik/adminpanel.php';
	   			   					break;
	   			   				case 2:					
									include '../korisnik/adminpanel.php';
									break;
				   				case 3:
				   					include '../jedinjenja/svajedinjenjaSaradnik.php';
				   					break;	   			
				   				case 4:
				   					include '../jedinjenja/svajedinjenjaGost.php';
				   					break;	
				   				case 5:
				   					include '../jedinjenja/svajedinjenjaGost.php';
				   					break;
				   				case 6:
				   					include '../jedinjenja/svajedinjenjaGost.php';
				   					break;
				   				}	
							
							} else{
								$msg='Pogresan korisnicko ime ili password ili niste registrovani.';
								include '../login/index.php';
								}
				}else{
					$msg='Morate popuniti sva polja.';
					include '../login/index.php';
					}
	}
	
	//odjavljivanje
	public function logout(){
	    session_start();
	   
	    $dao=new DAO();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    $idosoba=$ulogovan['idosoba'];
	    	      
	    session_unset();
	    session_destroy();
	    //include '../login/index.php';
	    header('Location:./login/index.php');
	    
	}
	
	//PROMENA LOZINKE
	/* promenu  lozinke vrsimo proverom korisnickog imena i 
	 * email-a, ukoliko se podudaraju korisniku se menja lozinka i 
	 * moze nakon uspesne promene ponovo da se uloguje u aplikaciju
	 * kao indeks promene koristimo korisnicko ime, posto ne dozvoljavamo 
	 * unos istog korisnickog imena.
	 */
	
	/*public function novaLozinkaKorisnika(){
	    
	    include '../login/promenalozinke.php';
	    
	}*/
	public function promenaLozinkeKorisnika(){
		
	    $username=isset($_POST['username'])?$_POST['username']:"";
	    $password=isset($_POST['password'])?$_POST['password']:"";
	    $password1=isset($_POST['password1'])?$_POST['password1']:"";
	    	    
	    $email=isset($_POST['email'])?$_POST['email']:"";
	    
	    $korisnik=isset($korisnik)?$korisnik:array();
	    
	    $errors = isset($errors)?$errors:array();
	    
	    $dao=new DAO();
	    $korisnik=$dao->selectOsobaProveraUsername($username);
	    
	    if (empty($username)) {
	        $errors['useraname'] ='Morate uneti Vase korisnicko ime.';
	    } else {
	        if ($korisnik['username'] != $username) {
	            $errors['username']= 'Korisnicko ime ne postoji';
	        
	        }
	    }
	    
	    if (!empty($password)&&!empty($password1)) {
	            if($password!==$password1){
	                $errors['password1'] ='Dve lozinke nisu identicne.';
	            }else{
	                if(strlen($password)<6){
	                    $errors['password'] = 'Lozinka mora da ima vise od 5 znakova.';
	                }
	            }
	        }else {
	            
	            $errors['password'] ='Unesite Vasu lozinku.';
	        }
	      
	       
	       
	        if (empty($email)) {
	            $errors['email'] ='Morate uneti Vas e-mail.';
	            
	        }else{
	            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
	                $errors['email'] ='E-mail nije validan!';
	            }
	        }
	    	
  		
  		if (count($errors)== 0)	{
  			
  			$password=md5($password1);
  			
  			$dao=new DAO();
  			$dao->updateOsobaByPassword($password, $username);
  			
  			$msg="Uspesno ste promenili vasu lozinku!";
  			include '../login/index.php';
  		} else {
  			$msg="Morate popuniti sva polja korektno.";
  			include '../korisnik/promenalozinke.php';
  		}	
		
	}
		
	//REGISTRACIJA KORISNIKA
	/* Korisnik unosi korisnicko ime koje je razlicito od trenutnih
	 * u bazi, lozinka se potvrdjuj drugim unosom i mora biti duza od 
	 * 5 znakova, nakon cega se kriptuje i tako se unosi u bazu.
	 */
	public function registracijaKorisnika(){
		
	    $username=isset($_POST['username'])?$_POST['username']:"";
		$password=isset($_POST['password'])?$_POST['password']:"";
		$password1=isset($_POST['password1'])?$_POST['password1']:"";
		
		$ime=isset($_POST['ime'])?$_POST['ime']:"";
		$prezime=isset($_POST['prezime'])?$_POST['prezime']:"";	   	
		$email=isset($_POST['email'])?$_POST['email']:"";
		
		$errors = isset($errors)?$errors:array();
				
		$dao=new DAO();
  		$korisnik=$dao->selectOsobaProveraUsername($username);
		
		if ($korisnik['username'] === $username) {
			$errors['username']= 'Korisnicko ime vec postoji';
		} else {
				
			if (empty($username)) {
				$errors['useraname'] ='Morate uneti Vase korisnicko ime.';
			}
			if (!empty($password)&&!empty($password1)) {
				if($password!==$password1){
					$errors['password1'] ='Dve lozinke nisu identicne.';
				}else{
					if(strlen($password)<6){
						$errors['password'] = 'Lozinka mora da ima vise od 5 znakova.';
					}			
				}
			}else {
				
				$errors['password'] ='Unesite Vasu lozinku.';
			}	
			if (empty($ime)) {
				$errors['ime'] ='Morate uneti Vase ime.';
			}
			if (empty($prezime)) {
				$errors['prezime'] ='Morate uneti Vase prezime.';
			}
			if (empty($email)) {
				$errors['email'] ='Morate uneti Vas e-mail.';
			
			}else{
			    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			       $errors['email'] ='E-mail nije validan!'; 
			    }
			}
		}	
			
		if (count($errors)== 0)	{
			
			$password=md5($password1);
			$dao=new DAO();	
			$dao->insertOsoba($username, $password, $ime, $prezime, $email);
		
			$msg = "Uspesno ste se registrovali. Mozete da se prijavite u SLH!";
			include '../login/index.php';
		} else {
			$msg = "Morate popuniti sva polja korektno.";
		    include '../korisnik/registracija.php';	
		}		
		
	}
	
	//ADMIN METODE OSOBE
	
	
	//DODAVANJE NOVOG KORISNIKA
	/*
	 * Dodavanje novog korisnika vrsi admin, a sam korisnik
	 * nakon unosa duzan da ode na stranu promeni lozinku i da
	 * dodeli lozinku koju ce on znati.
	 */
	
	public function dodajNovogKorisnika(){
	    
	    include '../korisnik/dodajKorisnika.php';
	    
	}
	
	public function dodajKorisnika(){
	    
	    $username = isset($_POST['username'])?$_POST['username']:"";
	    $ime = isset($_POST['ime'])?$_POST['ime']:"";
	    $prezime = isset($_POST['prezime'])?$_POST['prezime']:"";
	    $email = isset($_POST['email'])?$_POST['email']:"";
	    $mobilni = isset($_POST['mobilni'])?$_POST['mobilni']:"";
	    $idstatusosobe = isset($_POST['idstatusosobe'])?$_POST['idstatusosobe']:"";
		
		$errors = isset($errors)?$errors:array();
			
		$dao=new DAO();
  		$korisnik=$dao->selectOsobaProveraUsername($username);
		
  		
  		 
  		if ($korisnik['username'] == $username) {
  			$errors['username']= 'Korisnicko ime vec postoji';  //Provera da li postoji korisnicko ime
		} else {
			if (empty($username)) {
				$errors['username'] ='Morate uneti Vase korisnicko ime.';
			}
		}
			
		if (empty($ime)) {
			$errors['ime'] ='Morate uneti Vase ime.';
		}
		
		if (empty($prezime)) {
			$errors['prezime'] ='Morate uneti Vase prezime.';
		}
		
		if (empty($email)) {
			
			$errors['email'] ='Morate uneti Vas e-mail.';
			
		}else{
		    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		        $errors['email'] ='E-mail nije validan!';
		    }
		}
		
		if (empty($mobilni)) {
			$errors['mobilni'] ='Morate uneti broj mobilnog.';
		}
					
		if (count($errors)== 0)	{
		   
		    $password=md5('Password');
		    //var_dump($username,$password,$ime,$prezime,$email,$idstatusosobe);
		    $dao = new DAO();	
			$dao -> insertDodajKorsnika($username, $password, $ime, $prezime, $email, $mobilni, $idstatusosobe);
			
			
			$msg="Uspesno ste dodali korisnika ".$ime." !";
			include '../korisnik/pregledKorisnika.php';
			
		} else {
			$msg="Morate popuniti sva polja korektno.";
		    include '../korisnik/dodajKorisnika.php';	
		}		
	}
		
	//PRIKAZ SVIH KORISNIKA
	public function pregledKorisnika(){
		
		$dao=new DAO();
  		$listakorisnika=$dao->selectOsoba();
		include '../korisnik/pregledKorisnika.php';
	}
		
	// PRIKAZ OSOBE KOJOJ SE MENJAJU PODACI 
	public function showEditOsoba() {
	    $osoba=isset($osoba)?$osoba:array();
	    
		$idosoba=isset($_POST['idosoba'])?$_POST['idosoba']:"";
		
		if (!empty($idosoba)) {
			$dao = new DAO();
			$osoba = $dao->selectOsobaByIdosoba($idosoba);
			include '../korisnik/showeditosoba.php';
		} else {
			$dao = new DAO();
			$listakorisnika=$dao->selectOsoba();
			
			$msg = "Nije pokupljen ID od korisnika.";
			include '../korisnik/pregledKorisnika.php';
		}
	}

	//PROMENA PODATAKA OSOBE 
	public function editOsoba() {
		$osoba=isset($osoba)?$osoba:array();
		$username=isset($_POST['username'])?$_POST['username']:"";
		$ime=isset($_POST['ime'])?$_POST['ime']:"";
		$prezime=isset($_POST['prezime'])?$_POST['prezime']:"";
		$email=isset($_POST['email'])?$_POST['email']:"";
		$mobilni=isset($_POST['mobilni'])?$_POST['mobilni']:"";
		$idstatusosobe= isset($_POST['idstatusosobe'])?$_POST['idstatusosobe']:"";
			
		$idosoba=isset($_POST['idosoba'])?$_POST['idosoba']:"";
		$errors =array();
		
		if (empty($username)) {
			$errors['useraname'] ='Morate uneti Vase korisnicko ime.';
		}
		if (empty($ime)) {
			$errors['ime'] ='Morate uneti Vase ime.';
		}
		if (empty($prezime)) {
			$errors['prezime'] ='Morate uneti Vase prezime.';
		}
		if (empty($email)) {
			$errors['email'] ='Morate uneti Vas e-mail.';
		}
		if (empty($mobilni)) {
			$errors['mobilni'] ='Morate uneti broj mobilnog.';
		}
		if (empty($idstatusosobe)) {
			$errors['idstatusosobe'] ='Morate uneti status korisnika.';
		}
		
		if (count($errors)== 0)	{
			
			$dao = new DAO();
			
			$dao->updateOsobaByIdOsoba($username, $ime, $prezime, $email, $mobilni, $idstatusosobe, $idosoba);
			
			$listakorisnika=$dao->selectOsoba();
			
			$msg="Uspesno ste izmenili podatke za ".$ime." ".$prezime;
			include '../korisnik/pregledKorisnika.php';
			
		} else {
			
			$msg="Morate popuniti sva polja korektno.";
			include '../korisnik/showeditosoba.php';
		}	
		
	}
	
	/*    
	 *    MORA SE DORADITI RESTRIKCIJA BRISANJA UKOLIKO SE OBRISE OSOBA ZA SADA SE BRISU I SVI PODACI KOJE JE ONA UNELA (ZA JEDINJENJA)
	 *    
	 *    BRISANJE PODATAKA KORISNIKA
	 *    potrebno dodati restrikciju brisanja ukoliko
	 *    korisnik je bio ucesnik projekta u bilo kom svojstvu ne sme se dozvoliti brisanje samo promena statusa korisnika
	 */
	
	public function obrisiOsobu(){
	    $idosoba=isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    
	    if (!empty($idosoba)){
	        
	        $dao = new DAO();
	        $dao->obrisiOsobu($idosoba);
	        $listakorisnika=$dao->selectOsoba();
	        
	    }else{
	        $msg ='Nije pokupljen ID osobe!';
	        
	    }
	    $msg = "Uspesno ste obrisali korisnika! ";
	    include '../korisnik/pregledKorisnika.php';
	    
	}
	
	/************************************************
	 * 
	 *  POCETNA ADMIN STRANICA
	 *  
	 * 
	 ************************************************/
	public function pocetna(){
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $listakorisnika = isset($listakorisnika)?$listakorisnika:array();
	    
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../korisnik/adminpanel.php';
	}
	
	/*
	 * METODE ZA RAD STATISTIKA
	 *
	 */
	
	public function statistika(){
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $dugme = isset($_POST['dugme'])?$_POST['dugme']:"";
	    
	    include '../jedinjenja/statistika.php';
	}
	
	public function azuriranjeAFLT() {
	    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
	    
	    include '../jedinjenja/azuriranjeAroilFenilLinkerTakrin.php';
	}
	
	public function azurirajJedinjenjeAFLT(){
	    
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
	    
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    
	    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
	    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
	    $linker = isset($_POST['linker'])?$_POST['linker']:"";
	    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
	    
	    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
	    
	    session_start();
	    
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    
	    if (!empty($idjedinjenje)){
	        
	        $dao = new DAO();
	        $dao->updateJedinjenjeAroilFenilLinkerTakrin($aroil, $fenil, $linker, $takrin, $idjedinjenje);
	        $msg = 'Uspesno ste izmenili jedinjenje, sifra jedinjenja = '.$sifraJedinjenje;
	        include '../jedinjenja/statistika.php';
	        
	    }else{
	        
	        $msg = 'Nije pokupljen ID jedinjenja';
	        include '../jedinjenja/statistika.php';
	    }
	    
	    
	}
	
	/*
	 * METODE ZA RAD SA JEDINJENJIMA
	 *  
	 */
	
	/*
	 * PRIKAZ JEDINJENJA prema NMR
	 */
	
	public function listaJedinjenja(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
			   		
  		include '../jedinjenja/listajedinjenjaNMR.php';
	}
	
	/*
	 * PRIKAZ JEDINJENJA prema statusu NMR
	 */
	
	public function listaJedinjenjaDobarNMR(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $NMR = isset($_POST['NMR'])?$_POST['NMR']:"";
	  
	    include '../jedinjenja/listajedinjenjaNMR.php';
	}
	
	/*
	 * PRIKAZ JEDINJENJA sva
	 */
	public function jedinjenja(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
	    $vrednostNMR = isset($_POST['vrednostNMR'])?$_POST['vrednostNMR']:"";
	   
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../jedinjenja/svajedinjenja.php';
	}
	
	public function jedinjenjaBezNMR(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
	   
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../jedinjenja/svajedinjenjaBezNMR.php';
	}
	
	public function svaJedinjenja(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    $uradjenNMR = isset($_POST['uradjenNMR'])?$_POST['uradjenNMR']:"";
	    $stausulogovan = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $sifraNMR = isset($sifraNMR)?$sifraNMR:"";
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
	   
	    $idnmr = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
	    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
	    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
	    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
	    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    
	    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
	    
	    $dao = new DAO();
	    $listajedinjenja = $dao->selectJedinjenje();
	    	        
	    include '../jedinjenja/svajedinjenja.php';
	}
	
	/*
	 * PRIKAZ JEDINJENJA sva za Gosta
	 */
	public function svaJedinjenjaGost(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../jedinjenja/svajedinjenja.php';
	}
	
	/*
	 * PRIKAZ JEDINJENJA sva za Saradnik
	 */
	public function svaJedinjenjaSaradnik(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../jedinjenja/svajedinjenjaSaradnik.php';
	}
	
	/*
	 * DODAVANJE NOVOG JEDINJENJA
	 */
	
	public function dodajNovoJedinjenja(){
	    
	    include '../jedinjenja/novojedinjenje.php';
	
	}
	
	public function novoJedinjenje(){
	    
	    $datum = isset($_POST['datum'])?$_POST['datum']:"";
	    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
	    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
	    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
	    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
	    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
	    $linker = isset($_POST['linker'])?$_POST['linker']:"";
	    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    	    
	    session_start();
	    
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    $errors =array();
	    
	    	    
	    if (empty($sifraJedinjenje)) {
	        $errors['sifraJedinjenje'] ='Morate uneti sifru jedinjenja.';
	    }
	    	   	    	    	    	    
	    if (count($errors)== 0)	{
	        /*
	         * unos slike u bazu
	         * konekcija sa bazom
	         *
	         */
	       
	        $image = $_FILES['image']['name']; //odabir slike i ekstenzije iste
	        $target = "../projekat/slike/strukturaJedinjenja/" .basename($image); //putanja smestanja slike
	        
	        //$target_file = $target.basename($image); //putanja smestanja slike
	        //smestanje slike na zadatu lokacijuj
	        if (!empty($image)){ 
	            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)){
    	                
    	           $dao=new DAO();
    	           $dao->insertNovoJedinjenje($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $image, $idosoba);
    	           
    	           $msg="Uspesno ste dodali novo jedinjenje ";
    	           include '../jedinjenja/svajedinjenja.php';
    	        }
	        }else{
	            
	            $dao=new DAO();
	            $dao->insertNovoJedinjenjeNoImage($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $idosoba);
	             
	            $msg="Uspesno ste dodali novo jedinjenje ";
	            include '../jedinjenja/svajedinjenja.php';
	        }
	                  	        
	    } else {
	        
	        $msg="Morate popuniti sva polja korektno.";
	        include '../jedinjenja/novojedinjenje.php';
	    }	
	}
	
	/*
	 * Pregled pojedinacnog jedinjenja za zadati idjedinjenja
	 */
	
	public function AzuriranjeJedinjenja(){
	    
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    
	    
	    $datum = isset($_POST['datum'])?$_POST['datum']:"";
	    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
	    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
	    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
	    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
	    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
	    $linker = isset($_POST['linker'])?$_POST['linker']:"";
	    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
	   
	   
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $hrmsEsi = isset($_POST['hrmsEsi'])?$_POST['hrmsEsi']:"";
	    $kratakOpisSinteze = isset($_POST['kratakOpisSinteze'])?$_POST['kratakOpisSinteze']:"";
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    
	    
	    if (!empty($idjedinjenje)){
	        $dao = new DAO();
	        $jedinjenje = $dao->selectJedinjenjeIdjedinjenje($idjedinjenje);
	        
	        include '../jedinjenja/azuriranjeJedinjenja.php';
	        
	    }else{
	        $msg ='Nije pokupljen ID jedinjenja!';
	        include '../jedinjenja/svajedinjenja.php';
	    }
	    
	}
	
	
	/*
	 * Azuriranje jedinjenja
	 */
	
	
	public function azurirajJedinjenje(){
	    
	    $datum = isset($_POST['datum'])?$_POST['datum']:"";
	    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
	    $molarnaMasa = isset($_POST['molarnaMasa'])?$_POST['molarnaMasa']:"";
	    $prinos = isset($_POST['prinos'])?$_POST['prinos']:"";
	    $aroil = isset($_POST['aroil'])?$_POST['aroil']:"";
	    $fenil = isset($_POST['fenil'])?$_POST['fenil']:"";
	    $linker = isset($_POST['linker'])?$_POST['linker']:"";
	    $takrin = isset($_POST['takrin'])?$_POST['takrin']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $hrmsEsi = isset($_POST['hrmsEsi'])?$_POST['hrmsEsi']:"";
	    $kratakOpisSinteze = isset($_POST['kratakOpisSinteze'])?$_POST['kratakOpisSinteze']:"";
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    
	    $errors =isset($errors)?$errors:array();
	    $msg ='';
	    session_start();
	    
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	       
	    if (count($errors)== 0)	{
	        if (!empty($idjedinjenje)){	  
	            $image = $_FILES['image']['name']; //odabir slike i ekstenzije iste
	            $target = "../projekat/slike/strukturaJedinjenja/" .basename($image); //putanja smestanja slike
	            //smestanje slike na zadatu lokacijuj
	            
	            if (!empty($image)){ 
	                	            
	               if (move_uploaded_file($_FILES['image']['tmp_name'], $target)){
	                   $slikaStruktura = $image;
	                   
    	               $dao = new DAO();
    	               $dao->updateJedinjenjeIDjedinjenje($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $slikaStruktura, $hrmsEsi, $kratakOpisSinteze, $idjedinjenje);
    	            
    	               $msg = 'Uspesno ste izmenili jedinjenje, sifra jedinjenja = '.$sifraJedinjenje;
    	               include '../jedinjenja/svajedinjenja.php';
	               }
	               
	            }else {
	                       
	                $dao = new DAO();
	                $dao->updateJedinjenjeIDjedinjenje($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $slikaStruktura, $hrmsEsi, $kratakOpisSinteze, $idjedinjenje);
	                
	                $msg = 'Uspesno ste izmenili jedinjenje, sifra jedinjenja = '.$sifraJedinjenje;
	                include '../jedinjenja/svajedinjenja.php';
	            
	            }
	            
	        }else{
	            $msg = 'Nije pokupljen ID jedinjenja';
	            include '../jedinjenja/svajedinjenja.php';
	        }
	        
	    }else {
	        $msg="Morate popuniti sva polja korektno.";
	        include '../jedinjenja/azuriranjeJedinjenja.php';
	    }
	}
	
	/*
	 * Azuriranje jedinjenja-preciscavanje
	 */
	
	public function preciscavanje(){
	    
	    $idjedinjenje=isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $jedinjenje=isset($jedinjenje)?$jedinjenje:array();
	    
	    if (!empty($idjedinjenje)){
	        $dao = new DAO();
	        $jedinjenje = $dao->selectJedinjenjeIdjedinjenje($idjedinjenje);
	        
	        include '../jedinjenja/preciscavanje.php';
	        
	    }else{
	        $msg ='Nije pokupljen ID jedinjenja!';
	        include '../jedinjenja/svajedinjenja.php';
	    }
	    
	}
	
	
	/*
	 * Azuriraj jedinjenja-preciscavanje
	 */
	
	
	public function azurirajnjePreciscavanje(){
	    
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $sifraJedinjenje = isset($_POST['sifraJedinjenje'])?$_POST['sifraJedinjenje']:"";
	    $preciscavanje = isset($_POST['preciscavanje'])?$_POST['preciscavanje']:"";
	    $sistemTLC = isset($_POST['sistemTLC'])?$_POST['sistemTLC']:"";
	    $agregatnoStanje = isset($_POST['agregatnoStanje'])?$_POST['agregatnoStanje']:"";
	    $boja = isset($_POST['boja'])?$_POST['boja']:"";
	    $sumirano = isset($_POST['sumirano'])?$_POST['sumirano']:"";
	    $napomena = isset($_POST['napomena'])?$_POST['napomena']:"";
	    
	    $jedinjenje = isset($jedinjenje)?$jedinjenje:array();
	    
	    session_start();
	    
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    
	    if (!empty($idjedinjenje)){
	        
	        $dao = new DAO();
	        $dao->updateJedinjenjeIDjedinjenjePreciscavanje($preciscavanje, $sistemTLC, $agregatnoStanje, $boja, $sumirano, $napomena, $idjedinjenje);
	        $msg = 'Uspesno ste izmenili jedinjenje, sifra jedinjenja = '.$sifraJedinjenje;
	        include '../jedinjenja/svajedinjenja.php';
	        
	    }else{
	        
	        $msg = 'Nije pokupljen ID jedinjenja';
	        include '../jedinjenja/svajedinjenja.php';
	    }
	    
	    
	}
	
	
	/*
	 * BRISANJE JEDINJENJA
	 *
	 * NAPOMENA:brisanje greskom otvorenog jedinjenja moze samo admin ukoliko nisu uneti ostali podaci,
	 *          brisanje jedinjenja ima pravo samo vlasnik jedinjenjenja (lice koje je i unelo novo jedinjenjenje)
	 *          brisanjem jedinjenja brisu se svi podaci u vezi sa tim jedinjenjem
	 *          
	 */
	
	public function brisanjeJedinjenje(){
	    
	    $idjedinjenje=isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    
	    
	    if (!empty($idjedinjenje)){
	        
	        $dao = new DAO();
	        $jedinjenje = $dao ->selectJedinjenjeIdjedinjenje($idjedinjenje);
	        $uradjenNMR = $jedinjenje['uradjenNMR'];
	        
	        if($uradjenNMR == 0){
	           $dao = new DAO();
	           $dao->brisanjeJedinjenje($idjedinjenje);
	        
	           $msg = "Uspesno ste obrisali jedinjenje! ";
	         
	        }else{
	            $dao = new DAO();
	            $dao ->brisanjeJedinjenjeNMR($idjedinjenje);
	            
	            $msg = "Uspesno ste obrisali jedinjenje! ";
	         
	        }
	    }else{
	        
	        $msg ='Nije pokupljen ID jedinjenja!';
	        
	    }
	    
	    include '../jedinjenja/svajedinjenja.php';
	    
	}
	
	
	
	/*             N M R                           */
	
	/*
	 *  pregled NMR
	 *
	 */
	
	public function pregledNMR(){
	    
	    $idjedinjenje=isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $idnmr=isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
	    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
	    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $pregled_nmr=isset($pregled_nmr)? $pregled_nmr:array();
	   
	    $jedinjenja=isset($jedinjenja)?$jedinjenja:array();
	    
	    if (!empty($idjedinjenje)){
	        $dao = new DAO();
	        $pregled_nmr = $dao->selectNmrSifraIdJedinjenje($idjedinjenje);
	        
	        $dao = new DAO();
	        $jedinjenja = $dao->selectJedinjenjeIdjedinjenje($idjedinjenje);
	        
	        include '../element/spektriJedinjenja.php';
	        
	    }else{
	        $msg ='Nije pokupljen ID jedinjenja!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	    
	}
	
	/*
	 *
	 *  Dodaj NMR
	 *
	 */
	public function dodajNMR(){
	    
	    $listajedinjenja = isset($listajedinjenja)?$listajedinjenja:array();
	    
	    $dao=new DAO();
	    $listajedinjenja=$dao->selectJedinjenjeSva();
	    
	    include '../element/dodavanjeNMR.php';
	}
	
	
	/*
	 *
	 *  unos NMR
	 *
	 */
	
	public function unosNMR(){
	    
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
	    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
	    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
	    
	    $errors = isset($_POST['errors'])?$_POST['errors']:array();
	    
	    if (empty($sifraNMR)) {
	        $errors['sifraNMR'] ='Morate uneti sifru NMR.';
	    }
	    
	    if (empty($opisNMR)){
	        $errors['opisNMR'] = 'Morate uneti opis NMR-a!';
	    }
	    
	    session_start();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    	        
	    if (count($errors)== 0)	{
    	    if (!empty($idjedinjenje)){
    	       	            
    	            $dao = new DAO();
    	            $dao->insertNMR($sifraNMR, $opisNMR, $statusNMR, $serijaNMR, $idjedinjenje, $idosoba);
    	           
    	            $msg = 'Uspesno ste dodali novi NMR sifra = '.$sifraNMR.' za izabrano jedinjenje ';
    	            
    	            $uradjenNMR = 1;
    	            $dao = new DAO();
    	            $dao->updateJedinjenjeUradjenNMRidJedinjenje($uradjenNMR, $idjedinjenje);
    	            
    	            include '../jedinjenja/listajedinjenjaNMR.php';
    	            
    	    }else{
    	        $msg ='Nije pokupljen ID jedinjenja!';
    	        include '../jedinjenja/svajedinjenja.php';
    	    }
	    }else {
	        $msg="Morate popuniti sva polja korektno.";
	        include '../element/dodavanjeNMR.php';
	    }
	}
	
	/*
	 *
	 * Azuriranje NMR po id NMR
	 *
	 */
	public function azuriranjeNMR(){
	   
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	    $azuriranje_nmr = isset($azuriranje_nmr)?$azuriranje_nmr:array();
	    
	    $dao = new DAO();
	    $azuriranje_nmr = $dao->selectNmrPregledSifraIdJedinjenje($idjedinjenje);
	    
	    include '../element/azuriranjeNMR.php';
	   	    
	}
	
	/*
	 *
	 * Azuriraj NMR po id NMR
	 *
	 */
	public function azurirajNMR(){
	    
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $sifraNMR = isset($_POST['sifraNMR'])?$_POST['sifraNMR']:"";
	    $opisNMR = isset($_POST['opisNMR'])?$_POST['opisNMR']:"";
	    $statusNMR = isset($_POST['statusNMR'])?$_POST['statusNMR']:"";
	    $serijaNMR = isset($_POST['serijaNMR'])?$_POST['serijaNMR']:"";
	    
	    
	    if(!empty($idnmr)){
	        
	        
	        $dao = new DAO();
	        $dao ->updateNMRIDnmr($opisNMR, $statusNMR, $serijaNMR, $idnmr);
	        
	        $msg = 'Uspesno ste azurirali NMR sifra = '.$sifraNMR.' za izabrano jedinjenje ';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	        
	    }else{
	        
	        $msg ='Nije pokupljen ID NMR!';
	        include '../element/azuriranjeNMR.php';
	        
	    }
	        
	}
	
	/*
	 * 
	 *  brisanje NMR po idnmr
	 *
	 */
	
	public function brisanjeNMR(){
	    
	    $idnmr =isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $idjedinjenje =isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	   	    	    
	    if (!empty($idnmr)){
	        	                     
	            $dao = new DAO();
	            $dao->brisanjeNMRIDnmr($idnmr);
	            
	            $msg = 'Uspesno ste obrisali NMR';
	            
	            $uradjenNMR = 0;
	            $dao = new DAO();
	            $dao->updateJedinjenjeUradjenNMRidJedinjenje($uradjenNMR, $idjedinjenje);
	            
	            include '../jedinjenja/svajedinjenja.php';
	       	        
	    }else{
	        $msg ='Nije pokupljen ID nmr!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	}
	
	
	/* Unos spekatra NMR */
	
	/*
	 *  Spektar 1H NMR
	 */
	
	
	
	public function unosSpektra1H(){
	    
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
	    	      
	    $dao = new DAO();
	    $nmr = $dao->selectNMRIDnmr($idnmr);
	    
	    include '../element/unos1HNMR.php';
	    
	}
	
	/*
	 * unos spektra 1hnmr
	 */
	public function unos1HNMR(){
	   
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    
	    $opisSpektra1HNMR = isset($_POST['opisSpektra1HNMR'])?$_POST['opisSpektra1HNMR']:"";
	    $statusSpektra1HNMR = isset($_POST['statusSpektra1HNMR'])?$_POST['statusSpektra1HNMR']:"";
	    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
	    $karakterizacija1HNMR = isset($_POST['karakterizacija1HNMR'])?$_POST['karakterizacija1HNMR']:"";
	    
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    
	    session_start();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    if (!empty($idnmr)){
	        
	        $image = $_FILES['image']['name']; //odabir slike i ekstenzije iste
	        
	        $target = "../projekat/slike/1HNMR/".basename($image); //putanja smestanja slike
	        //smestanje slike na zadatu lokacijuj
	        if (!empty($image)){
	            if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
	                
	                $dao = new DAO();
	                $dao->update1HNMR($image, $opisSpektra1HNMR, $statusSpektra1HNMR, $karakterizacija1HNMR, $idnmr);
	                
	                $msg = 'Uspesno ste uneli podatke za 1H NMR';
	                include '../jedinjenja/listajedinjenjaNMR.php';
	            }
	        }else {
	            $dao = new DAO();
	            $dao->update1HNMRnoImage($opisSpektra1HNMR, $statusSpektra1HNMR, $karakterizacija1HNMR, $idnmr);
	            
	            $msg = 'Uspesno ste uneli podatke za 1H NMR';
	            include '../jedinjenja/listajedinjenjaNMR.php';
	            
	        }
	        
	    }else{
	        $msg ='Nije pokupljen ID NMR-a!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	}
	
	/*
	 * analiza spektra 1hnmr karakterizacija
	 */
	
	public function analiza1H(){
	    
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    
	    $dao = new DAO();
	    $nmr = $dao->selectNMRIDnmr($idnmr);
	    
	    include '../element/analiza1HNMR.php';
	    
	}
	
	/*
	 * karakterizacija 1h NMR
	 */
	
	public function karakterizacija1HNMR(){
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $opisSpektra1HNMR = isset($_POST['opisSpektra1HNMR'])?$_POST['opisSpektra1HNMR']:"";
	    $statusSpektra1HNMR = isset($_POST['statusSpektra1HNMR'])?$_POST['statusSpektra1HNMR']:"";
	    $slikaSpektra1HNMR = isset($_POST['slikaSpektra1HNMR'])?$_POST['slikaSpektra1HNMR']:"";
	    $karakterizacija1HNMR = isset($_POST['karakterizacija1HNMR'])?$_POST['karakterizacija1HNMR']:"";
	    
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    
	    session_start();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    if (!empty($idnmr)){
	        if(!empty($idjedinjenje)){
	           
	                $dao = new DAO();
	                $dao->update1HNMRkarakterizacija($karakterizacija1HNMR,$idnmr);
	                
	                $msg = 'Uspesno ste uneli karakterizaciju za 1H NMR';
	                include '../jedinjenja/listajedinjenjaNMR.php';
	        }else{
	            $msg ='Nije pokupljen ID jedinjenja!';
	            include '../jedinjenja/listajedinjenjaNMR.php';
	        }
	            
	        $msg ='Nije pokupljen ID NMR-a!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	    
	}
	
	
	
	/*
	 *  Spektar 13C NMR
	 */
	
	public function unosSpektra13C(){
	    
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    
	    $dao = new DAO();
	    $nmr = $dao->selectNMRIDnmr($idnmr);
	    
	    include '../element/unos13CNMR.php';
	    
	}
	
	/*
	 * unos 13C nmr
	 */
	
	public function unos13CNMR(){
	    
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    
	    $opisSpektra13CNMR = isset($_POST['opisSpektra13CNMR'])?$_POST['opisSpektra13CNMR']:"";
	    $statusSpektra13CNMR = isset($_POST['statusSpektra13CNMR'])?$_POST['statusSpektra13CNMR']:"";
	    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    $karakterizacija13CNMR = isset($_POST['karakterizacija13CNMR'])?$_POST['karakterizacija13CNMR']:"";
	    
	    $image = isset($_POST['image'])?$_POST['image']:"";
	        
	    session_start();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    if (!empty($idnmr)){
	        
	        $image = $_FILES['image']['name']; //odabir slike i ekstenzije iste
	        
	        $target = "../projekat/slike/13CNMR/".basename($image); //putanja smestanja slike
	        
	       
	        if (!empty($image)){
	            
	            if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
	                
	                $dao = new DAO();
	                $dao->update13CNMR($image, $opisSpektra13CNMR, $statusSpektra13CNMR, $karakterizacija13CNMR, $idnmr);
	                
	                $msg = 'Uspesno ste uneli podatke za 13C NMR';
	                include '../jedinjenja/listajedinjenjaNMR.php';
	            }
	        }else {
	            
	            $dao = new DAO();
	            $dao->update13CNMRnoImage($opisSpektra13CNMR, $statusSpektra13CNMR, $karakterizacija13CNMR, $idnmr);
	            
	            $msg = 'Uspesno ste uneli podatke za 13C NMR';
	            include '../jedinjenja/listajedinjenjaNMR.php';
	            
	        }
	        
	    }else{
	        $msg ='Nije pokupljen ID NMR-a!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	}
	
	/*
	 * analiza spektra 13CNMR karakterizacija
	 */
	
	public function analiza13C(){
	    
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    
	    $dao = new DAO();
	    $nmr = $dao->selectNMRIDnmr($idnmr);
	    
	    include '../element/analiza13CNMR.php';
	    
	}
	
	/*
	 * karakterizacija 1h NMR
	 */
	
	public function karakterizacija13CNMR(){
	    $idosoba = isset($_POST['idosoba'])?$_POST['idosoba']:"";
	    $idnmr = isset($_POST['idnmr'])?$_POST['idnmr']:"";
	    $idjedinjenje = isset($_POST['idjedinjenje'])?$_POST['idjedinjenje']:"";
	    $slikaStruktura = isset($_POST['slikaStruktura'])?$_POST['slikaStruktura']:"";
	    $opisSpektra13CNMR = isset($_POST['opisSpektra13CNMR'])?$_POST['opisSpektra13CNMR']:"";
	    $statusSpektra13CNMR = isset($_POST['statusSpektra13CNMR'])?$_POST['statusSpektra13CNMR']:"";
	    $slikaSpektra13CNMR = isset($_POST['slikaSpektra13CNMR'])?$_POST['slikaSpektra13CNMR']:"";
	    $karakterizacija13CNMR = isset($_POST['karakterizacija13CNMR'])?$_POST['karakterizacija13CNMR']:"";
	    
	    $image = isset($_POST['image'])?$_POST['image']:"";
	    
	    session_start();
	    $ulogovan=unserialize($_SESSION['ulogovan']);
	    
	    $idosoba=$ulogovan['idosoba'];
	    
	    if (!empty($idnmr)){
	        if(!empty($idjedinjenje)){
	           
	                $dao = new DAO();
	                $dao->update13CNMRkarakterizacija($karakterizacija13CNMR,$idnmr);
	                
	                $msg = 'Uspesno ste uneli karakterizaciju za 13C NMR';
	                include '../jedinjenja/listajedinjenjaNMR.php';
	        }else{
	            $msg ='Nije pokupljen ID jedinjenja!';
	            include '../jedinjenja/listajedinjenjaNMR.php';
	        }
	            
	        $msg ='Nije pokupljen ID NMR-a!';
	        include '../jedinjenja/listajedinjenjaNMR.php';
	    }
	    
	}
	
	
	
	
	

	
	
	
	
		
}
?>