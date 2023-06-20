<?php 
    require ("conn/conn.php");
   
    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='Index.php';</script>";
    }
    $cpf = $_SESSION['cpf'];

    // Pegar nome do usuário
    $consulta = $pdo->prepare("SELECT nome FROM usuario where cpf = '$cpf' ");
    $consulta->execute();
    $rowNome = $consulta->fetch();
    $nome = $rowNome['nome'];
    $nome = strtoupper($nome);

    // Pegar id do Usuario
    $consulta = $pdo->prepare("SELECT idUsuario FROM usuario where cpf = '$cpf' ");
    $consulta->execute();
    $rowId = $consulta->fetch();
    $idUsuario = $rowId['idUsuario'];

    // Contar quantidade de pedidos em preparo
    $qntd = $pdo->prepare("SELECT count(idPedido) as qntdPedido FROM pedido 
                                                                JOIN usuario on usuario_idUsuario = '$idUsuario'
                                                         where cpf = '$cpf' and status = 1 ");
    $qntd->execute();
    $rowQntd = $qntd->fetch();
    $qntdPedidos = $rowQntd['qntdPedido'];                                                     
    
 ?>
<!DOCTYPE html>
<html>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
   
    <script type="text/javascript" src="../jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.4/angular.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/corpo.css">
</head>
<body>
    <a href="#" class="menu-open" style="top:3px;
    left:15px;
    position: fixed;
    z-index: 1000;"><i class="bi bi-list"></i></a>

    <div class="overlay"></div>
  <?php
  // Menu
    $sql = $pdo->prepare("SELECT idCategorias, categoria FROM categorias");
    $sql->execute();
    $rowsql = $sql->fetchAll();
  ?>
    <div class="menu">
      <a href="#" class="menu-close">&times;</a>
      <ul>
        <li><a href="Home.php">Home</a></li>
    <?php
      foreach($rowsql as $linhaMenu){
        echo '<li><a href="'.$linhaMenu["categoria"].'.php">'.$linhaMenu["categoria"].'</a></li>';
      }

    ?>
          <form action="acao.php" method="POST" style="margin-top: 20%;">
            <button class="btn btn-danger" name="sairM" id="sairM"><i class="bi bi-box-arrow-left"></i></button>
          </form>  
        </li>
      </ul>
    </div>

    
<?php
// Botão da Comanda
    if($_SESSION['nivel'] == 0){ // Perfil Visitante
      echo "<div>";
        echo '<a style="color: currentColor;cursor: not-allowed;opacity: 0.6;text-decoration: none;" title="Sua Comanda" class="comanda badge badge-pill badge-success" style="font-size: 30px;"><i class="bi bi-receipt-cutoff"></i></a>';
      echo '</div>';
    } 
    elseif(($_SESSION['nivel'] == 1) && ($qntdPedidos > 0)){ // Perfil Cliente com algum pedido em preparo
    ?>  
      <div>
        <a href="Comanda.php" title="Sua Comanda" class="comanda badge badge-pill badge-success" style="font-size: 30px;">
          <i class="bi bi-receipt-cutoff"></i> 
          <span style="font-size:17px;margin-top:-20px;border-radius:10px;color:black" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
              <?php echo $qntdPedidos ?> </span>
        </a>
      </div>
    <?php  
    }
    elseif(($_SESSION['nivel'] == 1) && ($qntdPedidos == 0)){ // Perfil Cliente sem pedidos em preparo
      echo "<div>";
        echo ' <a href="Comanda.php" title="Sua Comanda" class="comanda badge badge-pill badge-success" style="font-size: 30px;"><i class="bi bi-receipt-cutoff"></i></a>';
      echo '</div>';
    }
    elseif($_SESSION['nivel'] == 2){ // Perfil administrador
      echo "<div>";
        echo ' <a href="GerenciarComandas.php" title="Sua Comanda" class="comanda badge badge-pill badge-success" style="font-size: 30px;"><i class="bi bi-receipt-cutoff"></i></a>';
      echo '</div>';
    }

// Botão do perfil     
  if($_SESSION['nivel'] == 1){
?>        
    <div class="dropdown">
      <button class="dropbtn"><i style="font-size:22px" class="bi bi-person"></i></button>
      <div class="dropdown-content">
      <span  style="font-size:15px" class="badge badge-pill badge-primary"><?php echo $nome ?></span>
      <a href="Comanda.php">Ver Comanda</a>
      <a href="#">Solicitar ajuda</a>
      <form action = "acao.php" method="POST">
        <button style="margin:1px;margin-top:10px;border-radius:40px" class="btn btn-danger btn-sm btn-block" name="sair">Sair</a>
      </form>
      </div>
    </div>

    <?php
  }elseif($_SESSION['nivel'] == 0){
?>        
    <div class="dropdown">
      <button class="dropbtn"><i style="font-size:22px" class="bi bi-person"></i></button>
      <div class="dropdown-content">
      <span style="font-size:15px" class="badge badge-pill badge-success"><?php echo $nome ?></span>
      <a href="Index.php">Fazer cadastro</a>
      <a href="#">Solicitar ajuda</a>
      <form action = "acao.php" method="POST">
        <button style="margin:1px;margin-top:10px;border-radius:40px" class="btn btn-danger btn-sm btn-block" name="sair">Sair</a>
      </form>
      </div>
    </div>
<?php    
  } elseif($_SESSION['nivel'] == 2){
?>  
    <div class="dropdown" >
      <button class="dropbtn"><i style="font-size:20px" class="bi bi-person"></i></button>
      <div class="dropdown-content">
<span style="font-size:15px" class="badge badge-pill badge-primary"><?php echo $nome ?></span>
      <a href="GerenciarPedidos.php">Pedidos</a>
      <a href="GerenciarComandas.php">Comandas</a>
      <a href="GerenciarMesas.php">Mesas</a>
      <form action = "acao.php" method="POST">
        <button style="margin:1px;margin-top:10px;border-radius:40px" class="btn btn-danger btn-sm btn-block" name="sair">Sair</a>
      </form>
      </div>
    </div>
  <?php      
  } ?>
    <script type="text/javascript">

      $(function () {
      var menu_width = 290;
      var menu = $(".menu");
      var menu_open = $(".menu-open");
      var menu_close = $(".menu-close");
      var overlay = $(".overlay");

      menu_open.click(function (e) {
      e.preventDefault();
      menu.css({"left": "0px"});
      overlay.css({"opacity": "1", "width": "100%"});
      });
      
      menu_close.click(function (e) {
      e.preventDefault();
      menu.css({"left": "-" + menu_width + "px"});
      overlay.css({"opacity": "0", "width": "0"});
      });

      tela.click(function (e) {
      e.preventDefault();
      menu.css({"left": "-" + menu_width + "px"});
      overlay.css({"opacity": "0", "width": "0"});
      });

      
      });
  </script>    
</body>
</html>