$('tr.movie').each(function() {
    $(this).click(function() {
        let name = $(this).data('name');
        let description = $(this).data('description');
        let image = $(this).data('image');
        $('#modalMovie').modal('show');
        $('#modalMovie .name').html(name);
        $('#modalMovie .description').html(description);
        $('#modalMovie .image').attr('src', image);
    });
});