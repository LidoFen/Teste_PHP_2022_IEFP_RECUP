<?php

require_once '../model/modelCriterio.php';

$criterio = new Criterio();

if ($_POST['op'] == 1) {

    $res = $criterio->registaCriterio(
        $_POST['descricaoCriterio'],
        $_POST['pontuacaoMinCriterio'],
        $_POST['pontuacaoMaxCriterio'],
        $_POST['provaCriterio']
    );  
    echo ($res);

}else if($_POST['op'] == 2){

    $res = $criterio -> listaCriterios();
    echo($res);

}else if($_POST['op'] == 3){

    $res = $criterio -> removerCriterio($_POST['id']);

    echo($res);

}else if($_POST['op'] == 4){

    $res = $criterio -> getDadosCriterio($_POST['id']);
    echo($res);

}else if($_POST['op'] == 5){

    $res = $criterio -> guardaEditCriterio(
        
        $_POST['id'],
        $_POST['descricaoCriterio'],
        $_POST['pontuacaoMinCriterio'],
        $_POST['pontuacaoMaxCriterio'],
        $_POST['provaCriterio']
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