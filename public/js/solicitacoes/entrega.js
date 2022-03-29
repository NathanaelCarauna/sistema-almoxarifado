function showItens(id) {
    $("#overlay").show();

    $("#detalhesSolicitacao").modal('show');

    $('#numSolicitacao').text(id);

    $.ajax({
        url: '/observacao_solicitacao/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#textObservacaoRequerente').text(data[0]['observacao_requerente']);
            $('#textObservacaoAdmin').text(data[0]['observacao_admin']);
            $('#inputNomeReceptor').val(data[0]['receptor']);
            $('#inputRgReceptor').val(data[0]['receptor_rg']);
            $('#inputTipoReceptor').val(data[0]['receptor_tipo']);
        }
    });

    $.ajax({
        url: '/itens_solicitacao_admin/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ret = '';
            for (var item in data) {
                ret += "<tr>";
                ret += "<td>" + data[item]['nome'] + "</td>";
                ret += "<td>" + data[item]['descricao'] + "</td>";
                ret += "<td style=\"width: 12%; text-align: center\">" + data[item]['corredor'] + "-" + data[item]['prateleira'].toUpperCase() + "-" + data[item]['coluna'] + "</td>";
                ret += "<td style=\"text-align: center\">" + data[item]['quantidade_solicitada'] + "</td>";
                ret += "<td style=\"text-align: center\">" + (data[item]['quantidade_aprovada'] == null ? '' : data[item]['quantidade_aprovada']) + "</td>";
                ret += "</tr>";
            }

            $('#solicitacaoID').val(id);
            $("#tableItens tbody").append(ret);
            $("#overlay").hide();
            $("#modalBody").show();
            $('#aprovar_entrega').show();
            $('#cancelar_entrega').show();
        }
    });
}

$(function () {
    var buttonSubmitID = "";

    var table = $('#tableSolicitacoes').DataTable({
        searching: false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "zeroRecords": "Nenhum registro disponível",
            "paginate": {
                "previous": "Anterior",
                "next": "Próximo"
            }
        },
        "order": [],
        "columnDefs": [{
            "targets": [2],
            "orderable": false
        }]
    });

    $('#tableSolicitacoes tbody').on('click', 'td.expandeOption', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var id = tr.data('id');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            $.ajax({
                url: '/itens_solicitacao_admin/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var ret = '<table id=\"tableExpanded\" class=\"table table-hover table-responsive-md\"">' +
                        '<thead>' +
                        '<tr>' +
                        '<th scope=\"col\" class=\"align-middle\">Material</th>' +
                        '<th scope=\"col\" class=\"align-middle\">Descrição</th>' +
                        '<th scope=\"col\" style=\"text-align: center; width: 10%\">Qtd. Solicitada</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';
                    for (var item in data) {
                        ret += "<tr data-id=" + id + " onclick=\"showItens( " + id + "  )\" style=\"cursor: pointer;\">";
                        ret += "<td>" + data[item]['nome'] + "</td>";
                        ret += "<td>" + data[item]['descricao'] + "</td>";
                        ret += "<td style=\"text-align: center\">" + data[item]['quantidade_solicitada'] + "</td>";
                        ret += "</tr>";
                    }
                    row.child(ret).show();
                    tr.addClass('shown');
                }
            });
        }
    });

    $('#detalhesSolicitacao').on('hidden.bs.modal', function (e) {
        $('#solicitacaoID').val(0);
        $("#listaItens").empty();
        $("#modalBody").hide();
        $('#aprovar_entrega').hide();
        $('#cancelar_entrega').hide();
    });

    $('#tableSolicitacoes').on('page.dt', function () {
        $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
        }, 'fast');
    });

    $('#tableSolicitacoes').DataTable().columns().iterator('column', function (ctx, idx) {
        $($('#tableSolicitacoes').DataTable().column(idx).header()).append('<span class="sort-icon"/>');
    });

    $("#formSolicitacao button[type = 'submit']").on("click", function () {
        buttonSubmitID = $(this).attr("id");
    });

    $("#formSolicitacao").on("submit", function () {
        let escolha = "";
        if (buttonSubmitID == "aprovar_entrega") {
            escolha = confirm("Tem certeza que deseja aprovar a entrega dos materiais?");
            if (!escolha)
                return false;
        } else if (buttonSubmitID == "cancelar_entrega") {
            escolha = confirm("Tem certeza que deseja cancelar a entrega de materiais?");
            if (!escolha)
                return false;
        }
    });
});
