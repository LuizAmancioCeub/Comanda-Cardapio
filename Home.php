<?php 
    require ("conn/conn.php");
    session_start();

    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='Index.php';</script>";
    }
	$cpf = $_SESSION['cpf'];
    $consulta = $pdo->prepare("SELECT nome FROM usuario where cpf = '$cpf' ");
    $consulta->execute();
    $rowNome = $consulta->fetch();
    $nome = $rowNome['nome'];


 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Home</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

</head>
<style>
		.text{
			margin-top:-5%;
		}
		@media only screen and (max-width: 700px){
			.text{
			margin-top:-15%;
			}
		}
	</style>
<body>
		<form action = "acao.php" method="POST" style="text-align:right;margin:10px">
            <button class="btn btn-danger" name="sair" id="sair">Sair</button>
        </form>    
    <div class="text">
        <?php
        echo "<h1>Bem Vindo ".$nome."!!<br></h1>";	
		?>
		<?php 
if($_SESSION['nivel'] == 2){
	

?>
    </div>
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<section class="hero-section">
		<div class="card-grid">
			<a class="card" href="Ofertas.php">
			<div class="card__background" style="background-image: url(imagens/cardapio.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Cardápio</p>
				<h3 class="card__heading">Gerencie nosso cardápio</h3>
			</div>
			</a>

			<a class="card" href="GerenciarComandas.php">
			<div class="card__background" style="background-image: url(imagens/comanda.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Comandas</p>
				<h3 class="card__heading">Gerencie Comandas</h3>
			</div>
			</a>

			<a class="card" href="GerenciarPedidos.php">
			<div class="card__background" style="background-image: URL(imagens/cozinha.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Cozinha</p>
				<h3 class="card__heading">Gerencie os Pedidos</h3>
			</div>
			</a>

			<a class="card" href="GerenciarMesas.php">
			<div class="card__background" style="background-image: url(imagens/mesas.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Mesas</p>
				<h3 class="card__heading">Gerencie as Mesas</h3>
			</div>
			</a>
			
		<div>
		</section>
<?php
} elseif($_SESSION['nivel'] == 1){

?>		
	</div>
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<section class="hero-section">
		<div class="card-grid">
			<a class="card" href="Ofertas.php">
			<div class="card__background" style="background-image: url(imagens/cardapio.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Nosso Cardápio</p>
				<h3 class="card__heading">Visualize nosso cardápio</h3>
			</div>
			</a>

			<a class="card" href="Comanda.php">
			<div class="card__background" style="background-image: url(imagens/comanda.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Sua Comanda</p>
				<h3 class="card__heading">Gerencie sua própria comanda</h3>
			</div>
			</a>
			
		<div>
		</section>
<?php 
} elseif($_SESSION['nivel'] == 0){
	echo '<div class="alert alert-warning text-center" role="alert"> Como visitante você poderá apenas visualizar nosso cardápio</h3></div>';
			
?>
	</div>
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

		<section class="hero-section">
		<div class="card-grid">
			<a class="card" href="Ofertas.php">
			<div class="card__background"  style="background-image: url(imagens/cardapio.jpg)"></div>
			<div class="card__content">
				<p class="card__category">Nosso Cardápio</p>
				<h3 class="card__heading">Visualize nosso cardápio</h3>
			</div>
			</a>

			<a class="card" style="color: currentColor;cursor: not-allowed;opacity: 0.5;text-decoration: none;" >
			<div class="card__background" style="background-image: url(imagens/comanda.jpg)"></div>
			<div class="card__content">
				<p class="card__category">DESATIVADO</p>
				<h3 class="card__heading">Gerencie sua própria comanda</h3>
			</div>
			</a>
			
		<div>
		</section>		
<?php
} ?>
		
		<footer>
      
		<div>

		  <footer class="text-white text-center text-lg-start bg-dark">
		    
		    <div class="container p-4">
		      
		      <div class="row mt-4">
		        
		        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
		          <h5 class="text-uppercase mb-4">Sobre nós</h5>

		          <p>
		            At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
		            voluptatum deleniti atque corrupti.
		          </p>

		          <p>
		            Blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas
		            molestias.
		          </p>

		          <div class="mt-4">
		            
		            <a type="button" class="btn btn-lg"><i class="bi bi-facebook text-info"></i></a>
		            
		            <a type="button" class="btn btn-lg"><i class="bi bi-instagram text-primary"></i></a>
		            
		            <a type="button" class="btn btn-lg"><i class="bi bi-envelope-at text-danger"></i></a>
		            
		            <a type="button" class="btn btn-lg"><i class="bi bi-whatsapp text-success"></i></a>
		            
		          </div>


		        </div>
		        
		        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
		          

		          <ul style="margin-left: -2.6em;">
		            <li class="mb-3">
		              <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Rua 3b, chácara 30, Vicente Pires-DF</span>
		            </li>
		            <li class="mb-3">
		              <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">restaurante@gmail.com</span>
		            </li>
		            <li class="mb-3">
		              <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">(61) 99999-9999</span>
		            </li>
		          </ul>

		          <div class="mt-4">
            
		            <img src="imagens/payment2.png">
		            
		            <img src="imagens/visa.png">
		            
		            <img src="imagens/elo.png">
		            
		            <img src="imagens/pix.png" width="80px">
		            
		          </div>
		        </div>
		        
		        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
		          <h5 class="text-uppercase mb-4">Horários</h5>

		          <table class="table text-center text-white">
		            <tbody class="fw-normal">
		              <tr>
		                <td>Segunda - Quarta:</td>
		                <td>15:00 - 23:00</td>
		              </tr>
		              <tr>
		                <td>Quinta - Sabádo:</td>
		                <td>10:00 - 02:00</td>
		              </tr>
		              <tr>
		                <td>Domingo:</td>
		                <td>9:00 - 00:00</td>
		              </tr>
		            </tbody>
		          </table>
		        </div>
		        
		      </div>
		      
		    </div>
		
		    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
		      Comanda Digital
		      
		    </div>
		    
		  </footer>
</body>
</html>