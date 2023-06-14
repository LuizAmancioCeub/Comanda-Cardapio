<?php 
    require ("conn/conn.php");
    session_start();
    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='Index.php';</script>";
    }
    $cpf = $_SESSION['cpf'];
    $mesa = $_SESSION['mesa'];
   
 ?>
<html ng-app>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cardapio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

 
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.4/angular.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/msg.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
  

    <div class="container-fluid">
      <?php // background-color: #FEFFEE;
          include "corpo/menu.php";
          ?>  
     
      
            <h1>Destaques do nosso Cardápio</h1>

        <section id="sliderhome">
          <div id="meuSlider" class="carousel slide align-items-center" data-ride="carousel">
            <div class="carousel-inner  mx-auto text-center">
              <div class="item active"><img style="border-radius: 20px" class="img-responsive" src="imagens/happy.jpg" width="100%"></div>
            </div>
            <a class="left carousel-control" href="#meuSlider" data-slide="prev"></a>
            <a class="right carousel-control" href="#meuSlider" data-slide="next"><span class=""></span></a>
          </div>
        </section>
        <br>     
        <?php
    if($_SESSION['nivel'] == 2){  
      include "admin/OfertasAdmin.php";
    } 
    elseif(($_SESSION['nivel'] == 1) OR ($_SESSION['nivel'] == 0)){  
      $item = $pdo->prepare('SELECT item, descricao, preco, imagem, idItens FROM itens WHERE Categorias_idCategorias = 1 ORDER BY item ASC');
      $item->execute();

      echo "<div class='row row-cols-2 row-cols-md-3 g-4'>";
        if($item->rowCount() > 0){
          while($row = $item->fetch(PDO::FETCH_ASSOC)){

              echo "<input type='hidden' name='idItens' id='idItens' value='".$row['idItens']."'>";
              echo "<div class='col' style='border-radius:30px'>";
                echo "<div class='card h-100'  style='border-radius:30px;'>";
                  echo "<img src='imagens/".$row['imagem']."' class='card-img-top' style='border-top-left-radius:20px;border-top-right-radius:20px'>";
                  echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>".$row['item']."</h5>";
                    echo "<p class='card-text'>".$row['descricao']."</p>";
                    echo "<p class='card-text'><b>Valor: R$".$row['preco']."</b></p>";
                  echo "</div>";
                  echo "<div class='card-footer'>";
                    echo "<div class='row d-flex justify-content-center'>";
                    if($_SESSION['nivel'] == 0){
                      echo "<button class='btn btn-success' disabled type='button' data-toggle='modal' data-target='#pedido".$row['idItens']."'>Fazer Pedido</button>";
                    } else{
                      echo "<button class='btn btn-success' type='button' data-toggle='modal' data-target='#pedido".$row['idItens']."'>Fazer Pedido</button>";
                    }
                    echo "</div>";
                      echo "</div>";
                echo "</div>";
              echo "</div>";

    //MODAL

                    // Realizar Pedido
                    
    echo '<div class="modal fade" id="pedido'.$row['idItens'].'" style="color: black">';
      echo '<div class="modal-dialog modal-dialog-centered">';
        echo '<div class="modal-content" style="border-radius:30px">';
                  
        echo '<div class="modal-header">';
          echo '<h4 class="modal-title">Pedido</h4>';
          echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
        echo '</div>';

      echo '<form action="Ofertas.php" method="POST">';
      echo '<input type="hidden" name="idItem" id="idItem" value="'.$row['idItens'].'">';
        echo '<div class="modal-body">';
          echo "<div class='form-row'>";
            echo '<div class="form-group col-md-12">';
              echo '<label for="item" >Item</label>'; 
              echo '<input class="form-control" type="text" name="item" id="item" value="'.$row['item'].'" readonly>';
            echo '</div>';
          echo '</div>';

          echo '<div class="form-row">';
            echo '<div class="form-group col-md-6">';
              echo '<label for="quantidade">Quantidade</label>';
              echo '<input class="form-control" type="number" ng-model="qntd" name="quantidade" value=1 id="quantidade" required min="1" max="5">';
            echo '</div>';
            echo '<div class="form-group col-sm-6">';
              echo '<label for="valor">Valor</label>'; 
              echo '<input class="form-control" type="text" name="preco" id="preco" value={{'.$row['preco'].'*qntd}} readonly>';
            echo '</div>';
          echo '</div>';

         
          echo '<div class="form-row">';
            echo '<div class="form-group col-md-12">';
              echo '<label for="descricao">Observações:</label>';
                echo '<textarea class="form-control" name ="observacao" id="observacao" rows="3" placeholder="EX: Sem Queijo e chegar junto com bebida"></textarea>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
        
        echo '<div class="modal-footer">';
          echo '<button class="btn btn-success" name="realizarPedido" id="realizarPedido">Realizar Pedido</button>';
      echo '</form>';
          echo '<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>';
        echo '</div>';

        echo '</div>';
      echo '</div>';
    echo '</div>';
          }
          
        } else{
          echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
          echo 'Categoria sem produtos!!';
          echo '</div>'; 
         }
      echo "</div>";  
    }     
      ?>

          <br><br>

    </div>  
<?php
  include 'corpo/footer.html';

  // Realiza Pedido

  if(isset($_POST['realizarPedido'])){
    $preco = $_POST['preco'];
    $item = $_POST['item'];
    $quantidade=$_POST['quantidade'];
    $observacao=$_POST['observacao'];
    $mesa = $_SESSION['mesa'];
    $cpf = $_SESSION['cpf'];

    $consulta = $pdo->prepare("SELECT idUsuario FROM usuario where cpf = '$cpf' ");
    $consulta->execute();
    $rowIdUsuario = $consulta->fetch();
    $idUsuario = $rowIdUsuario['idUsuario'];

    $sql = $pdo->prepare("SELECT idItens FROM itens where item = '$item' ");
    $sql->execute();
    $rowIdItens = $sql->fetch();
    $idItem = $rowIdItens['idItens'];

    $pedido = $pdo->prepare("INSERT INTO pedido (horario,Itens_idItens,quantidade,status,observacao, valor, usuario_idUsuario, mesa_numero) 
                                VALUES ( now(), :idItens, :quantidade, 1, :observacao, :preco, :idUsuario, :mesa )");
        $pedido->execute(array(  
        ':idItens' => $idItem,
        ':quantidade' => $quantidade,
        ':observacao' => $observacao,
        ':preco' => $preco,
        ':idUsuario' => $idUsuario,
        ':mesa' => $mesa
        ));
    if($pedido == TRUE){
        print $_SESSION['msg'] =  '<div class="notification"><p>Pedido Realizado com Sucesso</p> <span class="notification__progress"></span></div>';
        die();
    } else{
        print "<script>alert('Falha ao realizar pedido');</script>";
        print "<script>location.href='Comanda.php';</script>";
        die();
    }

}

?>

</div>
</body>
</html>

