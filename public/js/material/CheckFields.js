$(function () {
    $("#codigoMaterial").mask("#", {
        maxlength: true,
        translation: {
            '#': { pattern: /^[0-9\s]+$/, recursive: true }
        }
    });

    $("#materialQuantidade").mask("#", {
        maxlength: false,
        translation: {
            '#': { pattern: /^[0-9\s]+$/, recursive: true }
        }
    });
})
