$(document).ready(function () {
    var table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: APP_BACKEND_URL + '/category',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { 
                data: 'image', 
                name: 'image',
                render: function (data, type, full, meta) {
                    return '<img src="'+data+'" alt="image" width="50" />';
                },
                orderable: false,
                searchable: false
            },
            { 
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false 
            }
        ],
        // Add dom option to customize layout
        dom: '<"row"<"col-sm-12"tr>>' +
        '<"row align-items-center justify-content-center"<"col-sm-4"l><"col-sm-4 text-center"i><"col-sm-4"p>>',
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Define entries options
        pageLength: 10 // Default page size
    });

    // Search functionality
    $('#searchTableList').on('keyup', function () {
        table.search(this.value).draw();
    });
});

$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    if (confirm("Are you sure you want to delete this category?")) {
        $.ajax({
            type: "DELETE",
            url: APP_BACKEND_URL + "/category/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Passing the CSRF token in headers
            },
            success: function (response) {
                $('#categories-table').DataTable().ajax.reload(); // Reload table after deletion
                alert(response.success);
            },
            error: function (response) {
                alert('Error: ' + response.error);
            }
        });
    }
});