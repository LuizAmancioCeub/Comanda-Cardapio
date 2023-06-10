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
    
    function Mask($mask,$str){

        $str = str_replace(" ","",$str);
    
        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
    
    }
 ?>
<html ng-app>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sua Comanda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
   
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.4/angular.min.js"></script>
    
    
    <link rel="stylesheet" type="text/css" href="css/Comanda.css">
    <link rel="stylesheet" type="text/css" href="css/msg.css">
</head>

<body>

    <div class="container-fluid">

    <?php
        include "corpo/menu.php";

        echo " <h1>Comanda de ".$nome." </h1>"
    ?>

   <br>
    <?php
         $consulta1 = $pdo->prepare("SELECT idUsuario FROM usuario where cpf = '$cpf' ");
         $consulta1->execute();
         $rowIdUsuario = $consulta1->fetch();
         $idUsuario = $rowIdUsuario['idUsuario'];
        $sql = $pdo->prepare("SELECT * FROM pedido WHERE usuario_idUsuario = '$idUsuario'");
        $sql->execute();
        if($sql->rowCount() > 0){
    ?>
        <a class="badge badge-success bt" style="font-size: 18px" href="#pagamento">Fechar Comanda <i class="bi bi-journal-check"></i></a>
        <br><br>
        <div class="tabela">
          <h4><b>Pedidos em Preparo:</b></h4> 
          <?php
           

            $consulta = $pdo->prepare("SELECT idPedido,idItens,item, quantidade,valor,horario,observacao,preco FROM pedido JOIN itens ON idItens = Itens_idItens 
                                        WHERE usuario_idusuario = '$idUsuario' AND status =1 ORDER BY horario DESC");
            $consulta->execute();
            if($consulta->rowCount() > 0){
                    echo "<table>";
                        echo "<thead>";
                        echo "<tr>";
                            echo'<th>Num Pedido</th>';
                            echo'<th>Mesa</th>';
                            echo'<th>CPF</th>';
                            echo'<th>Pedido</th>';
                            echo'<th>Quantidade</th>';            
                            echo'<th>Observação</th>';
                            echo'<th>Valor</th>';
                            echo'<th>Horário do Pedido</th>';
                            echo'<th></th>';
                        echo'</tr>';
                        echo'</thead>';
                                        
                while($row = $consulta->fetch(PDO::FETCH_ASSOC)){ 
                        echo'<tbody>';                   
                            echo'<tr style="border-radius:20px;">';
                                echo '<input type="hidden" name="idItens" value="'.$row['idItens'].'">';
                                echo '<input type="hidden" name="idPedido" value="'.$row['idPedido'].'">';
                                echo'<td data-title="Num Pedido">'.$row['idPedido'].'</td>';
                                echo'<td data-title="Mesa">32</td>';
                                echo'<td data-title="CPF">'.Mask("###.###.###-##",$cpf).'</td>';
                                echo'<td data-title="Pedido">'.$row['item'].'</td>';
                                echo'<td data-title="Quantidade">'.$row['quantidade'].'</td>';
                                echo'<td data-title="Obs">'.$row['observacao'].'</td>';
                                echo'<td data-title="Valor">R$ '.$row['valor'].'</td>';
                                echo'<td data-title="Horário do Pedido">'.$row['horario'].'</td>';
                                echo"<td>";
                                echo"<button class='btn btn-info' data-toggle='modal' data-target='#alterarPedido".$row['idPedido']."'>Editar Pedido</button>";
                                echo"<button class='btn btn-danger' data-toggle='modal' data-target='#cancelarPedido".$row['idPedido']."' style='margin-top: 10px;'>Cancelar Pedido</button>";

                                echo"</td>";
                            echo"</tr>";
                        echo "</tbody>"; 
                        
                        // Modal
                        echo '<div class="modal fade" id="alterarPedido'.$row['idPedido'].'" style="color: black">';
                            echo '<div class="modal-dialog modal-dialog-centered">';
                                echo '<div class="modal-content"style="border-radius:30px">';
                                        
                                echo '<div class="modal-header">';
                                echo '<h4 class="modal-title">Altere seu Pedido</h4>';
                                echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
                                echo '</div>';

                            echo '<form action="Comanda.php" method="POST">';
                            echo '<input type="hidden" name="idItem" id="idItem" value="'.$row['idItens'].'">';
                            echo '<input type="hidden" name="idPedido" id="idPedido" value="'.$row['idPedido'].'">';
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
                                    echo '<input class="form-control" type="number" ng-model="qntd" name="quantidade" value="'.$row['quantidade'].'" id="quantidade" required min="1" max="5">';
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
                                        echo '<textarea class="form-control" name ="observacao" id="observacao" rows="3">'.$row['observacao'].'</textarea>';
                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                
                                echo '<div class="modal-footer">';
                                echo '<button class="btn btn-success" name="alterarPedido" id="alterarPedido">Alterar Pedido</button>';
                            echo '</form>';
                                echo '<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>';
                                echo '</div>';

                                echo '</div>';
                            echo '</div>';
                            echo '</div>';


                            echo '<div class="modal fade" id="cancelarPedido'.$row['idPedido'].'" style="color: black">';
                                echo '<div class="modal-dialog modal-dialog-centered">';
                                    echo '<div class="modal-content" style="border-radius:30px">';
                                            
                                    echo '<div class="modal-header">';
                                    echo '<h3 class="modal-title">Cancele seu Pedido</h3>';
                                    echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
                                    echo '</div>';

                                echo '<form action="Comanda.php" method="POST">';
                                echo '<input type="hidden" name="idItem" id="idItem" value="'.$row['idItens'].'">';
                                echo '<input type="hidden" name="idPedido" id="idPedido" value="'.$row['idPedido'].'">';
                                    echo '<div class="modal-body">';
                                    echo "<div class='form-row'>";
                                        echo "<div class='col-md-12'>";
                                            echo "<h4 style='text-align:center; margin-top:-10px; margin-bottom:20px'>Deseja cancelar seu pedido?</h4>";
                                        echo "</div>";
                                    echo "</div>";
                                    echo '<div class="row d-flex justify-content-center">';
                                    echo "<div class='form-row'>";                                       
                                            echo '<button class="btn btn-success" name="cancelarPedido" id="cancelarPedido">SIM</button>';
                                echo '</form>';
                                            echo '<button style="margin-left:10px" type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>';       
                                    echo "</div>";    
                                        
                                    echo '</div>';
                                    echo '</div>';

                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';
                }
                    echo '</table>';
            } else{
                echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
                echo 'Sem pedidos em preparo!';
                echo '</div>';
            } ?>
        </div><br><br>

        <div class="tabela" >
            <h4><b>Pedidos já entregues:</b></h4>  

        <?php
        $cpf = $_SESSION['cpf'];
        $consulta1 = $pdo->prepare("SELECT idUsuario FROM usuario where cpf = '$cpf' ");
        $consulta1->execute();
        $rowIdUsuario = $consulta1->fetch();
        $idUsuario = $rowIdUsuario['idUsuario'];

            $consulta2 = $pdo->prepare("SELECT idPedido,idItens,item, quantidade,valor,horario,observacao,preco FROM pedido JOIN itens ON idItens = Itens_idItens 
                                            WHERE Usuario_idUsuario = '$idUsuario' AND status =2 ORDER BY horario DESC");
            $consulta2->execute();
            if($consulta2->rowCount() > 0){
        ?>  
            <table>
                  <thead>
                  <tr>
                      <th>Num Pedido</th>
                      <th>Mesa</th>
                      <th>Pedido</th>
                      <th>Quantidade</th>
                      <th>Cliente</th>
                      <th>Observação</th>
                      <th>Valor</th>
                      <th>Horário Entrega</th>                      
                      <th></th>
                  </tr>
                  </thead>
        <?php
                while($row2 = $consulta2->fetch(PDO::FETCH_ASSOC)){
                    echo '<tbody>';
                    echo '<tr style="border-radius:20px;background-color:rgba(220, 220, 220, 0.45);>';
                    echo '<input type="hidden" name="idItens" value="'.$row2['idItens'].'">';
                    echo '<input type="hidden" name="idPedido" value="'.$row2['idPedido'].'">';
                    echo'<td data-title="Num Pedido">'.$row2['idPedido'].'</td>';
                    echo'<td data-title="Mesa">32</td>';
                    echo'<td data-title="CPF">'.Mask("###.###.###-##",$cpf).'</td>';
                    echo'<td data-title="Pedido">'.$row2['item'].'</td>';
                    echo'<td data-title="Quantidade">'.$row2['quantidade'].'</td>';
                    echo'<td data-title="Obs">'.$row2['observacao'].'</td>';
                    echo'<td data-title="Valor">R$ '.$row2['valor'].'</td>';
                    echo'<td data-title="Horário Entrega">'.$row2['horario'].'</td>';
                        echo'<td>';
                        echo'<button class="btn btn-info">Ver no cardápio</button>';
           
                        echo'</td>';
                    echo'</tr>';
    
                    
                }
                echo'<tr id="pagamento" >';

                    $valorT = $pdo->prepare("SELECT SUM(valor) AS valorTotal FROM pedido WHERE usuario_idUsuario = '$idUsuario' AND status =2 ");
                    $valorT->execute();
                    $rowValorT = $valorT->fetch();
                    $valorTotal = $rowValorT['valorTotal'];
                    $valorTotal = number_format($valorTotal, 2, '.', '');
                    
                      echo'<td data-title = "Valor Total">R$ '.$valorTotal.' </td>';
                      echo'<td>';
                          echo'<button class="btn btn-warning">Pagamento</button>';
                      echo'</td>';
                    echo'</tr>';
                    
                    echo'</tbody>'; 
            ?>     
            </table>
            <?php             
            } else{
                echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
                echo 'Ainda sem pedidos entregues!<br><br> Você só poderá fechar comanda quando todos pedidos estiverem entregues';
                echo '</div>'; 
            } ?>
        </div>
  
        <?php 
        } else{
            echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
            echo 'Você ainda não pediu! Faça seu pedido e aproveite.<br><br>';
            echo '<a class="btn btn-success" href="Ofertas.php">Visualizar Cardápio</a>';
            echo '</div>';
        }
        ?>
<br>
       
    </div> 
    
</body>
</html>

<?php
             if(isset($_POST['alterarPedido'])){
                $idPedido=$_POST['idPedido'];
                $quantidade=$_POST['quantidade'];
                $preco=$_POST['preco'];
                $observacao=$_POST['observacao'];
        
                $sql = $pdo->prepare('UPDATE pedido SET quantidade=:quantidade, valor=:preco, observacao=:observacao
                                        WHERE idPedido=:idPedido');
                $sql->execute(array(
                    ':quantidade' => $quantidade,
                    ':preco' => $preco,
                    ':observacao' => $observacao,
                    ':idPedido' => $idPedido
                )); 
                
                if($sql == TRUE){
                    print "<script>alert('Pedido alterarado com Sucesso');</script>";
                    print "<script>location.href='Comanda.php';</script>";
                    die();
                } else{
                    print "<script>alert('Falha ao alterar pedido');</script>";
                    print "<script>location.href='Comanda.php';</script>";
                    die();
                }
        
            }

            if(isset($_POST['cancelarPedido'])){
                $idPedido=$_POST['idPedido'];

                $cancelar = $pdo->prepare('DELETE FROM pedido WHERE idPedido=:idPedido');
                $cancelar->execute(array(
                    ':idPedido' => $idPedido
                ));

                if($cancelar == TRUE){
                    print "<script>alert('Pedido Cancelado com Sucesso');</script>";
                    print "<script>location.href='Comanda.php';</script>";
                    die();
                } else{
                    print "<script>alert('Falha ao cancelar pedido');</script>";
                    print "<script>location.href='Comanda.php';</script>";
                    die();
                }
            }
?>