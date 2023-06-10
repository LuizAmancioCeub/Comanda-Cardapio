<?php
    if($_SESSION['nivel'] == 2){  
?>
    <form action="admin/Incluir_Item.php" method="POST" >
    <button class="btn btn-info" id="incluirItem" name="incluirItem">Adicionar item<i class="bi bi-plus-circle"></i></button>   
    </form>        
<?php 
    }
    
?>