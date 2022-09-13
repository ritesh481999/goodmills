$(document).on('click','.deletevariety', function(event) {
    event.preventDefault();

    var deleteId = $(this).data('id');
    var deleteUrl = deleteRoute.replace(':id',deleteId);
    console.log(deleteUrl);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Do You Want To Delete',
        text: 'Are you sure?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                data: { 'id': deleteId, _token : $('meta[name="csrf-token"]').attr('content')},
                success: function(result) {
                  console.log(result);
                  if(result.status == 'true'){
                    Swal.fire({
                      type: 'success',
                      text: 'Deleted',
                    })
                    location.reload();
                  }
                  else {
                      Swal.fire({
                      type: 'error',
                      text: 'Failed to delete',
                    })
                  }
                }
            });
        }
    });
});
