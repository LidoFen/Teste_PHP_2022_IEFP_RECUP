function registaCriterio() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("descricaoCriterio", $('#descricaoCriterio').val());
    dados.append("pontuacaoMinCriterio", $('#pontuacaoMinCriterio').val());
    dados.append("pontuacaoMaxCriterio", $('#pontuacaoMaxCriterio').val());
    dados.append("provaCriterio", $('#provaCriterio').val());


    $.ajax({
        url: "controller/controllerCriterio.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

    .done(function (msg) {

        let obj = JSON.parse(msg);
        if (obj.flag) {
            alerta("Sucesso", obj.msg, "success");

            listaCriterios();
            

            $("#descricaoCriterio").val("");
            $("#pontuacaoMinCriterio").val("");
            $("#pontuacaoMaxCriterio").val("");
            $("#provaCriterio").val("-1");

        } else {
            alerta("Erro", obj.msg, "error");
        }

    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function listaCriterios(){

    let dados = new FormData();
    dados.append("op", 2);


    $.ajax({
        url: "controller/controllerCriterio.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#corpoTabelaCriterios').html(msg)
            
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function removerCriterio(id) {

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerCriterio.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                listaCriterios();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getDadosCriterio(id) {

    let dados = new FormData();
    dados.append("op", 4);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerCriterio.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            let obj = JSON.parse(msg);
            $('#idCriterioEdit').val(obj.dadosCriterio.id);
            $('#descricaoCriterioEdit').val(obj.dadosCriterio.descricao);
            $('#pontuacaoMinCriterioEdit').val(obj.dadosCriterio.pontuacao_minima);
            $('#pontuacaoMaxCriterioEdit').val(obj.dadosCriterio.pontuacao_maxima);
            $('#provaCriterioEdit').html(obj.dadosProva);

            $('#modalCriterio').modal('show');

            $('#btnGuardar1').attr("onclick", "guardaEditCriterio(" + obj.dadosCriterio.id + ")")
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function guardaEditCriterio(id) {

    let dados = new FormData();
    dados.append("op", 5);
    dados.append("id", id);
    dados.append("descricaoCriterio", $('#descricaoCriterioEdit').val());
    dados.append("pontuacaoMinCriterio", $('#pontuacaoMinCriterioEdit').val());
    dados.append("pontuacaoMaxCriterio", $('#pontuacaoMaxCriterioEdit').val());
    dados.append("provaCriterio", $('#provaCriterioEdit').val());

    

    $.ajax({
        url: "controller/controllerCriterio.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                $('#modalCriterio').modal('hide');
                listaCriterios();

                $('#descricaoCriterioEdit').val("");    
                $('#pontuacaoMinCriterioEdit').val("");
                $('#pontuacaoMaxCriterioEdit').val("");
                

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

$(function () {
    listaCriterios();
});