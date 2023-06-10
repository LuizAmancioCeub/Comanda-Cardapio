<?php 
    require ("conn/conn.php");

    session_start();

    if(isset($_POST['incluirItem'])){
        $item=$_POST['item'];
        $preco=$_POST['preco'];
        $descricao=$_POST['descricao'];
        $imagem = $_POST["imagem"];
        $categoria = $_POST['categoria'];

        $incluir = $pdo->prepare("INSERT INTO itens (item,preco,descricao, Categorias_idCategorias, imagem)
                                    VALUES (:item, :preco, :descricao, :categoria,:imagem)");
        $incluir->execute(array(
            ':item' => $item,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':categoria' => $categoria,
            ':imagem' => $imagem
        ));
        if($incluir == TRUE){
            print "<script>alert('Item adicionado com Sucesso');</script>";
            print "<script>location.href='Ofertas.php';</script>";
            die();
        } else{
            print "<script>alert('Falha ao adicionar pedido');</script>";
            print "<script>location.href='Ofertas.php';</script>";
            die();
        }                           
    }
   
   
    if(isset($_POST['alterarItem'])){
        $item=$_POST['item'];
        $preco=$_POST['preco'];
        $descricao=$_POST['descricao'];
        $imagem = $_POST["imagem"];

        $consulta = $pdo->prepare("SELECT idItens FROM itens where item = '$item' ");
        $consulta->execute();
        $rowIdItens = $consulta->fetch();
        $idItem = $rowIdItens['idItens'];

        $sql = $pdo->prepare('UPDATE itens SET imagem=:imagem, preco=:preco, descricao=:descricao
                                WHERE idItens=:idItens');
        $sql->execute(array(
            ':imagem' => $imagem,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':idItens' => $idItem
        )); 
        
        if($sql == TRUE){
            print "<script>location.href='Ofertas.php';</script>";
            $_SESSION['msg'] = "<script>alert('Item alterado com Sucesso');</script>";
            die();
        } else{
            print "<script>alert('Falha ao alterar pedido');</script>";
            print "<script>location.href='Ofertas.php';</script>";
            die();
        }

    }

    if(isset($_POST['excluirItem'])){
        $idItens=$_POST['idItens'];

        $cancelar = $pdo->prepare('DELETE FROM itens WHERE idItens=:idItens');
        $cancelar->execute(array(
            ':idItens' => $idItens
        ));

        if($cancelar == TRUE){
            $_SESSION['msg'] = "<script>alert('Item excluído com Sucesso');</script>";
            print "<script>location.href='Ofertas.php';</script>";
            die();
        } else{
            print "<script>alert('Falha ao excluir item');</script>";
            print "<script>location.href='Ofertas.php';</script>";
            die();
        }
    }

    ?>
