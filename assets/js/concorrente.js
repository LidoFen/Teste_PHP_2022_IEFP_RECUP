function getTamanho() {

    let dados = new FormData();
    dados.append("op", 1);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#tamanhoConcorrente').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function getRegiao() {

    let dados = new FormData();
    dados.append("op", 2);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#regiaoConcorrente').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function registaConcorrente() {

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("nomeConcorrente", $('#nomeConcorrente').val());
    dados.append("ccConcorrente", $('#ccConcorrente').val());
    dados.append("nifConcorrente", $('#nifConcorrente').val());
    dados.append("emailConcorrente", $('#emailConcorrente').val());
    dados.append("tamanhoConcorrente", $('#tamanhoConcorrente').val());
    dados.append("idadeConcorrente", $('#idadeConcorrente').val());
    dados.append("regiaoConcorrente", $('#regiaoConcorrente').val());
    dados.append("fotoConcorrente", $('#fotoConcorrente').prop("files")[0]);



    $.ajax({
        url: "controller/controllerConcorrente.php",
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

            $("#nomeConcorrente").val("");
            $("#ccConcorrente").val("");
            $("#nifConcorrente").val("");
            $("#emailConcorrente").val("");
            $("#tamanhoConcorrente").val("-1");
            $("#idadeConcorrente").val("");
            $("#regiaoConcorrente").val("-1");
            $("#fotoConcorrente").val("");
            getConcorrentes();

        } else {
            alerta("Erro", obj.msg, "error");
            $("#idadeConcorrente").val("");
        }

    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
        
    });

}

function getProvas() {

    let dados = new FormData();
    dados.append("op", 4);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#provaInscricao').html(msg);
                $('#provaPontuacaoSelect').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function getConcorrentes() {

    let dados = new FormData();
    dados.append("op", 5);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#concorrenteInscricao').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function registaInscricao() {



    let dados = new FormData();
    dados.append("op", 6);
    dados.append("concorrenteInscricao", $('#concorrenteInscricao').val());
    dados.append("provaInscricao", $('#provaInscricao').val());



    $.ajax({
        url: "controller/controllerConcorrente.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

    .done(function (msg) {
        
        console.log(msg);

        let obj = JSON.parse(msg);
        if (obj.flag) {
            alerta("Sucesso", obj.msg, "success");

            $("#concorrenteInscricao").val("-1");
            $("#provaInscricao").val("-1");
            getConcorrentesInscritos();



        } else {
            alerta("Erro", obj.msg, "error");
            
        }

    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
        
    });

}

function getConcorrentesInscritos() {

    let dados = new FormData();
    dados.append("op", 7);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#concorrentePontuacao').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function getProvasInscricao(idConcorrenteInscrito) {

    let dados = new FormData();
    dados.append("op", 8);
    dados.append("idConcorrenteInscrito", idConcorrenteInscrito);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#provaPontuacao').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function registaPontuacao() {

    let dados = new FormData();
    dados.append("op", 9);
    dados.append("concorrentePontuacao", $('#concorrentePontuacao').val());
    dados.append("criterioPontuacao", $('#criterioPontuacao').val());
    dados.append("pontosPontuacao", $('#pontosPontuacao').val());



    $.ajax({
        url: "controller/controllerConcorrente.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

    .done(function (msg) {
        
        console.log(msg);

        let obj = JSON.parse(msg);
        if (obj.flag) {
            alerta("Sucesso", obj.msg, "success");

            $("#concorrentePontuacao").val("-1");
            $("#criterioPontuacao").val("-1");
            $("#pontosPontuacao").val("");



        } else {
            alerta("Erro", obj.msg, "error");
            
        }

    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
        
    });

}

function listaPontuacao(idProva){

    let dados = new FormData();
    dados.append("op", 10);
    dados.append("idProva", idProva);


    $.ajax({
        url: "controller/controllerConcorrente.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#corpoTabelaPontuacao').html(msg)
            
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function getCriteriosPontuacao(idProva) {

    let dados = new FormData();
    dados.append("op", 11);
    dados.append("idProva", idProva);
    
        $.ajax({
            url: "controller/controllerConcorrente.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#criterioPontuacao').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function getDadosConcorrenteProva(idProva, idConcorrente, totalAvaliacao, nomeConcorrente, nomeProva) {


    let dados = new FormData();
    dados.append("op", 12);
    dados.append("idProva", idProva);
    dados.append("idConcorrente", idConcorrente);
    dados.append("totalAvaliacao", totalAvaliacao);
    dados.append("nomeConcorrente", nomeConcorrente);
    dados.append("nomeProva", nomeProva);

    $.ajax({
        url: "controller/controllerConcorrente.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

    .done(function (msg) {
        let obj = JSON.parse(msg);
        $('#corpoTabelaInfoConcorrenteProva').html(obj.dadosTabela);
        $("#detalhesConcorrenteProva").html(obj.dadosCabecalho);
        $('#modalConcorrente').modal('show');
        
    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}


function alerta(titulo, msg, icon) {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: icon,
        title: titulo,
        text: msg,
    })
}

$(function () {
    getTamanho();
    getRegiao();
    getProvas();
    getConcorrentes();
    getConcorrentesInscritos();
});