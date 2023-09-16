<?php

require_once 'connection.php';

/* CRUD BÁSICO COM FOTO E SELECT NO REGISTO */


class Criterio {

    function uploads($foto, $argumentoNomeDescricaoWhatever){


        $dir = "../fotoObjeto/".$argumentoNomeDescricaoWhatever."/";
        $dir1 = "fotoObjeto/".$argumentoNomeDescricaoWhatever."/";
        $flag = false;
        $targetBD = "";
    
        if(!is_dir($dir)){
            if(!mkdir($dir, 0777, TRUE)){
                die ("Erro, não é possivel criar o diretório");
            }
        }
      if(array_key_exists('foto', $foto)){
        if(is_array($foto)){
          if(is_uploaded_file($foto['foto']['tmp_name'])){
            $fonte = $foto['foto']['tmp_name'];
            $ficheiro = $foto['foto']['name'];
            $end = explode(".",$ficheiro);
            $extensao = end($end);
    
            $newName = "foto_".$argumentoNomeDescricaoWhatever."_dataEnv_".date("Ymd_H_i_s").".".$extensao;
    
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

    function updateObjetoImg($diretorio, $ultimoId){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE tabela_objeto SET campo_imagem = '".$diretorio."' WHERE id =".$lastInsertedId;

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

    function registaCriterio($descricaoCriterio, $pontuacaoMinCriterio, $pontuacaoMaxCriterio, $provaCriterio){ // com Prepared Statements (sql inject safe)
        global $conn;
        $msg = "";
        $flag = true;
    
       
        $sql = "INSERT INTO criterios (descricao, pontuacao_minima, pontuacao_maxima, id_prova) VALUES (?, ?, ?, ?)";
    
        
        $stmt = $conn->prepare($sql);
    
        
        if ($stmt) {
        
            $stmt->bind_param('siii', $descricaoCriterio, $pontuacaoMinCriterio, $pontuacaoMaxCriterio, $provaCriterio);
    
            if ($stmt->execute()) {
                
                $msg = "Critério registado com sucesso!";
            } else {
                $flag = false;
                $msg = "Erro ao registar o critério: " . $stmt->error;
            }
            
            $stmt->close();

        } else {
            $flag = false;
            $msg = "Erro ao preparar a declaração: " . $conn->error;
        }

        $conn->close();
    
        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
    
        return ($resp);
    }
    
    function listaCriterios() {

        global $conn;
        $msg = "";
        
        

        $sql = "SELECT criterios.id, criterios.descricao, criterios.pontuacao_minima, criterios.pontuacao_maxima, prova.descricao as descricaoProva FROM criterios INNER JOIN prova ON criterios.id_prova = prova.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['descricaoProva']."</td>";
                $msg .= "<td>".$row['descricao']."</td>";
                $msg .= "<td>".$row['pontuacao_minima']."</td>";
                $msg .= "<td>".$row['pontuacao_maxima']."</td>";
                $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosCriterio(".$row['id'].")'><i class='bi bi-pencil-fill'></i></button></td>";
                $msg .= "<td><button class='btn btn-danger' onclick = 'removerCriterio(".$row['id'].")'><i class='bi bi-trash-fill'></i></button></td>";
                $msg .= "<tr>";

            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados!</td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";
        }

        $conn->close();
    
        return ($msg);
    }

    function removerCriterio($id) {
        global $conn;
        $msg = "";
        $flag = true;
    
        
        $sql = "DELETE FROM criterios WHERE id = ".$id;
        $result = $conn->query($sql);
    
        if ($conn->query($sql) === TRUE) {
            $msg = "Critério removido com sucesso!";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    
        $res = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
    
        return ($res);
    }

    function getDadosCriterio($id){
    
        global $conn;
        
        $msg = "";
        $msg1 = "";
    
        $sql = "SELECT criterios.id, criterios.descricao, criterios.pontuacao_minima, criterios.pontuacao_maxima, criterios.id_prova, prova.descricao as descricaoProva FROM criterios INNER JOIN prova ON criterios.id_prova = prova.id WHERE criterios.id = ".$id;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    
        
        $sql1 = "SELECT id, descricao FROM prova";
        $result1 = $conn->query($sql1);
    
        while ($row1 = $result1->fetch_assoc()) {
            
            $selecionado = ($row['id_prova'] == $row1['id']) ? 'selected' : '';
    
            
            $msg1 .= "<option value='" . $row1['id'] . "' " . $selecionado . ">" . $row1['descricao'] . "</option>";
        }
    
        $conn->close();
    
        $resp = array('dadosCriterio' => $row, 'dadosProva' => $msg1);
    
        return json_encode($resp);
    }

    function guardaEditCriterio($id, $descricaoCriterio, $pontuacaoMinCriterio, $pontuacaoMaxCriterio, $provaCriterio){

        global $conn;
        $msg = "";
        $flag = true;
    
        $sql = "UPDATE criterios SET descricao = '".$descricaoCriterio."',
            pontuacao_minima = '".$pontuacaoMinCriterio."',
            pontuacao_maxima = '".$pontuacaoMaxCriterio."',
            id_prova = '".$provaCriterio."'
        WHERE id = ".$id;
        $result = $conn->query($sql);
    
        if ($conn->query($sql) === TRUE) {
            $msg = "Critério modificado com sucesso!";
            /*$resp = $this->uploads($argumentoFoto, $argumentoNomeDescricaoWhatever);
            $res = json_decode($resp, TRUE);
    
            if ($res['flag']) {
                $this->updateVinhaImg($res['target'], $argumentoID);
            }*/
        } else {
            $flag = false;
            $msg = "Erro: " . $sql . "<br>" . $conn->error;
        }
    
        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        $conn->close();
    
        return $resp;
    }

    function getCluster(){

        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, descricao FROM cluster";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $msg .= "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
            }   
        
        } else {
            $msg = "<option value='-1' disabled>Sem Tipos Registados</option>";
        }

        $conn->close();

        return ($msg);
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


}




?>

