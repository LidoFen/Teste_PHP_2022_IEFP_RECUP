<?php

require_once 'connection.php';

class Concorrente {

    function uploads($foto, $nomeConcorrente){


        $dir = "../fotoConcorrente/".$nomeConcorrente."/";
        $dir1 = "fotoConcorrente/".$nomeConcorrente."/";
        $flag = false;
        $targetBD = "";
    
        if(!is_dir($dir)){
            if(!mkdir($dir, 0777, TRUE)){
                die ("Erro, não é possivel criar o diretório");
            }
        }
      if(array_key_exists('fotoConcorrente', $foto)){
        if(is_array($foto)){
          if(is_uploaded_file($foto['fotoConcorrente']['tmp_name'])){
            $fonte = $foto['fotoConcorrente']['tmp_name'];
            $ficheiro = $foto['fotoConcorrente']['name'];
            $end = explode(".",$ficheiro);
            $extensao = end($end);
    
            $newName = "foto_".$nomeConcorrente."_dataEnv_".date("Ymd_H_i_s").".".$extensao;
    
            $target = $dir.$newName;
            $targetBD = $dir1.$newName;
    
            $flag = move_uploaded_file($fonte, $target);
            
          } 
        }
      }
        return (json_encode(array(
            "flag" => $flag,
            "target" => $targetBD
        )));
    }

    function updateConcorrenteImg($diretorio, $ultimoId){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE concorrente SET foto = '".$diretorio."' WHERE id =".$ultimoId;

        if ($conn->query($sql) === TRUE) {
            $msg = "Imagem adicionada com sucesso";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn -> close();

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function getTamanho(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM tamanhos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Tamanhos Registados</option>";
        }

        $conn->close();

        return ($msg);
    }

    function getRegiao(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM regiao";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Regiões Registados</option>";
        }

        $conn->close();

        return ($msg);
    }

    function registaConcorrente($nomeConcorrente, $ccConcorrente, $nifConcorrente, $emailConcorrente, $tamanhoConcorrente, $idadeConcorrente, $regiaoConcorrente, $fotoConcorrente){ // com Prepared Statements (sql inject safe)
        global $conn;
        $msg = "";
        $flag = true;
    
        if($idadeConcorrente > 25) {
            
            $flag = false;
            $msg = "A sua idade não pode ser inferior a 25!";

        } else {
       
            $sql = "INSERT INTO concorrente (id, nome, cartao_cidadao, nif, email, id_tamanho, idade, id_regiao) VALUES (NULL, '".$nomeConcorrente."', '".$ccConcorrente."', '".$nifConcorrente."', '".$emailConcorrente."', '".$tamanhoConcorrente."', '".$idadeConcorrente."', '".$regiaoConcorrente."')";
        
            
            if ($conn->query($sql) === TRUE) {

                $ultimoId = mysqli_insert_id($conn); // CASO SEJA PRECISO

                $msg = "Concorrente registado com sucesso!";
                $resp = $this->uploads($fotoConcorrente, $nomeConcorrente);
        
                $res = json_decode($resp, TRUE);
        
                if($res['flag']){
                    $this->updateConcorrenteImg($res['target'], $ultimoId);
                }

            } else {
                $flag = false;
                $msg = "Erro: " . $sql . "<br>" . $conn->error;
            }
        }

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function getProvas(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM prova";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Provas Registados</option>";
        }

        $conn->close();

        return ($msg);
    }

    function getConcorrentes(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, nome FROM concorrente";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Concorrentes Registados</option>";
        }

        $conn->close();

