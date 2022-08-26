$(function () {
    $('.selectMaterial').select2({
        placeholder: "Digite algo ou selecione uma opção."
    });
});

$(function () {
    $("#entrada").on("click", function(){
        $("#form_entrada").submit();
        $(this).prop("disabled", true);
    });
});
