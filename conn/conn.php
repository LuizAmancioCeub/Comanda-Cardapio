<?php 



try {
	$pdo = new PDO('mysql:host=127.0.0.1:3307;dbname=cardapio', 'root', '');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec("SET CHARACTER SET utf8");
}catch(PDOException $erro){
	echo "error: " . getMessage();
}




	
?>
