<?php 
						require('connection.inc.php');
						$sql = "SELECT quote_details FROM quotes ORDER BY RAND() LIMIT 1";
						$stmt = $conn->stmt_init();
						$stmt->prepare($sql);
						$stmt->bind_result($quote_details);
						$ok = $stmt->execute();
						echo $stmt->error;
						$stmt->fetch();		
						$stmt->free_result();
						
						if($ok){
							echo $quote_details;	
						}
?>