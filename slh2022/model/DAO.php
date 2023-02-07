<?php
/*
 * @name Scientists little helper - DAO
 * @author Branko Vujatovic	
 * @date   21.11.2020
 * @version 02.
 *  
 */


require_once '../config/db.php';
	class DAO {
		private $db;
		/***********************
		 * UPITI U VEZI OSOBE
		 ***********************/
		private $INSERT_OSOBA = "INSERT INTO osoba (username, password, ime, prezime, email) VALUES (?,?,?,?,?)";
		private $INSERT_DODAJ_KORISNIKA = "INSERT INTO osoba (username, password, ime, prezime, email, mobilni, idstatusosobe) VALUES (?,?,?,?,?,?,?)";
		
		private $SELECT_OSOBA_PROVERA_USERNAME = "SELECT * FROM osoba WHERE username=?";
		private $SELECT_OSOBA_BY_USERNAME_AND_PASSWORD = "SELECT * FROM osoba WHERE username =? AND password=?";
		private $SELECT_OSOBA_PROVERA_USERNAME_AND_EMAIL = "SELECT * FROM osoba WHERE username =? AND email=?";
		private $SELECT_OSOBA = "SELECT * FROM osoba";
		private $SELECT_OSOBA_BY_IDOSOBA = "SELECT * FROM osoba WHERE idosoba=?";
		
		private $UPDATE_OSOBA_BY_PASSWORD = "UPDATE osoba SET password=?, vremeizmene=CURRENT_TIMESTAMP WHERE username=?";
		private $UPDATE_OSOBA_BY_ID_OSOBA = "UPDATE osoba SET username=?, ime=?, prezime=?, email =?, mobilni=?, idstatusosobe=?, vremeizmene=CURRENT_TIMESTAMP WHERE idosoba=?";
		
		private $DELETE_OSOBA_BY_IDOSOBA = "DELETE FROM osoba WHERE idosoba=?";
			
		/****************************
		 * UPITI U VEZI JEDINJENJA
		 ****************************/
		/* INSERT */
		private $INSERT_NOVO_JEDINJENJE = "INSERT INTO jednjenje(datum, sifraJedinjenje, molarnaMasa, prinos, aroil, fenil, linker, takrin, slikaStruktura, idosoba) VALUES (?,?,?,?,?,?,?,?,?,?)";
		private $INSERT_NOVO_JEDINJENJE_NO_IMAGE = "INSERT INTO jednjenje(datum, sifraJedinjenje, molarnaMasa, prinos, aroil, fenil, linker, takrin, idosoba) VALUES (?,?,?,?,?,?,?,?,?)";
		
		/* UPDATE */
		private $UPDATE_JEDINJENJE_IDJEDINJENJE = "UPDATE jednjenje SET datum=?, sifraJedinjenje=?, molarnaMasa=?, prinos=?, aroil=?, fenil=?, linker=?, takrin=?, slikaStruktura=?, hrmsEsi=?, kratakOpisSinteze=?, vremeunosa=CURRENT_TIMESTAMP WHERE idjedinjenje=?";
		private $UPDATE_JEDINJENJE_URADJEN_NMR_IDJEDINJENJE = "UPDATE jednjenje SET uradjenNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idjedinjenje=?";
	   	private $UPDATE_JEDINJENJE_IDJEDINJENJE_PRECISCAVANJE = "UPDATE jednjenje SET  preciscavanje=?, sistemTLC=?, agregatnoStanje=?, boja=?, sumirano=?, napomena=? WHERE idjedinjenje=?";
    	
	   	private $UPDATE_JEDINJENJE_AROIL_FENIL_LINKER_TAKRIN = "UPDATE jednjenje SET aroil=?, fenil=?, linker=?, takrin=?, vremeunosa=CURRENT_TIMESTAMP WHERE idjedinjenje=?";
	   	
	   	/* SELCT */
		private $SELECT_JEDINJENJE_SVA = "SELECT * FROM jednjenje ";
		
		/* slektovanje za potrebe statistike */
		private $SELECT_JEDINJENJE_prinos_opadajuce = "SELECT * FROM jednjenje ORDER BY prinos DESC";
		private $SELECT_JEDINJENJE_prinos_rastuce = "SELECT * FROM jednjenje ORDER BY prinos ASC";
		
		private $SELECT_JEDINJENJE_Levo = "SELECT jednjenje.*,nmr.* FROM jednjenje LEFT JOIN nmr ON jednjenje.idjedinjenje = nmr.idjedinjenje ORDER BY jednjenje.sifraJedinjenje ASC";/* selektovanje jedinjenja po sifri jedinjenja u rastucem toku*/
		private $SELECT_JEDINJENJE = "SELECT jednjenje.*,nmr.* FROM jednjenje INNER JOIN nmr WHERE jednjenje.idjedinjenje = nmr.idjedinjenje ";
		private $SELECT_JEDINJENJE_NMR = "SELECT jednjenje.*,nmr.* FROM jednjenje INNER JOIN nmr ON jednjenje.idjedinjenje = nmr.idjedinjenje WHERE nmr.idjedinjenje=?";
		private $SELECT_JEDINJENJE_STATUS_NMR = "SELECT jednjenje.*,nmr.* FROM jednjenje INNER JOIN nmr ON jednjenje.idjedinjenje = nmr.idjedinjenje WHERE nmr.statusNMR=? ORDER BY jednjenje.sifraJedinjenje ASC";/* selektovanje jedinjenja po sifri jedinjenja u rastucem toku*/
		private $SELECT_JEDINJENJE_IDJEDINJENJE = "SELECT * FROM jednjenje WHERE idjedinjenje=?";
		private $SELECT_JEDINJENJE_URADJENNMR = "SELECT * FROM jednjenje WHERE uradjenNMR=?";
		
		/* pregled ukupnog prikaza zbirno */
		private $SELECT_COUNT_IDJEDINJENJE = "SELECT COUNT(idjedinjenje) FORM jednjenje";
		private $SELECT_COUNT_URADJEN_NMR = "SELECT COUNT(*) FROM jednjenje WHERE uradjenNMR = 1";
		private $SELECT_COUNT_URADJEN_OPIS_SINTEZE ="SELECT COUNT(*) FROM jednjenje WHERE kratakOpisSinteze IS NOT null";
		private $SELECT_COUNT_ARIL_FENIL_LINKER_TAKRIN = "SELECT count(*) FROM jednjenje WHERE aroil IS NOT null AND fenil IS NOT null AND linker IS NOT null AND takrin IS NOT null";
		
		/* DELETE */
		private $DELETE_JEDINJENJE_IDJEDINJENJE = "DELETE FROM jednjenje WHERE idjedinjenje=?";
		private $DELETE_JEDINJENJE_IDJEDINJENJE_NMR = "DELETE jednjenje, nmr FROM jednjenje INNER JOIN nmr ON nmr.idjedinjenje=jednjenje.idjedinjenje WHERE jednjenje.idjedinjenje=?";
		
		/*
		 * NMR 
		 */
		private $INSERT_NMR = "INSERT INTO nmr (sifraNMR, opisNMR, statusNMR, serijaNMR, idjedinjenje, idosoba) VALUES (?,?,?,?,?,?)";
		
		private $SELECT_NMR_IDNMR = "SELECT * FROM nmr WHERE idnmr=?";
		private $SELECT_NMR_SIFRA = "SELECT * FROM nmr WHERE sifraNMR=?";
		private $SELECT_NMR_SIFRA_IDJEDINJENJA = "SELECT * FROM nmr WHERE idjedinjenje=?";
		
		private $UPDATE_NMR_IDNMR = "UPDATE nmr SET opisNMR=?, statusNMR=?, serijaNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idnmr=?";
		
		private $DELETE_NMR_IDNMR = "DELETE FROM nmr WHERE idnmr=?";
		
		/*
		 * spektri NMR
		 * 1H, 13C
		 */
		private $UPDATE_1HNMR = "UPDATE nmr SET slikaSpektra1HNMR=?, opisSpektra1HNMR=?, statusSpektra1HNMR=?, karakterizacija1HNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idnmr=?";
		private $UPDATE_1HNMR_no_Image = "UPDATE nmr SET opisSpektra1HNMR=?, statusSpektra1HNMR=?, karakterizacija1HNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idnmr=?";
		private $UPDATE_1HNMR_KARAKTERIZACIJA = "UPDATE nmr set karakterizacija1HNMR=? WHERE idnmr=?";
		
		private $UPDATE_13CNMR = "UPDATE nmr SET slikaSpektra13CNMR=?, opisSpektra13CNMR=?, statusSpektra13CNMR=?, karakterizacija13CNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idnmr=?";
		private $UPDATE_13CNMR_no_Image = "UPDATE nmr SET opisSpektra13CNMR=?, statusSpektra13CNMR=?, karakterizacija13CNMR=?, vremeunosa=CURRENT_TIMESTAMP WHERE idnmr=?";
		private $UPDATE_13CNMR_KARAKTERIZACIJA = "UPDATE nmr set karakterizacija13CNMR=? WHERE idnmr=?";
		
		/*
		 * 
		 * biologija
		 * 
		 */
        private $SELECT_COUNT_IC50 = "SELECT COUNT(*) FROM biologija WHERE ache_ic IS NOT null";		
			
		
		public function __construct() {
			$this->db=db::createInstance();
		}
		
		/*
		 * METODE OSOBE
		 */
		//unos osobe
		public function insertOsoba($username, $password, $ime, $prezime, $email) {
			$statement = $this->db->prepare($this->INSERT_OSOBA); 
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $password);
			$statement ->bindValue(3, $ime);
			$statement ->bindValue(4, $prezime);
			$statement ->bindValue(5, $email);
			$statement->execute();
		}
		
		//dodavanje novog korisnika
		public function insertDodajKorsnika($username, $password, $ime, $prezime, $email, $mobilni, $idstatusosobe) {
			$statement = $this->db->prepare($this->INSERT_DODAJ_KORISNIKA); 
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $password);
			$statement ->bindValue(3, $ime);
			$statement ->bindValue(4, $prezime);
			$statement ->bindValue(5, $email);
			$statement ->bindValue(6, $mobilni);
			$statement ->bindValue(7, $idstatusosobe);
			$statement->execute();
		}
		
		// provera da li postoji korisnik sa istim username
		public function selectOsobaProveraUsername($username){
			$statement = $this->db->prepare($this->SELECT_OSOBA_PROVERA_USERNAME);
			$statement ->bindValue(1, $username);
			
			$statement ->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		//logovanje		
		public function selectOsobaByUsernameAndPassword($username, $password) {
			$statement = $this->db->prepare($this->SELECT_OSOBA_BY_USERNAME_AND_PASSWORD);
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $password);
			
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		//pregled svih osoba		
		public function selectOsoba() {
			$statement = $this->db->prepare($this->SELECT_OSOBA);
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		//izbor osobe sa odredjenim idosoba
		public function selectOsobaByIdosoba($idosoba) {
			$statement = $this->db->prepare($this->SELECT_OSOBA_BY_IDOSOBA);
			$statement ->bindValue(1, $idosoba);
			
			$statement->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		//proemna podataka osobe
		public function updateOsobaByIdOsoba($username, $ime, $prezime, $email, $mobilni, $idstatusosobe, $idosoba) {
			$statement = $this->db->prepare($this->UPDATE_OSOBA_BY_ID_OSOBA);
			
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $ime);
			$statement ->bindValue(3, $prezime);
			$statement ->bindValue(4, $email);
			$statement ->bindValue(5, $mobilni);
			$statement ->bindValue(6, $idstatusosobe);
			$statement ->bindValue(7, $idosoba);
			
			$statement->execute();
		}
		
		//provera postojanja osobe sa username i email
		public function selectOsobaProveraUsernameAndEmail($username, $email){
			$statement = $this->db->prepare($this->SELECT_OSOBA_PROVERA_USERNAME_AND_EMAIL);
			$statement ->bindValue(1, $username);
			$statement ->bindValue(2, $email);
			
			$statement ->execute();
			$result = $statement->fetch();
			return $result;
		}
		
		//promena passworda
		public function updateOsobaByPassword($password, $username) {
			$statement = $this->db->prepare($this->UPDATE_OSOBA_BY_PASSWORD);
			
			$statement ->bindValue(1, $password);
			$statement ->bindValue(2, $username);
			
			$statement->execute();
		}
		
		//brisanje osobe iz baze
		public function obrisiOsobu($idosoba){
			$statement = $this->db->prepare($this->DELETE_OSOBA_BY_IDOSOBA);
			$statement ->bindValue(1, $idosoba);
			$statement ->execute();
		}
		
		/*************************************************
		 *
		 * METODE JEDINJENJA	
		 *
		 ************************************************/
		
		//otvaranje-unos novog jedinjenja
		
		public function insertNovoJedinjenje($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $image, $idosoba){
		    
		    $statement = $this->db->prepare($this->INSERT_NOVO_JEDINJENJE);
		    $statement ->bindValue(1, $datum);
		    $statement ->bindValue(2, $sifraJedinjenje);
		    $statement ->bindValue(3, $molarnaMasa);
		    $statement ->bindValue(4, $prinos);
		    $statement ->bindValue(5, $aroil);
		    $statement ->bindValue(6, $fenil);
		    $statement ->bindValue(7, $linker);
		    $statement ->bindValue(8, $takrin);
		    $statement ->bindValue(9, $image);
		    $statement ->bindValue(10, $idosoba);
		    
		    $statement->execute();
		}
		
		// unos jedinjenjan bez slike strukture
				
		public function insertNovoJedinjenjeNoImage($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $idosoba){
		    
		    $statement = $this->db->prepare($this->INSERT_NOVO_JEDINJENJE_NO_IMAGE);
		    $statement ->bindValue(1, $datum);
		    $statement ->bindValue(2, $sifraJedinjenje);
		    $statement ->bindValue(3, $molarnaMasa);
		    $statement ->bindValue(4, $prinos);
		    $statement ->bindValue(5, $aroil);
		    $statement ->bindValue(6, $fenil);
		    $statement ->bindValue(7, $linker);
		    $statement ->bindValue(8, $takrin);
		    $statement ->bindValue(9, $idosoba);
		    
		    $statement->execute();
		}
		
		//update jedinjenja po id jedinjenju
		
		public function updateJedinjenjeIDjedinjenje($datum, $sifraJedinjenje, $molarnaMasa, $prinos, $aroil, $fenil, $linker, $takrin, $slikaStruktura, $hrmsEsi, $kratakOpisSinteze, $idjedinjenje){
		    $statement = $this->db->prepare($this->UPDATE_JEDINJENJE_IDJEDINJENJE);
		    $statement ->bindValue(1, $datum);
		    $statement ->bindValue(2, $sifraJedinjenje);
		    $statement ->bindValue(3, $molarnaMasa);
		    $statement ->bindValue(4, $prinos);
		    $statement ->bindValue(5, $aroil);
		    $statement ->bindValue(6, $fenil);
		    $statement ->bindValue(7, $linker);
		    $statement ->bindValue(8, $takrin);
		    $statement ->bindValue(9, $slikaStruktura);
		    $statement ->bindValue(10, $hrmsEsi);
		    $statement ->bindValue(11, $kratakOpisSinteze);
		    $statement ->bindValue(12, $idjedinjenje);
		    
		    $statement ->execute();
		}
		
		//update jedinjenja po id jedinjenju preciscavanje
		
		public function updateJedinjenjeIDjedinjenjePreciscavanje($preciscavanje, $sistemTLC, $agregatnoStanje, $boja, $sumirano, $napomena, $idjedinjenje){
		    $statement = $this->db->prepare($this->UPDATE_JEDINJENJE_IDJEDINJENJE_PRECISCAVANJE);
		    
		    $statement ->bindValue(1, $preciscavanje);
		    $statement ->bindValue(2, $sistemTLC);
		    $statement ->bindValue(3, $agregatnoStanje);
		    $statement ->bindValue(4, $boja);
		    $statement ->bindValue(5, $sumirano);
		    $statement ->bindValue(6, $napomena);
		    $statement ->bindValue(7, $idjedinjenje);
		    
		    $statement ->execute();
		}
		
		//update jedinjenja slike 
		
		public function updateSlikaIdJedinjenja($slikaStruktura, $idjedinjenje) {
		    $statement = $this->db->prepare($this->UPDATE_STRUKTURA_SLIKA_JEDINJENJA_IDJEDINJENJE);
		    
		    $statement ->bindValue(1, $slikaStruktura);
		    $statement ->bindValue(2, $idjedinjenje);
		    
		    $statement->execute();
		}
		
		
		//promena statusa uradjen NMR u status 1
		
		public function updateJedinjenjeUradjenNMRidJedinjenje($uradjenNMR, $idjedinjenje) {
		   $statement = $this->db->prepare($this->UPDATE_JEDINJENJE_URADJEN_NMR_IDJEDINJENJE);
		   
		   $statement ->bindValue(1, $uradjenNMR);
		   $statement ->bindValue(2, $idjedinjenje);
		   
		   $statement ->execute();
		}
		
		//update aroi, fenil, takrin, linker
		
		public function updateJedinjenjeAroilFenilLinkerTakrin($aroil, $fenil, $linker, $takrin, $idjedinjenje){
		    $statement = $this->db->prepare($this->UPDATE_JEDINJENJE_AROIL_FENIL_LINKER_TAKRIN);
		    
		    $statement ->bindValue(1, $aroil);
		    $statement ->bindValue(2, $fenil);
		    $statement ->bindValue(3, $linker);
		    $statement ->bindValue(4, $takrin);
		    $statement ->bindValue(5, $idjedinjenje);
		    
		    $statement ->execute();
		    
		}
				
		//pregled jedinjenja
		public function selectJedinjenje(){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE);
		    $statement->execute();
		    
		    $result = $statement->fetchAll();
		    return $result;
		}
		
		//pregled jedinjenja levo spajanje
		public function selectJedinjenjeLevo(){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_Levo);
		    $statement->execute();
		    
		    $result = $statement->fetchAll();
		    return $result;
		}
		
		public function selectJedinjenjeNMR($idjedinjenje){
			$statement = $this->db->prepare($this->SELECT_JEDINJENJE_NMR);
			$statement ->bindValue(1, $idjedinjenje);
			$statement->execute();
			
			$result = $statement->fetchAll();
			return $result;
		}
		
		//pregled jedinjenja prema statusu NMR
		
		public function selectJedinjenjeDobarNMR($statusNMR){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_STATUS_NMR);
		    $statement ->bindValue(1, $statusNMR);
		    
		    $statement->execute();
		    
		    $result = $statement->fetchAll();
		    return $result;
		}
		
		//pregled jedinjenja sva 
		
		public function selectJedinjenjeSva(){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_SVA);
		    $statement->execute();
		    
		    $result = $statement->fetchAll();
		    return $result;
		}
	
		//pregled jedinjenja po id jedinjenju
		
		public function selectJedinjenjeIdjedinjenje($idjedinjenje){
			$statement = $this->db->prepare($this->SELECT_JEDINJENJE_IDJEDINJENJE);
			$statement ->bindValue(1, $idjedinjenje);
			
			$statement->execute();
			$result = $statement->fetchAll();
			return $result;
		}
		
		//pregled jedinjenja prema uradjenNMR
		
		public function selectJedinjenjeUradjenNMR($uradjenNMR){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_URADJENNMR);
		    $statement ->bindValue(1, $uradjenNMR);
		    
		    $statement->execute();
		    $result = $statement->fetchAll();
		    return $result;
		}
		
		//pregled jedinjenja po prinosu opadajuce
		
		public function selectJedinjenjePoPrinosuOpadajuce(){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_prinos_opadajuce);
		   
		    $statement->execute();
		    $result = $statement->fetchAll();
		    return $result;
		}
		
		//pregled jedinjenja po prinosu rastuce
		
		public function selectJedinjenjePoPrinosuRastuce(){
		    $statement = $this->db->prepare($this->SELECT_JEDINJENJE_prinos_rastuce);
		    
		    $statement->execute();
		    $result = $statement->fetchAll();
		    return $result;
		}
				
		//brisanje jedinjenja
		
		public function brisanjeJedinjenje($idjedinjenje){
			$statement = $this->db->prepare($this->DELETE_JEDINJENJE_IDJEDINJENJE);
			$statement->bindValue(1, $idjedinjenje);
			$statement->execute();
		}
		
		//brisanje jedinjenja i nmr
		
		public function brisanjeJedinjenjeNMR($idjedinjenje){
		    $statement = $this->db->prepare($this->DELETE_JEDINJENJE_IDJEDINJENJE_NMR);
		    $statement->bindValue(1, $idjedinjenje);
		    $statement->execute();
		}		
		
		
		/*                 N M R                           */
		
		/*
		 * UNOS sifre nmr, komentar nmr
		 */
		 
		public function insertNMR($sifraNMR, $opisNMR, $statusNMR,$serijaNMR, $idjedinjenje, $idosoba){
			$statement = $this->db->prepare($this->INSERT_NMR);
			
			$statement ->bindValue(1, $sifraNMR);
			$statement ->bindValue(2, $opisNMR);
			$statement ->bindValue(3, $statusNMR);
			$statement ->bindValue(4, $serijaNMR);
			$statement ->bindValue(5, $idjedinjenje);
			$statement ->bindValue(6, $idosoba);
			
			$statement->execute();
			
		}
		
		/*
		 * pregled nmr po sifri nmr
		 *
		 */
		
		public function selectNmrSifra($sifraNMR){
		    $statement = $this->db->prepare($this->SELECT_NMR_SIFRA);
		    $statement ->bindValue(1, $sifraNMR);
		    
		    $statement->execute();
		    $result = $statement->fetch();
		    return $result;
		}
		
		/*
		 * pregled nmr po id jedinjenja
		 *
		 */		
		
		public function selectNmrPregledSifraIdJedinjenje($idjedinjenje){
		    $statement = $this->db->prepare($this->SELECT_NMR_SIFRA_IDJEDINJENJA);
		    $statement ->bindValue(1, $idjedinjenje);
		    
		    $statement->execute();
		    $result = $statement->fetch();
		    
		    return $result;
		}
		
		/*
		 * pregled nmr po id nmr
		 *
		 */
		
		public function selectNMRIDnmr($idnmr){
		    $statement = $this->db->prepare($this->SELECT_NMR_IDNMR);
		    $statement ->bindValue(1, $idnmr);
		    
		    $statement->execute();
		    $result = $statement->fetch();
		    
		    return $result;
		}
		
		
		/*
		 * azuriranje po id nmr
		 *
		 */
		public function updateNMRIDnmr($opisNMR, $statusNMR, $serijaNMR, $idnmr){
		    $statement = $this->db->prepare($this->UPDATE_NMR_IDNMR); 
		    
		    $statement ->bindValue(1, $opisNMR);
		    $statement ->bindValue(2, $statusNMR);
		    $statement ->bindValue(3, $serijaNMR);
		    $statement ->bindValue(4, $idnmr);
		    
		    $statement ->execute();
		    
		}
		
		
		/*
		 * brisanje nmr po idnmr
		 *
		 */
		public function brisanjeNMRIDnmr($idnmr) {
		    $statement=$this->db->prepare($this->DELETE_NMR_IDNMR);
		    
		    $statement->bindValue(1, $idnmr);
		    $statement->execute();
		    
		}
		
		
		/*
		 * 1H NMR update image
		 */
		public function update1HNMR($image, $opisSpektra1HNMR, $statusSpektra1HNMR, $karakterizacija1HNMR, $idnmr) {
		    $statement=$this->db->prepare($this->UPDATE_1HNMR);
		    
		    $statement ->bindValue(1, $image);
		    $statement ->bindValue(2, $opisSpektra1HNMR);
		    $statement ->bindValue(3, $statusSpektra1HNMR);
		    $statement ->bindValue(4, $karakterizacija1HNMR);
		    $statement ->bindValue(5, $idnmr);
		    
		    $statement ->execute();
		}
		
		/*
		 * 1H NMR update karakterizacija
		 */
		public function update1HNMRkarakterizacija($karakterizacija1HNMR, $idnmr) {
		    $statement=$this->db->prepare($this->UPDATE_1HNMR_KARAKTERIZACIJA);
		    
		    $statement ->bindValue(1, $karakterizacija1HNMR);
		    $statement ->bindValue(2, $idnmr);
		    
		    $statement ->execute();
		}
		
		
		/*
		 * 1H NMR update no image
		 */
		public function update1HNMRnoImage($opisSpektra1HNMR, $statusSpektra1HNMR, $karakterizacija1HNMR, $idnmr) {
		    $statement=$this->db->prepare($this->UPDATE_1HNMR_no_Image);
		   
		    $statement ->bindValue(1, $opisSpektra1HNMR);
		    $statement ->bindValue(2, $statusSpektra1HNMR);
		    $statement ->bindValue(3, $karakterizacija1HNMR);
		    $statement ->bindValue(4, $idnmr);
		    
		    $statement ->execute();
		}
		
		
		/*
		 * 13C NMR update image
		 */
		public function update13CNMR($image, $opisSpektra13CNMR, $statusSpektra13CNMR, $karakterizacija13CNMR, $idnmr) {
		    $statement = $this->db->prepare($this->UPDATE_13CNMR);
		    
		    $statement ->bindValue(1, $image);
		    $statement ->bindValue(2, $opisSpektra13CNMR);
		    $statement ->bindValue(3, $statusSpektra13CNMR);
		    $statement ->bindValue(4, $karakterizacija13CNMR);
		    $statement ->bindValue(5, $idnmr);
		    
		    $statement ->execute();
		}
		
		/*
		 * 13C NMR update karakterizacija
		 */
		public function update13CNMRkarakterizacija($karakterizacija13CNMR, $idnmr) {
		    $statement=$this->db->prepare($this->UPDATE_13CNMR_KARAKTERIZACIJA);
		    
		    $statement ->bindValue(1, $karakterizacija13CNMR);
		    $statement ->bindValue(2, $idnmr);
		    
		    $statement ->execute();
		}
		
		
		/*
		 * 13C NMR update no image
		 */
		public function update13CNMRnoImage($opisSpektra13CNMR, $statusSpektra13CNMR, $karakterizacija13CNMR, $idnmr) {
		    $statement = $this->db->prepare($this->UPDATE_13CNMR_no_Image);
		    
		    $statement ->bindValue(1, $opisSpektra13CNMR);
		    $statement ->bindValue(2, $statusSpektra13CNMR);
		    $statement ->bindValue(3, $karakterizacija13CNMR);
		    $statement ->bindValue(4, $idnmr);
		    
		    $statement ->execute();
		}
		
		
		
		
		
	}
?>
