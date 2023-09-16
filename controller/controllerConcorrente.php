<?php

require_once '../model/modelConcorrente.php';

$concorrente = new Concorrente();

if ($_POST['op'] == 1) {


    $res = $concorrente -> getTamanho();

    echo ($res);
}else if ($_POST['op'] == 2) {


    $res = $concorrente -> getRegiao();

    echo ($res);
}else if ($_POST['op'] == 3) {


    $res = $concorrente -> registaConcorrente(
        $_POST['nomeConcorrente'],
        $_POST['ccConcorrente'],
        $_POST['nifConcorrente'],
        $_POST['emailConcorrente'],
        $_POST['tamanhoConcorrente'],
        $_POST['idadeConcorrente'],
        $_POST['regiaoConcorrente'],
        $_FILES
    );

    echo ($res);
}else if ($_POST['op'] == 4) {


    $res = $concorrente -> getProvas();

    echo ($res);
}else if ($_POST['op'] == 5) {


    $res = $concorrente -> getConcorrentes();

    echo ($res);
}else if ($_POST['op'] == 6) {


    $res = $concorrente -> registaInscricao(
        $_POST['concorrenteInscricao'],
        $_POST['provaInscricao']
    );

    echo ($res);
}else if ($_POST['op'] == 7) {


    $res = $concorrente -> getConcorrentesInscritos();

    echo ($res);
}else if ($_POST['op'] == 8) {


    $res = $concorrente -> getProvasInscricao($_POST['idConcorrenteInscrito']);

    echo ($res);
}else if ($_POST['op'] == 9) {


    $res = $concorrente -> registaPontuacao(
        $_POST['concorrentePontuacao'],
        $_POST['criterioPontuacao'],
        $_POST['pontosPontuacao']
    );

    echo ($res);
}else if($_POST['op'] == 10){

    $res = $concorrente -> listaPontuacao($_POST['idProva']);
    echo($res);

}else if ($_POST['op'] == 11) {


    $res = $concorrente -> getCriteriosPontuacao($_POST['idProva']);

    echo ($res);
}else if($_POST['op'] == 12){

    $res = $concorrente -> getDadosConcorrenteProva(
        $_POST['idProva'], 
        $_POST['idConcorrente'],
        $_POST['totalAvaliacao'],
        $_POST['nomeConcorrente'],
        $_POST['nomeProva']
    );
    echo($res);

}



?>