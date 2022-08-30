$(function () {
    $("#materialQuantidade").mask("#", {
        maxlength: false,
        translation: {
            '#': { pattern: /^[0-9\s]+$/, recursive: true }
        }
    });
})
