function evento(elem){
    var id = $(elem).attr("id");
    if(id != -1){
        $.post( "index.php", {mes:document.getElementById("car_bloco_mes_nome").innerHTML,ano:document.getElementById("car_bloco_ano_nome").innerHTML,dia:id})
            .done(function( data ) {
                var c = JSON.parse(data);
                document.getElementById("consultas").innerHTML = "";
                if(c.length > 0){
                    document.getElementById("consultas").innerHTML += "<thead>" + "<tr style='width:100%;'>" + "<td id='nomeHead'>" + "Nome" + "</td>" + "<td id='dataConsultaHead'>" + "Data da Consulta" + "</td>" + "<td id='horarioHead'>" + "Horário" + "</td>" + "<td id='estadoHead'>" + "Estado" + "</td>" + "</tr>" + "</thead>";
                    c.forEach(cada);
                }
            })
            .fail(function() {
                alert("Error contate Charles");
            })
        ;
    }
};

function cada(e){
    document.getElementById("consultas").innerHTML += "<tr style='width:100%;'>" + "<td id='nome'>" + e.nome + "</td>" + "<td id='dataConsulta'>" + e.data_consulta + "</td>" + "<td id='horario'>" + e.horario + "</td>" + "<td id='estado'>" + ((e.estado == 'a') ? ("Agendado") : ((e.estado == 'c') ? ("Cancelado") : ("Realizado"))) + "</td>" + "</tr>";
}