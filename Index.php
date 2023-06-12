<?php
require('conn/conn.php');
    $mesas = $pdo->prepare("SELECT numero, capacidade, status from mesa WHERE status = 'Disponível' ORDER BY numero ASC");
    $mesas->execute();
    $rowMesas = $mesas->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Bem-Vindo</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
       
    </style>
    
</head>   
<body>  

<div class="container"> 
        <div class="card">
            <a class="login">Bem-Vindo !! <br>Preencha os campos para acessar nosso cardápio</a>
        <form action="acao.php" method="POST" > 

            <div class="inputBox">
                <label for="mesa"> Sua Mesa </label>
                <select name="mesa" id="mesa" required="required">
                    <option selected>Selecione</option>
                    <?php
                        foreach ($rowMesas as $linhamesas) {
                    ?>
                    <option name value="<?php echo $linhamesas['numero'] ?> "> Mesa <?php echo $linhamesas['numero']; echo ' -- '.$linhamesas['capacidade']; ?> Lugares </option>
                    <?php 
                  
                        } 
                    ?>
                </select>
            </div>   
            
            <div class="input">
                <input class="inputField" type="text" name="cpf" id="cpf" maxlength="11" required="required">
                <label for="cpf" class="input__label">CPF</label>
            </div>

            <div class="input">
                <input class="input__field" id="password" name="senha" type="password" required />
                <label for="password" class="input__label">Senha</label>
                <span class="input__icon-wrapper">
                    <i class="input__icon ri-eye-off-line"></i>
                </span>
            
            </div>
            <div class="form-group col-md-12">
                <button  id="cadastrar" name="cadastrar" class=" form-control btn btn-primary btn-block">Entrar</button> 
            </div>
        </form>
        <form action="acao.php" method="POST" >    
            <div style="margin-top:-45px" class="form-group col-md-12">
                <button  id="visitante" name="visitante" class=" form-control btn btn-success btn-block">Visitante</button> 
            </div>
        </form>
        
            <div style="margin-top:-30px" class="form-group col-md-12 d-flex justify-content-center"> 
                <a href="#registrar" data-toggle="modal">Não tem conta? Registra-se aqui</a>
            </div>
            <div style="margin-top:-30px" class="form-group col-md-12 d-flex justify-content-center"> 
                <a href="#esqueci" data-toggle="modal">Esqueci a Senha</a>
            </div>    
        </div>   
    </div>
       
</body>

    <div id="registrar" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Preencha os dados para se Registrar:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><br>
                <form action="acao.php" method="POST" >
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="form-label label label-info" for="nome"> Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" maxlength="12" required /> 
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="cpf">CPF</label>
                            <input type="text" id="cpfR" name="cpfR" class="form-control" required />  
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required />  
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control" required />  
                        </div><br>
                        <div class="form-group col-md-12">
                            <button  id="registrar" name="registrar" class=" form-control btn btn-primary btn-block">Registrar</button> 
                        </div>
                    </div>       
                </form>
            </div>
        </div>
    </div>

    <div id="esqueci" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Informe seus dados para alterar senha:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><br>
                <form action="acao.php" method="POST" >
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="form-label label label-info" for="cpf"> CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control" required /> 
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control" required />  
                        </div>
                        <div class="form-group col-md-12">
                            <button  id="alterarSenha" name="alterarSenha" class=" form-control btn btn-primary btn-block">Alterar Senha</button> 
                        </div>
                    </div>       
                </form>
            </div>
        </div>
    </div>


    <script>
        const inputIcon = document.querySelector('.input__icon')
        const inputPassword = document.querySelector('.input__field')

        inputIcon.addEventListener('click', () => {
            inputIcon.classList.toggle('ri-eye-off-line')
            inputIcon.classList.toggle('ri-eye-line')
            inputPassword.type =
                inputPassword.type === 'password' ? 'text' : 'password'
        })
    </script>      
        
</html>