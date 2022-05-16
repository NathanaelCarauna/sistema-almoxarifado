$(function () {
    $('.selectMaterial').select2({
        placeholder: "Digite algo ou selecione uma opção.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });

    $('.selectMaterial2').select2({
        placeholder: "Selecione o Material Primeiro.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });

    $('#selectMaterial').change(function () {
        $.ajax({
            url: '/notas_material/' + this.value,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var optionsHtml = "";
                data.forEach(function (nota) {
                    $('#selectNotas').append("<option value='" + nota[0] + "'>" + nota[1] + "</option>")
                });
            }
        });
    });
});




