<?php
/*
 * @name: veza SLH
 * @author: branko
 * @date:   20.07.2021
 * @version: 01
 * 
 */

require_once '../controller/Controller.php';
	
	
	$controller = new Controller(); 
	
	
	if($_SERVER['REQUEST_METHOD']==='POST') {
		$page=$_POST['page'];
		switch ($page) {
			/*
			 * osoba
			 */
			case 'Login':
				$controller->login();
				break;
				
			case 'Registracija':
				$controller->registracijaKorisnika();
				break;
				
			case 'PromenaLozinke':
			    $controller->promenaLozinkeKorisnika();
				break;
				
			case 'noviKorisnik':
			    $controller->dodajNovogKorisnika();
			    break;
			    
			case 'Dodaj':
			    $controller->dodajKorisnika();
				break;
				
			case 'Izmeni':
				$controller->editOsoba();
				break;
				
			case 'Nazad':
			    $controller->pregledKorisnika();
			    break;	
			    
			case 'obrsiosobu':
			    $controller->obrisiOsobu();
			    break;
			    
			case 'Azuriraj':
			    $controller->showEditOsoba();
			    break;
			    
			case 'pocetna':
			    $controller->pocetna();
			    break;
			    
			case 'licaUradu':
			    $controller->pregledKorisnika();
			    break;
			
		   /*********************************
			* statistika
			*********************************/	
			case 'statistika':
			    $controller->statistika();
			    break;
			
			case 'azuriranjeAFLT':
			    $controller->azuriranjeAFLT();
			    break;
			    
			case 'azurirajJedinjenjeAFLT':
			    $controller->azurirajJedinjenjeAFLT();
			    break;
			    
			/*********************************
			 * Jedinjenja
			 * 
			 *********************************/	
			    
			case 'ListaJedinjenjaNaslov':
			    $controller->listaJedinjenja();
			    break;
			    
			case 'ListaJedinjenjaDobarNMRNaslov':
			    $controller->listaJedinjenjaDobarNMR();
			    break;
			
			case 'AzuriranjeJedinjenja':
			    $controller->AzuriranjeJedinjenja();
				break;
				
			case 'azurirajJedinjenje':
			    $controller->azurirajJedinjenje();
			    break;
			    
			case 'dodajNovoJedinjenje':
			    $controller->dodajNovoJedinjenja();
			    break;
			    
			case 'Novo_jedinjenje':
			    $controller->novoJedinjenje();
			    break;
			    
			case 'ListaJedinjenja':
			    $controller->listaJedinjenja();
			    break;
			    
			case 'jedinjenja':
			    $controller->jedinjenja();
			    break;
			    
			case 'jedinjenjaBezNMR':
			    $controller->jedinjenjaBezNMR();
			    break;
			    
			case 'SvaJedinjenja':
			    $controller->svaJedinjenja();
			    break;
			    
			case 'brisanjeJedinjenja':
			    $controller->brisanjeJedinjenje();
			    break;
			    
			/*********************************
			 * elementi
			 * 
			 *********************************/	
			
			 //nmr
			    
			case 'NMR':
			    $controller->unosNMR();
			    break;
			    
			case 'AzurirajNMR':
			    $controller->azuriranjeNMR();
			    break;
			
		    case 'IzmeniNMR':
		        $controller->azurirajNMR();
		        break;
		        
		    case 'BrisanjeNMR':
		        $controller->brisanjeNMR();
		        break;
		    
		    //1H NMR
		    case '1H_NMR':
		        $controller->unosSpektra1H();
		        break;
		    
		    case 'Dodaj_1H_NMR':
		        $controller->unos1HNMR();
		        break;
		        
		    case 'Analiza_1H':
		        $controller->analiza1H();
		        break;
		        
		    case 'Karakterizacija_1H':
		        $controller->karakterizacija1HNMR();
		        break;
		        
		    
		        
		    //13C NMR
		    case '13C_NMR':
		        $controller->unosSpektra13C();
		        break;
		        
		    case 'Dodaj_13C_NMR':
		        $controller->unos13CNMR();
		        break;
		        
		    case 'Analiza_13C':
		        $controller->analiza13C();
		        break;
		        
		    case 'Karakterizacija_13C':
		        $controller->karakterizacija13CNMR();
		        break;
		        
		   // preciscavanje, agregatnostanje, boja, sumirano
		    case 'Preciscavanje':
		        $controller->preciscavanje();
		        break;
		        
		    case 'AzurirajPreciscavanje':
		        $controller->azurirajnjePreciscavanje();
		        break;
		        
				
		}
		
	} else {
		$page=$_GET['page'];
		switch ($page) {
			
		    /*
		     * osoba
		     */
			case 'logout':
				$controller->logout();
				break;
				
			case 'pregledKorisnika':
				$controller->pregledKorisnika();
				break;	
			
			case 'obrsiosobu':
				$controller->obrisiOsobu();
				break;
							
			case 'insert':
				$controller->showInsert();
				break;
			
			case 'osobe':
				$controller->selectOsobe();
				break;
						
			case 'promeniKorisnika':
				$controller->updateOsoba();
				break;
				
			case 'showeditosoba':
				$controller->showEditOsoba();
				break;
			
			
		}
	}
?>