<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete'){
    // Não sendo get ou post eu não consigo fazer a requisição dos valores a serem passados assim 
    //$body = filter_input(INPUT_POST, 'body');
    //então dessa maneira eu faço assim:
    
    //peguei http inteiro e joguei dentro da variável input
    parse_str(file_get_contents('php://input'), $input);

    //se no input houver id nos colocaremos o id se n colocaremos nulo
    $id =$input['id']?? null;
   
    //processo de segurnça
    $id =filter_var($id);
   

    if($id){
        $sql = $pdo->prepare('SELECT * FROM notes WHERE id=:id');
        $sql->bindValue(':id', $id);
        $sql->execute();
        
        //se achou o valor fazer update
        if($sql->rowCount()>0){


                $sql= $pdo->prepare("DELETE FROM notes WHERE id =:id ");
                $sql->bindValue(':id', $id);
                $sql->execute();            
                


        }else{
            $array['error'] = 'id não existente';
        }
    }else{
        $array['error'] = 'id não enviados';
    }
    }else{
    $array['error'] = 'Método não permitido (APENAS DELETE)';
}

require('../return.php');