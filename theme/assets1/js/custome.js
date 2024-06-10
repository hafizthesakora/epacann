$(document).on('click', '.delete', function (e) {
    var form = $(this);
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure want to delete?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = form.attr('href');
                }
            });
});

