<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post'){
    $title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');
    
    if($body && $title){
        $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:title, :body)");
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->execute();
        $id = $pdo->lastInsertId();
        $array['result'][] = [
            'id' =>$id
        ];
    }else{
        $array['error'] = 'dados não enviados';
    }

    
}else{
    $array['error'] = 'Método não permitido (APENAS POST)';
}

require('../return.php');