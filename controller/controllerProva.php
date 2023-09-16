<?php

require_once '../model/modelProva.php';

$prova = new Prova();

if ($_POST['op'] == 1) {

    $res = $prova->registaProva(
        $_POST['descricaoProva'],
        $_POST['clusterProva'],
        $_POST['idadeLimiteProva'],
    );

    echo ($res);

}else if($_POST['op'] == 2){

    $res = $prova -> listaProvas();
    echo($res);

}else if($_POST['op'] == 3){

    $res = $vinha -> removeObjeto($_POST['id']);

    echo($res);

}else if($_POST['op'] == 4){

    $res = $prova -> getDadosProva($_POST['id']);
    echo($res);

}else if($_POST['op'] == 5){

    $res = $prova->guardaEditProva(
        $_POST['id'],
        $_POST['descricaoProva'],
        $_POST['clusterProva'],
        $_POST['idadeLimite']
    );

    echo($res);

}else if ($_POST['op'] == 6) {

    $res = $prova -> getCluster();

    echo ($res);
}else if ($_POST['op'] == 7) {

    $res = $prova -> getProvas();

    echo ($res);
}

?>