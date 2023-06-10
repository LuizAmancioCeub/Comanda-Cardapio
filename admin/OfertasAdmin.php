
    <button class="btn btn-info" type="button" data-toggle='modal' data-target='#incluirItem'>Adicionar item <i class="bi bi-plus-circle"></i></button>   
       
<?php 


    $item = $pdo->prepare('SELECT item, descricao, preco, imagem, idItens, Categorias.categoria as categoria FROM itens 
                            JOIN categorias ON Categorias_idCategorias = idCategorias 
                            WHERE Categorias_idCategorias = 1 ORDER BY item ASC');
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
                    echo "<button style='border-radius:30px;' class='btn btn-success' type='button' data-toggle='modal' data-target='#alterarItem".$row['idItens']."'><i class='bi bi-pencil'></i></button>";
                    echo "<button style='border-radius:30px' class='btn btn-danger' type='button' data-toggle='modal' data-target='#excluirItem".$row['idItens']."'><i class='bi bi-trash3'></i></button>";   
                  echo "</div>";
                    echo "</div>";
              echo "</div>";
            echo "</div>";

  //MODAL para alterar Itens

  echo '<div class="modal fade" id="alterarItem'.$row['idItens'].'" style="color: black">';
    echo '<div class="modal-dialog modal-dialog-centered">';
      echo '<div class="modal-content" style="border-radius:30px">';
                
      echo '<div class="modal-header">';
        echo '<h4 class="modal-title">Alterar Item</h4>';
        echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
      echo '</div>';

    echo '<form action="admin.php" method="POST">';
    echo '<input type="hidden" name="idItem" id="idItem" value="'.$row['idItens'].'">';
      echo '<div class="modal-body">';
        
        echo "<div class='form-row'>";
          echo '<div class="form-group col-md-12">';
            echo '<label for="item" >Item</label>'; 
            echo '<input class="form-control" type="text" name="item" id="item" value="'.$row['item'].'" readonly>';
          echo '</div>';
        echo '</div>';

        $cat = $pdo->prepare("SELECT idCategorias, categoria from categorias ORDER BY categoria ASC");
        $cat->execute();
        $rowcat = $cat->fetchAll();
        echo "<div class='form-row'>";
          echo '<div class="form-group col-md-6">';
            echo '<label for="categoria" >Categoria</label>'; 
            echo '<select class="form-control" type="text" name="categoria" id="categoria">';
                echo '<option selected>'.$row['categoria'].'</option>';
                foreach ($rowcat as $linhacategorias) {
                   echo "<option name value='".$linhacategorias['idCategorias']."'>".$linhacategorias['categoria']."</option>";       
                } 
            echo '</select>';    
          echo '</div>';
          
          echo '<div class="form-group col-sm-6">';
            echo '<label for="valor">Valor</label>'; 
            echo '<input class="form-control" type="text" name="preco" id="preco" value='.$row['preco'].'>';
          echo '</div>';

        echo '</div>';

        echo '<div class="form-row">';
          echo '<div class="form-group col-md-12">';
            echo '<label for="imagem">Imagem</label>';
            echo '<input class="form-control" type="file" name="imagem" id="imagem" required>';
          echo '</div>';
        echo '</div>'; 

        echo '<div class="form-row">';
          echo '<div class="form-group col-md-12">';
            echo '<label for="descricao">Descrição:</label>';
              echo '<textarea class="form-control" name ="descricao" id="descricao" rows="3">'.$row['descricao'].'</textarea>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
      
      echo '<div class="modal-footer">';
        echo '<button class="btn btn-success" name="alterarItem" id="alterarItem">Alterar</button>';
    echo '</form>';
        echo '<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>';
      echo '</div>';

      echo '</div>';
    echo '</div>';
  echo '</div>';

  // MODAL para deletar Itens
  echo '<div class="modal fade" id="excluirItem'.$row['idItens'].'" style="color: black">';
  echo '<div class="modal-dialog modal-dialog-centered">';
      echo '<div class="modal-content" style="border-radius:30px">';
              
      echo '<div class="modal-header">';
      echo '<h3 class="modal-title">Excluir Item</h3>';
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
      echo '</div>';

  echo '<form action="admin.php" method="POST">';
  echo '<input type="hidden" name="idItens" id="idItens" value="'.$row['idItens'].'">';
      echo '<div class="modal-body">';
      echo "<div class='form-row'>";
          echo "<div class='col-md-12'>";
              echo "<h4 style='text-align:center; margin-top:-10px; margin-bottom:20px'>Excluir item?</h4>";
          echo "</div>";
      echo "</div>";
      echo '<div class="row d-flex justify-content-center">';
      echo "<div class='form-row'>";                                       
              echo '<button class="btn btn-success" name="excluirItem" id="excluirItem">SIM</button>';
  echo '</form>';
              echo '<button style="margin-left:10px" type="button" class="btn btn-danger" data-dismiss="modal">NÃO</button>';       
      echo "</div>";    
          
      echo '</div>';
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

       // MODAL para incluir itens
    
       echo '<div class="modal fade" id="incluirItem" style="color: black">';
       echo '<div class="modal-dialog modal-dialog-centered">';
         echo '<div class="modal-content" style="border-radius:30px">';
                   
         echo '<div class="modal-header">';
           echo '<h4 class="modal-title">Adicionar Item</h4>';
           echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
         echo '</div>';
   
       echo '<form action="admin.php" method="POST">';
         echo '<div class="modal-body">';
           
           echo "<div class='form-row'>";
             echo '<div class="form-group col-md-12">';
               echo '<label for="item" >Item</label>'; 
               echo '<input class="form-control" type="text" name="item" id="item" placeholder="Nome do Item" required>';
             echo '</div>';
           echo '</div>';
   
           echo "<div class='form-row'>";
             echo '<div class="form-group col-md-6">';
               echo '<label for="categoria" >Categoria do Item</label>'; 
               echo '<select class="form-control" type="text" name="categoria" id="categoria" required>';
                   echo '<option disable selected>Selecione</option>';
                   foreach ($rowcat as $linhacategorias) {
                      echo "<option name value='".$linhacategorias['idCategorias']."'>".$linhacategorias['categoria']."</option>";       
                   } 
               echo '</select>';    
             echo '</div>';

             echo '<div class="form-group col-sm-6">';
              echo '<label for="valor">Valor do Item</label>'; 
              echo '<input class="form-control" type="text" name="preco" id="preco">';
             echo '</div>';
           echo '</div>';
   
           echo '<div class="form-row">';
             echo '<div class="form-group col-md-12">';
               echo '<label for="imagem">Imagem</label>';
               echo '<input class="form-control" type="file" name="imagem" id="imagem" required>';
             echo '</div>';
           echo '</div>'; 
   
           echo '<div class="form-row">';
             echo '<div class="form-group col-md-12">';
               echo '<label for="descricao">Descrição:</label>';
                 echo '<textarea class="form-control" placehold="Acrescente uma descrição" name ="descricao" id="descricao" rows="3"></textarea>';
             echo '</div>';
           echo '</div>';
         echo '</div>';
         
         echo '<div class="modal-footer">';
           echo '<button class="btn btn-success" name="incluirItem" id="incluirItem">Adicionar Item</button>';
       echo '</form>';
           echo '<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>';
         echo '</div>';
   
         echo '</div>';
       echo '</div>';
     echo '</div>';
   
?>