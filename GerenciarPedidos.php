<?php 
    require ("conn/conn.php");
    session_start();
    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true) or ($_SESSION['nivel'] !== 2))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='../Index.php';</script>";
    }
   
 ?>

<!DOCTYPE html>
<html>
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

    <link rel="stylesheet" type="text/css" href="css/Cards.css">

</head>

<body>

<div class="container-fluid">

<?php
    include "corpo/menu.php";
?>  

      <h1 style="text-align: center;">Pedidos</h1>
    
    <div class="cards">

    <?php
      $pedidos = $pdo->prepare("SELECT idPedido, idItens,nome,cpf, item, descricao, imagem, mesa_numero, quantidade, horario, observacao FROM pedido 
                                              JOIN itens on Itens_idItens = idItens 
                                              JOIN usuario on usuario_idUsuario = idUsuario
                                              WHERE status = 1 ORDER BY horario ASC");
      $pedidos->execute();

      if($pedidos->rowCount() > 0){
        while($row = $pedidos->fetch(PDO::FETCH_ASSOC)){  
          $row['horario'] = date('H:i:s', strtotime($row["horario"]))
    ?>
        <div class="cardi">
            <img src="imagens/<?php echo $row['imagem'] ?>"/>
            <h2> <?php echo $row['item'] ?> </h2>

            <div class="row">
              <div class="col-md-6">
                <input type="text" value="<?php echo $row['nome'] ?>" style="background: transparent;border:none" readonly="">
              </div>
              <div class="col-md-6">
                <input type="text" value="Mesa <?php echo $row['mesa_numero'] ?>" style="background: transparent;border:none" readonly="">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <input type="text" value="Horário: <?php echo $row['horario'] ?>" style="background: transparent;border:none" readonly="">
              </div>
              <div class="col-md-6">
                <input type="text" value="Qntd: <?php echo $row['quantidade'] ?>" style="background: transparent;border:none" readonly="">
              </div>
            </div><br>

            <div class="row">
              <div class="form-group col-md-12">
                <textarea style="font-weight: bolder;background: transparent;border-radius:10px" class="form-control" name ="observacao" id="observacao" rows="2" placeholder="<?php echo $row['observacao'] ?>"readonly=""></textarea>
              </div>
            </div>

            <hr>
            <div class='row d-flex justify-content-center'>        
                <button class="btn" data-toggle="modal" data-target="#enviarPedido<?php echo $row['idPedido'] ?>" style="background: transparent;"><i style="font-size: 25px;color:green" class="bi bi-check-lg"></i></button>
                <button class="btn" data-toggle="modal" data-target="#cancelarPedido<?php echo $row['idPedido'] ?>" style="background: transparent;margin-left:30px"><i style="font-size: 20px;color:red" class="bi bi-x-lg"></i></button>   
            </div>        
          </div>


          
                                <div class="modal fade" id="cancelarPedido<?php echo $row['idPedido'] ?>" style="color:black;">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style=" border-radius:5px;background-color:#f8f3e8;box-shadow: 0 0 40px rgba(0, 0, 0, 0.2), 0 0 40px rgba(0, 0, 0, 0.2);">                                             
                                      <div class="modal-header">
                                        <h3 class="modal-title" style=" font-family: Kalam, cursive;font-weight: normal;"> <?php echo $row['item'] ?> - Mesa <?php echo $row['mesa_numero'] ?></h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                    <form action="admin.php" method="POST">
                                      <input type="hidden" name="idItens" value="<?php echo $row['idItens'] ?>">
                                      <input type="hidden" name="idPedido" value="<?php echo $row['idPedido'] ?>">

                                        <div class="modal-body">
                                          <div class='form-row'>
                                              <div class='form-group col-md-12'>
                                                  <h4 style=' margin-top:-10px; margin-bottom:5px'>Motivo do Cancelamento:</h5>
                                                  <textarea style="font-weight: bolder;background: transparent;border-radius:10px" class="form-control" name ="motivo" id="motivo" rows="1" required></textarea>
                                              </div>
                                          </div>

                                          <div class="row d-flex justify-content-center">
                                            <div class='form-row'>                                      
                                                    <button class="btn btn-danger" name="cancelarPedido" id="cancelarPedido">Cancelar Pedido</button>
                                            </div>  
                                    </form> 
                                          </div>
                                        </div>

                                    </div>
                                  </div>
                                </div>


                                <div class="modal fade" id="enviarPedido<?php echo $row['idPedido'] ?>" style="color:black;">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style=" border-radius:5px;background-color:#f8f3e8;box-shadow: 0 0 40px rgba(0, 0, 0, 0.2), 0 0 40px rgba(0, 0, 0, 0.2);">                                             
                                      <div class="modal-header">
                                        <h3 class="modal-title" style=" font-family: Kalam, cursive;font-weight: normal;"> <?php echo $row['item'] ?> - Mesa <?php echo $row['mesa_numero'] ?></h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                    <form action="admin.php" method="POST">
                                      <input type="hidden" name="idItens" value="<?php echo $row['idItens'] ?>">
                                      <input type="hidden" name="idPedido" value="<?php echo $row['idPedido'] ?>">

                                        <div class="modal-body">
                                          <div class='form-row'>
                                              <div class='form-group col-md-12' style="text-align:center">
                                                  <h4 style=' margin-top:-10px; margin-bottom:5px'>Confirmar Envio desse Pedido?</h5>
                                              </div>
                                          </div>

                                          <div class="row d-flex justify-content-center">
                                            <div class='form-row'>                                      
                                                    <button class="btn btn-success" name="enviarPedido" id="enviarPedido">Enviar</button>
                                            </div>  
                                    </form> 
                                          </div>
                                        </div>

                                    </div>
                                  </div>
                                </div>
        
                               
<?php 
      }
    } 
      else{
        echo '<div style="text-align:center" class="alert alert-warning" role="alert">';
          echo 'Ainda sem pedidos!!';
        echo '</div>';
      }
?>
        
    </div>
    
   


   
</body>
</html>