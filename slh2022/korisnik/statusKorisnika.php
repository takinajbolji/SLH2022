<?php
/*
 * @tema: Status korisnika
 */
?>
			<table>
					<tr>
						<th>Status korisnika  </th>
						<th>
						<select name="idstatusosobe">
							<option value="<?php echo $idstatusosobe ?>">
								<?php switch ($idstatusosobe){
		   			   				
		   			   				case 2:					
										echo "Admin projekta";
										break;	
		   			   				case 3:					
										echo "Saradnik";
										break;
					   				case 4:
					   					echo "Spoljni saradnik";
					   					break;	   			
					   				case 5:
					   					echo "Spoljni saradnik izvan RS";
					   					break;	
					   				case 6:
					   					echo "Gost";
					   					break;
					   				}	 ?>
					   		</option>
					   		<option value="<?php echo $idstatusosobe=6?>">Gost</option>
							<option value="<?php echo $idstatusosobe=2?>">Admin projekta</option>
							<option value="<?php echo $idstatusosobe=3?>">Saradnik</option>
							<option value="<?php echo $idstatusosobe=4?>">Spoljni saradnik</option>
							<option value="<?php echo $idstatusosobe=5?>">Spoljni saradnik izvan RS</option>
							
						
						</select>
						</th>
					
					</tr>
				</table>