        return ($msg);
    }

    function registaInscricao($concorrenteInscricao, $provaInscricao){

        global $conn;
        $msg = "";
        $flag = true;
    
        
        $sql1 = "SELECT idade FROM concorrente WHERE id = ".$concorrenteInscricao;
        $result1 = $conn->query($sql1);
    
        if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $idadeConcorrente = $row1['idade'];
    
            
            $sql2 = "SELECT idade_limite FROM prova WHERE id = ".$provaInscricao;
            $result2 = $conn->query($sql2);
    
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                $idadeLimiteProva = $row2['idade_limite'];
    
                if ($idadeConcorrente > $idadeLimiteProva) {
                    $flag = false;
                    $msg = "Erro: A idade do concorrente excede o limite da prova.";
                } else {
                    
                    $sql = "INSERT INTO inscricao (id_concorrente, id_prova, dth) VALUES ('".$concorrenteInscricao."', '".$provaInscricao."', NOW())";
                    $result = $conn->query($sql);

                    $ultimoId = mysqli_insert_id($conn);
                    
                    if ($result === TRUE) {
                        $msg = "Inscricao registada com sucesso!";

                        $sql3 = "SELECT criterios.id FROM criterios INNER JOIN prova ON criterios.id_prova = prova.id WHERE prova.id = ".$provaInscricao;
                        $result3 = $conn->query($sql3);

                        if ($result3->num_rows > 0) {

                            $row3 = $result3->fetch_assoc();
                            $idCriterio = $row3['id'];

                            $this -> registaResultados($idCriterio, $ultimoId, 0);
                        }
                    } else {
                        $flag = false;
                        $msg = "Erro: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }


        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
     
        return ($resp);
    }

    function registaResultados($idCriterio, $ultimoId, $pontosPontuacao) {

        global $conn;
        $flag = true;

        $sql = "INSERT INTO resultados VALUES (NULL, '".$idCriterio."', '".$ultimoId."', '".$pontosPontuacao."', NOW())";
        $result = $conn->query($sql);
        
        $conn->close();
        
    }

    function getConcorrentesInscritos(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT DISTINCT inscricao.id_concorrente, concorrente.nome FROM inscricao INNER JOIN concorrente ON inscricao.id_concorrente = concorrente.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id_concorrente'] . "'>" . $row['nome'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Concorrentes Inscritos</option>";
        }

        $conn->close();

        return ($msg);
    }

    function getProvasInscricao($idConcorrenteInscrito){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT prova.id, prova.descricao as nomeProva FROM prova INNER JOIN inscricao ON prova.id = inscricao.id_prova WHERE inscricao.id_concorrente =".$idConcorrenteInscrito;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['nomeProva'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled selected>Sem provas inscritas</option>";
        }

        $conn->close();

        return ($msg);
    }

    function registaPontuacao($concorrentePontuacao, $criterioPontuacao, $pontosPontuacao){

        global $conn;
        $msg = "";
        $flag = true;
    
        
        $sql = "SELECT criterios.id, criterios.descricao, criterios.pontuacao_minima, criterios.pontuacao_maxima, inscricao.id AS idInscricao 
        FROM criterios 
        INNER JOIN prova ON criterios.id_prova = prova.id 
        INNER JOIN inscricao ON prova.id = inscricao.id_prova 
        INNER JOIN concorrente ON inscricao.id_concorrente = concorrente.id 
        WHERE criterios.id = ".$criterioPontuacao." AND concorrente.id =".$concorrentePontuacao;

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pontuacao_minima = $row["pontuacao_minima"];
            $pontuacao_maxima = $row["pontuacao_maxima"];
            $idInscricao = $row["idInscricao"];
        
            if ($pontosPontuacao < $pontuacao_minima) {
                $flag = false;
                $msg = "Pontuação inferior á minima do critério!";
            } else if($pontosPontuacao > $pontuacao_maxima) {
                $flag = false;
                $msg = "Pontuação superior á máxima do critério!";
            } else {
                $this -> registaResultados($criterioPontuacao, $idInscricao, $pontosPontuacao);
                $msg = "Pontuação registada com sucesso";
            }
        }

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
     
        return ($resp);
    }

    function listaPontuacao($idProva) {

        global $conn;
        $msg = "";
        
        

        $sql = "SELECT concorrente.id AS idConcorrente, prova.id as idProva, prova.descricao as nomeProva, concorrente.nome AS nomeConcorrente, SUM(resultados.avaliacao) as totalAvaliacao 
        FROM concorrente 
        INNER JOIN inscricao ON concorrente.id = inscricao.id_concorrente 
        INNER JOIN resultados ON inscricao.id = resultados.id_inscricao 
        INNER JOIN prova ON inscricao.id_prova = prova.id 
        WHERE prova.id = ".$idProva." 
        GROUP BY concorrente.nome
        ORDER BY totalAvaliacao DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if ($row['nomeConcorrente'] !== null && $row['totalAvaliacao'] !== null) {
                    $msg .= "<tr>";
                    $msg .= "<td>".$row['nomeConcorrente']."</td>";
                    $msg .= "<td>".$row['totalAvaliacao']."</td>";
                    $msg .= "<td><button class='btn btn-primary' onclick='getDadosConcorrenteProva(".$row['idProva'].", ".$row['idConcorrente'].", ".$row['totalAvaliacao'].", \"".$row['nomeConcorrente']."\", \"".$row['nomeProva']."\")'>+</button></td>";
                    $msg .= "<tr>";
                } else {
                    $msg .= "<tr>";
                    $msg .= "<td></td>";
                    $msg .= "<td>Sem pontuações registadas!</td>";
                    $msg .= "<td></td>";
                    $msg .= "</tr>";
                }

            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados!</td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";
        }

        $conn->close();
    
        return ($msg);
    }

    function getCriteriosPontuacao($idProva){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT criterios.id, criterios.descricao FROM criterios INNER JOIN prova ON criterios.id_prova = prova.id WHERE prova.id =".$idProva;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled selected>Sem requisitos registados</option>";
        }

        $conn->close();

        return ($msg);
    }

    function getDadosConcorrenteProva($idProva, $idConcorrente, $totalAvaliacao, $nomeConcorrente, $nomeProva) {

        global $conn;
        $msg = "";
        $msg1 = "";

        $sql = "SELECT criterios.id as idCriterio, 
        criterios.descricao AS descricaoCriterio, 
        resultados.avaliacao 
        FROM criterios 
        INNER JOIN prova ON criterios.id_prova = prova.id 
        INNER JOIN inscricao ON prova.id = inscricao.id_prova 
        INNER JOIN concorrente ON inscricao.id_concorrente = concorrente.id 
        LEFT JOIN resultados ON inscricao.id = resultados.id_inscricao AND criterios.id = resultados.id_criterio
        WHERE concorrente.id = ".$idConcorrente." AND prova.id = ".$idProva."
        HAVING resultados.avaliacao <> 0";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                    $msg .= "<tr>";
                    $msg .= "<td>".$row['idCriterio']."</td>";
                    $msg .= "<td>".$row['descricaoCriterio']."</td>";
                    $msg .= "<td>".$row['avaliacao']."</td>";
                    $msg .= "<tr>";

                    $msg1 = "Concorrente <b>".$nomeConcorrente."</b> na <b>".$nomeProva."</b> com o total de <b>".$totalAvaliacao."</b> pontos";
            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados!</td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";

            $msg1 = "Concorrente ".$nomeConcorrente." na prova ".$nomeProva." com o total de ".$totalAvaliacao." pontos";
        }

        $resp = json_encode(array(
            "dadosTabela" => $msg,
            "dadosCabecalho" => $msg1
        ));

        return ($resp);
    }
}

?>