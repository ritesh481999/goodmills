(function () {

    // hide message after 5 seconds
    setTimeout(function () {
        $('.alert-success, .alert-danger, .alert-warning, .alert-info').hide(100);
    }, 5000);

    $(document).on("click", ".deleteRow", function (event) {
        event.preventDefault();
        var deleteUrl = $(this).data("url");
        console.log(deleteUrl);
        Swal.fire({
            title: "Do You Want To Delete",
            text: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    method: "DELETE",
                    data: {
                        _token: _token,
                    },
                    success: function (result) {
                        if (result.status == 'true') {
                            Swal.fire({
                                type: "success",
                                text: "Deleted",
                            });
                            location.reload();

                        } else {
                            if (result.message) {
                                Swal.fire({
                                    title: "Can't Delete",
                                    text: result.message,
                                    type: 'warning',
                                })
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    text: 'Failed to delete',
                                })
                            }
                            // Swal.fire({
                            //     type: "error",
                            //     text: "Failed to delete",
                            // });
                        }
                    },
                });
            }

        });

    });




})();

