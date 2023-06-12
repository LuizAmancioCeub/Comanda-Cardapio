<?php
require('conn/conn.php');    
   
session_start();

// Acessar Login



    if(isset($_POST['cadastrar'])){
        
        $senha=$_POST['senha'];
        $cpf=$_POST['cpf'];
        $mesa=$_POST['mesa'];
        
        $nv = $pdo->prepare("SELECT perfil_nivel FROM usuario WHERE cpf = :cpf AND senha = :senha");
        $nv->execute(array(
            ':senha' => $senha,
            ':cpf' => $cpf
        ));
        $rowR = $nv->fetch();
        $nivel = $rowR['perfil_nivel'];
        
        $result = $pdo->prepare("SELECT * FROM usuario WHERE cpf = :cpf AND senha = :senha AND perfil_nivel = :nivel");
        $result->execute(array(
            ':senha' => $senha,
            ':cpf' => $cpf,
            ':nivel' => $nivel
        ));

        if($result->rowCount() > 0){ 
            $_SESSION['senha'] = $senha;
            $_SESSION['cpf'] = $cpf;
            $_SESSION['nivel'] = $nivel;
            $_SESSION['mesa'] = $mesa;
                            
            print "<script>location.href='Home.php';</script>";
            die();        
        
        } else{
            
                unset ($_SESSION['senha']);
                unset ($_SESSION['cpf']);
                print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
                echo $nivel;
                print "<script>location.href='Index.php';</script>"; 
                die();              
            }            
        

        
    }

    if(isset($_POST['visitante'])){
        $result = $pdo->prepare("SELECT * FROM usuario WHERE cpf = 'visitante' AND senha = 'visitante' AND perfil_nivel = 0");
        $result->execute();

        if($result->rowCount() > 0){
            $_SESSION['senha'] = 'visitante';
            $_SESSION['cpf'] = 'visitante';
            $_SESSION['nivel'] = 0;
            print "<script>location.href='Home.php';</script>";
            die();
        }
    }

    

    // Registrar Login
    if(isset($_POST['registrar'])){
        $senha=$_POST['senha'];
        $cpf=$_POST['cpfR'];
        $email=$_POST['email'];
        $nome=$_POST['nome']; 
        
        $consulta = $pdo->prepare('SELECT * FROM usuario WHERE cpf = :cpfR OR email = :email');
        $consulta->execute(array(
            ':email' => $email,
            ':cpfR' => $cpf
        ));
        if($consulta->rowCount() > 0){
            print "<script>alert('Cliente já cadastrado, faça o login');</script>";
            print "<script>location.href='Index.php';</script>";
        }
        else{
            $sql = $pdo->prepare("INSERT INTO usuario (nome,cpf,email,senha,perfil_nivel) VALUES (:nome,:cpf,:email,:senha,1)");
            $sql->execute(array(
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senha,
                ':cpf' => $cpf
            ));
            if($sql == TRUE){
                print "<script>alert('Cadastrado com Sucesso');</script>";
                print "<script>location.href='Index.php';</script>";
            } else{
                print "<script>alert('Falha');</script>";
                print "<script>location.href='Index.php';</script>";
            }
        }

       
    }

    //Pedido
    
    if(isset($_POST['realizarPedido'])){
        $preco = $_POST['preco'];
        $item = $_POST['item'];
        $quantidade=$_POST['quantidade'];
        $observacao=$_POST['observacao'];
        $cpf = $_SESSION['cpf'];

        $consulta = $pdo->prepare("SELECT idUsuario FROM usuario where cpf = '$cpf' ");
        $consulta->execute();
        $rowIdUsuario = $consulta->fetch();
        $idUsuario = $rowIdUsuario['idUsuario'];

        $sql = $pdo->prepare("SELECT idItens FROM itens where item = '$item' ");
        $sql->execute();
        $rowIdItens = $sql->fetch();
        $idItem = $rowIdItens['idItens'];

        $pedido = $pdo->prepare("INSERT INTO pedido (horario,Itens_idItens,quantidade,status,observacao, valor, usuario_idUsuario) 
                                    VALUES ( now(), :idItens, :quantidade, 1, :observacao, :preco, :idUsuario )");
            $pedido->execute(array(  
            ':idItens' => $idItem,
            ':quantidade' => $quantidade,
            ':observacao' => $observacao,
            ':preco' => $preco,
            ':idUsuario' => $idUsuario
            ));
        if($pedido == TRUE){
           print  "<script>location.href='Ofertas.php';</script>";
           print $_SESSION['msg'] =  '<div class="notification"><p>Pedido Realizado com Sucesso</p> <span class="notification__progress"></span></div>';
            die();
        } else{
            print "<script>alert('Falha ao realizar pedido');</script>";
            print "<script>location.href='Comanda.php';</script>";
            die();
        }

    }

    // Sair do Login 
    if((isset($_POST['sair'])) || (isset($_POST['sairM']))){
        session_destroy();
        print "<script>location.href='Index.php';</script>";
        
    }

?>