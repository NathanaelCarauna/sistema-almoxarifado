$(function() {
    document.getElementById('data_inicio').max = new Date(new Date().getTime() - new Date()
    .getTimezoneOffset() * 60000).toISOString().split("T")[0];

    document.getElementById('data_fim').max = new Date(new Date().getTime() - new Date()
    .getTimezoneOffset() * 60000).toISOString().split("T")[0];
});

$(function() {
    $("#tipo_relatorio").change(function()
    {
        if($("#tipo_relatorio").val() == 4 || $("#tipo_relatorio").val() == 6 || $("#tipo_relatorio").val() == 7) {
            $("#data_inicio").hide();
            $("#data_fim").hide();
        } else {
            $("#data_inicio").show();
            $("#data_fim").show();
        }
    });
});

