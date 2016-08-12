jQuery('.confirmRequired').click(function (event) {
    event.stopPropagation();
    event.preventDefault();

    sweetAlert({
        title: "Opravdu chcete pokračovat?",
        text: jQuery(event.toElement).attr('confirm-text'),
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ano, pokračovat",
        cancelButtonText: "Zrušit",
        closeOnConfirm: false,
        html: true
    }, function (confirmed) {
        if (confirmed) {
            window.location.href = event.toElement.href;
        }
    });
});
