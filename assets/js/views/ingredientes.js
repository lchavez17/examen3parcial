$('.btn-eliminar').on('click', function(){
    var href = $(this).attr('href');
    // https://craftpip.github.io/jquery-confirm/
    $.confirm({
        title: 'Confirmar acción',
        content: '¿Está seguro que desea eliminar este ingrediente?',
        buttons: {
            confirm: {
                text: 'Si, deseo eliminarlo',
                btnClass: 'btn-success',
                action: function(){
                    window.location.href = href;
                }
            },
            cancel: {
                text: 'No, no deseo eliminarlo',
                btnClass: 'btn-default'
            }
        }
    });

    return false;
});