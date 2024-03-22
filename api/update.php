<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put'){
    // Não sendo get ou post eu não consigo fazer a requisição dos valores a serem passados assim 
    //$body = filter_input(INPUT_POST, 'body');
    //então dessa maneira eu faço assim:
    
    //peguei http inteiro e joguei dentro da variável input
    parse_str(file_get_contents('php://input'), $input);

    //se no input houver id nos colocaremos o id se n colocaremos nulo
    $id =$input['id']?? null;
    $title =$input['title']??null;
    $body =$input['body']?? null;

    //processo de segurnça
    $id =filter_var($id);
    $body = filter_var($body);
    $title=filter_var($title);

    if($id && $body && $title){
        $sql = $pdo->prepare ("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        //se achou o valor fazer update
        if($sql->rowCount()>0){
                $sql= $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id=:id ");
                $sql ->bindValue(':title', $title);
                $sql -> bindValue(':body',$body);
                $sql -> bindValue(':id', $id);
                $sql->execute();
                $array['result'] =[
                   'id' => $id,
                   'title' => $title, 
                   'body' => $body
                ];



        }else{
            $array['result'] = 'Array não existe';
        }
    }else{
        $array['error'] = 'dados não enviados';
    }
    }else{
    $array['error'] = 'Método não permitido (APENAS PUT)';
}

require('../return.php');