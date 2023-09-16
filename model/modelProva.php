<?php

require_once 'connection.php';

/* CRUD BÁSICO COM FOTO E SELECT NO REGISTO */


class Prova {

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
          

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function registaProva($descricaoProva, $clusterProva, $idadeLimiteProva){

        global $conn;
        $msg = "";
        $flag = true;

    
        $sql = "INSERT INTO prova VALUES (NULL, '".$descricaoProva."', '".$clusterProva."', '".$idadeLimiteProva."')";
        

        if ($conn->query($sql) === TRUE) {
            // $ultimoId = mysqli_insert_id($conn); // CASO SEJA PRECISO

            $msg = "Prova registada com sucesso!";
            /*$resp = $this->uploads($argumentoFoto, $argumentoNomeDescricaoWhatever);
    
            $res = json_decode($resp, TRUE);
    
            if($res['flag']){
                $this->updateObjetoImg($res['target'], $ultimoId);
            }*/

        } else {
            $flag = false;
            $msg = "Erro: " . $sql . "<br>" . $conn->error;
        }
    
        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));
    
        return ($resp);    
    }
    
    function listaProvas() {

        global $conn;
        $msg = "";
        
        

        $sql = "SELECT prova.id, prova.descricao AS descricaoProva, prova.idade_limite, cluster.descricao AS descricaoCluster FROM prova INNER JOIN cluster on prova.id_cluster = cluster.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['id']."</td>";
                $msg .= "<td>".$row['descricaoProva']."</td>";
                $msg .= "<td>".$row['descricaoCluster']."</td>";
                $msg .= "<td>".$row['idade_limite']."</td>";
                $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosProva(".$row['id'].")'><i class='bi bi-pencil-fill'></i></button></td>";
                $msg .= "<tr>";

            }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados!</td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";
        }

        $conn->close();
    
        return ($msg);
    }

    function removeObjeto($id) {
        global $conn;
        $msg = "";
        $flag = true;
    
        
        $sql = "DELETE FROM tabela_objeto WHERE id=".$id;
        $result = $conn->query($sql);
    
        if ($conn->query($sql) === TRUE) {
            $msg = "Objeto removido com sucesso";
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

    function getDadosProva($id){
    
        global $conn;
        
        $msg = "";
        $msg1 = "";
    
        $sql = "SELECT prova.id, prova.descricao AS descricaoProva, prova.idade_limite, cluster.descricao AS descricaoCluster, cluster.id as idCluster FROM prova INNER JOIN cluster on prova.id_cluster = cluster.id WHERE prova.id = ".$id;
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    
        
        $sql1 = "SELECT id, descricao FROM cluster";
        $result1 = $conn->query($sql1);
    
        while ($row1 = $result1->fetch_assoc()) {
            
            $selecionado = ($row['idCluster'] == $row1['id']) ? 'selected' : '';
    
            
            $msg1 .= "<option value='" . $row1['id'] . "' " . $selecionado . ">" . $row1['descricao'] . "</option>";
        }
    
        $conn->close();
    
        $resp = array('dadosProva' => $row, 'dadosCluster' => $msg1);
    
        return json_encode($resp);
    }

    function guardaEditProva($id, $descricaoProva, $clusterProva, $idadeLimite){

        global $conn;
        $msg = "";
        $flag = true;
    
        $sql = "UPDATE prova SET descricao = '".$descricaoProva."',
            id_cluster = '".$clusterProva."',
            idade_limite = '".$idadeLimite."'
        WHERE id = ".$id;
        $result = $conn->query($sql);
    
        if ($conn->query($sql) === TRUE) {
            $msg = "Prova modificada com sucesso!";
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

