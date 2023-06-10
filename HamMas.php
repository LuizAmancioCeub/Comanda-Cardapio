<?php 
    require ("conn/conn.php");
    session_start();
    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='Index.php';</script>";
    }
    
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Cardapio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
   
    
</head>

<body>
  <div class="container-fluid">
    <?php
          include "corpo/menu.php";
      ?>
              <h1>Hambúrgueres</h1>

              <?php
        
        $item = $pdo->prepare('SELECT item, descricao, preco, idItens FROM itens WHERE Categorias_idCategorias = 2 ORDER BY item ASC');
        $item->execute();
        echo "<div class='row row-cols-2 row-cols-md-3 g-4'>";
          if($item->rowCount() > 0){
            while($row = $item->fetch(PDO::FETCH_ASSOC)){
                echo "<input type='hidden' name='idItens' id='idItens' value='".$row['idItens']."'>";
                echo "<div class='col' style='border-radius:30px'>";
                  echo "<div class='card h-100'  style='border-radius:30px;'>";
                    echo "<img src='imagens/hamburguer2.jpg' class='card-img-top' style='border-top-left-radius:20px;border-top-right-radius:20px'>";
                    echo "<div class='card-body'>";
                      echo "<h5 class='card-title'>".$row['item']."</h5>";
                      echo "<p class='card-text'>".$row['descricao']."</p>";
                      echo "<p class='card-text'><b>Valor: R$".$row['preco']."</b></p>";
                    echo "</div>";
                    echo "<div class='card-footer'>";
                      echo "<div class='row d-flex justify-content-center'>";
                        echo "<button class='btn btn-success' type='button' data-toggle='modal' data-target='#pedido".$row['idItens']."'>Fazer Pedido</button>";
                      echo "</div>";
                        echo "</div>";
                  echo "</div>";
                echo "</div>";
  
      //MODAL
  
      echo '<div class="modal fade" id="pedido'.$row['idItens'].'" style="color: black">';
        echo '<div class="modal-dialog modal-dialog-centered">';
          echo '<div class="modal-content" style="border-radius:30px">';
                    
          echo '<div class="modal-header">';
            echo '<h4 class="modal-title">Pedido</h4>';
            echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
          echo '</div>';
  
        echo '<form action="acao.php" method="POST">';
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
  
            /*echo '<div class="form-row">';
                echo '<div class="form-group col-md-12">';
                  echo '<label for="time">Horário desejado </label>'; 
                  echo '<input class="form-control" type="time" name="time" id="time" min="08:00" max="22:30">';
                echo '</div>';
            echo '</div>'; */
  
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
            echo '<div class="container-fluid">';
              echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
              echo 'Categoria sem produtos!!';
              echo '</div>'; 
            echo '</div>';
          }
        echo "</div>";  
  
        ?><br><br>
      <h1>Massas</h1>

<?php

    $item = $pdo->prepare('SELECT item, descricao, preco, idItens FROM itens WHERE Categorias_idCategorias = 3 ORDER BY item ASC');
    $item->execute();
    echo "<div class='row row-cols-2 row-cols-md-3 g-4'>";
    if($item->rowCount() > 0){
    while($row = $item->fetch(PDO::FETCH_ASSOC)){
      echo "<input type='hidden' name='idItens' id='idItens' value='".$row['idItens']."'>";
      echo "<div class='col' style='border-radius:30px'>";
        echo "<div class='card h-100'  style='border-radius:30px;'>";
          echo "<img src='imagens/hamburguer2.jpg' class='card-img-top' style='border-top-left-radius:20px;border-top-right-radius:20px'>";
          echo "<div class='card-body'>";
            echo "<h5 class='card-title'>".$row['item']."</h5>";
            echo "<p class='card-text'>".$row['descricao']."</p>";
            echo "<p class='card-text'><b>Valor: R$".$row['preco']."</b></p>";
          echo "</div>";
          echo "<div class='card-footer'>";
            echo "<div class='row d-flex justify-content-center'>";
              echo "<button class='btn btn-success' type='button' data-toggle='modal' data-target='#pedido".$row['idItens']."'>Fazer Pedido</button>";
            echo "</div>";
              echo "</div>";
        echo "</div>";
      echo "</div>";

    //MODAL

    echo '<div class="modal fade" id="pedido'.$row['idItens'].'" style="color: black">';
    echo '<div class="modal-dialog modal-dialog-centered">';
    echo '<div class="modal-content" style="border-radius:30px">';
          
    echo '<div class="modal-header">';
    echo '<h4 class="modal-title">Pedido</h4>';
    echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    echo '</div>';

    echo '<form action="acao.php" method="POST">';
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

    /*echo '<div class="form-row">';
      echo '<div class="form-group col-md-12">';
        echo '<label for="time">Horário desejado </label>'; 
        echo '<input class="form-control" type="time" name="time" id="time" min="08:00" max="22:30">';
      echo '</div>';
    echo '</div>'; */

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
    echo '<div class="container-fluid">';
    echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
    echo 'Categoria sem produtos!!';
    echo '</div>'; 
    echo '</div>';
    }
    echo "</div>";  

?><br><br>
            
          
            
            
        </div>  
      <div>
  
  
  </div>

   <?php
    
    include 'corpo/footer.html'
  
   ?> 
</body>
</html>