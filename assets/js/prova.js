function getCluster() {

    let dados = new FormData();
    dados.append("op", 6);
    
        $.ajax({
            url: "controller/controllerProva.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#clusterProva').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function getProvas() {

    let dados = new FormData();
    dados.append("op", 7);
    
        $.ajax({
            url: "controller/controllerProva.php",
            method: "POST",
            data: dados,
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
        })
    
            .done(function (msg) {
                $('#provaCriterio').html(msg);
    
            })
    
            .fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

}

function registaProva() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("descricaoProva", $('#descricaoProva').val());
    dados.append("clusterProva", $('#clusterProva').val());
    dados.append("idadeLimiteProva", $('#idadeLimiteProva').val());



    $.ajax({
        url: "controller/controllerProva.php",
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
            getCluster();
            
            listaProvas();

            $("#descricaoProva").val("");
            $("#clusterProva").val("");
            $("#idadeLimiteProva").val("");

        } else {
            alerta("Erro", obj.msg, "error");
        }

    })

    .fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });

}

function listaProvas(){

    let dados = new FormData();
    dados.append("op", 2);


    $.ajax({
        url: "controller/controllerProva.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#corpoTabelaProvas').html(msg)
            
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

}

function removeObjeto(id) {

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerObjeto.php",
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
                listagem();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getDadosProva(id) {

    let dados = new FormData();
    dados.append("op", 4);
    dados.append("id", id);

    $.ajax({
        url: "controller/controllerProva.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            let obj = JSON.parse(msg);
            $('#idProvaEdit').val(obj.dadosProva.id);
            $('#descricaoProvaEdit').val(obj.dadosProva.descricaoProva);
            $('#idadeLimiteProvaEdit').val(obj.dadosProva.idade_limite);
            $('#clusterProvaEdit').html(obj.dadosCluster);

            $('#modalProva').modal('show');

            $('#btnGuardar').attr("onclick", "guardaEditProva(" + obj.dadosProva.id + ")")
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function guardaEditProva(id) {

    let dados = new FormData();
    dados.append("op", 5);
    dados.append("id", id);
    dados.append("descricaoProva", $('#descricaoProvaEdit').val());
    dados.append("clusterProva", $('#clusterProvaEdit').val());
    dados.append("idadeLimite", $('#idadeLimiteProvaEdit').val());

    

    $.ajax({
        url: "controller/controllerProva.php",
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
                $('#modalProva').modal('hide');
                listaProvas();

                $('#descricaoProvaEdit').val("");    
                $('#idadeLimiteProvaEdit').val("");

            } else {
                alerta("Erro", obj.msg, "error");
            }

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
    getProvas();
    listaProvas()
    getCluster();
});