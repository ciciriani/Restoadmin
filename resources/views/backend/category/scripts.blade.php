<script>
    $(document).ready(function() {
        //token csfr js
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        function fetchCategory () {
            let datatable = $('#tableCategory').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('category.fetch') }}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            }).on('draw', function() {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop("checked", false);
                $('#delAllBtn').addClass('d-none');
            });
        }

        fetchCategory();
        
        function fetchTrashCategory () {
            let datatable = $('#tableCategoryTrash').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('category.fetchTrash') }}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            }).on('draw', function() {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="mainTrash_checkbox"]').prop("checked", false);
                $('#delAllBtn').addClass('d-none');
            });
        }

        fetchTrashCategory();

        $(document).on('submit', '#addFormCategory', function(e) {
            e.preventDefault();

            let dataForm = $('#addFormCategory')[0];
            $.ajax({
                type: "POST",
                url: $('#addFormCategory').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#addFormCategory').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#addFormCategory').find('span.'+prefix+'_error').text(value[0]);
                        })
                    } else {
                        $("#addModalCategory").modal('hide');
                        $('#addFormCategory')[0].reset();
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                    }
                },
            })
        })

        $(document).on('click', '#btnEditCategory', function (e) {
            e.preventDefault();

            let idCategory = $(this).data('id');
            
            $.get("{{ route('category.edit') }}", {idCategory: idCategory}, 
                function(data) {
                    $('#editModalCategory').modal('show');
                    $('#idCategory').val(idCategory);
                    $('#name').val(data.category.name);
                }
            )
        })

        $(document).on('submit', '#editFormCategory', function(e) {
            e.preventDefault();

            let dataForm = $('#editFormCategory')[0];
            $.ajax({
                type: "POST",
                url: $('#editFormCategory').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormCategory').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#editFormCategory').find('span.'+prefix+'_error_edit').text(value[0]);
                        })
                    } else {
                        $("#editModalCategory").modal('hide');
                        $('#editFormCategory')[0].reset();
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        alert(response.message)
                    }
                },
            })
        })

        //ajax delete
        $(document).on('click', '#btnDelCategory', function(e) {
            e.preventDefault();

            let idCategory = $(this).data('id');
            //confirm first using browser alert
            if(confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.destroy') }}",
                    data: {idCategory: idCategory},
                    success: function(response) {
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        alert(response.message)
                    }
                })
            }

        })

        $(document).on('click', '#btnRestoreCategory', function(e) {
            e.preventDefault();

            let idCategory = $(this).data('id');
            //confirm first using browser alert
            if(confirm('Yakin ingin mengembalikan data ini?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.restore') }}",
                    data: {idCategory: idCategory},
                    success: function(response) {
                        $('#tableCategoryTrash').DataTable().ajax.reload(null, false);
                        alert(response.message)
                    }
                })
            }

        })
        

        function toggleDelAllBtn () {
            if($('input[name="category_checkbox"]:checked').length > 0) {
                $('#delAllBtn').text('Hapus ('+$('input[name="category_checkbox"]:checked').length+')').removeClass('d-none');
            } else {
                $('#delAllBtn').addClass('d-none');
            }
        }

        $(document).on('click', '#main_checkbox', function() {
            if(this.checked) {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="category_checkbox"]').each(function() {
                    this.checked = false;
                });
            }
            toggleDelAllBtn();
        })

        $(document).on('click', '#category_checkbox', function() {
            if($('input[name="category_checkbox"]:checked').length == $('input[name="category_checkbox"]').length) {
                $('#main_checkbox').prop("checked", true);
            } else {
                $('#main_checkbox').prop("checked", false);
            }
            toggleDelAllBtn();
        })

        //delete selected data
        $(document).on('click', '#delAllBtn', function(e) {
            e.preventDefault();

            let idCategories = [];
            $('input[name="category_checkbox"]:checked').each(function() {
                idCategories.push($(this).data('id'));
            });

            if(idCategories.length <= 0) {
                alert('Tidak ada data yang dipilih!');
            } else {
                if(confirm('Yakin ingin menghapus data yang dipilih?')) {
                    $.post("{{ route('category.destroySelectedTrash') }}", {idCategory: idCategory}, 
                    function(data) {
                        $('#tableCategory').DataTable().ajax.reload(null, false);
                        alert(data.message);
                    }, 'json')
                }
            }
        })
    })
</script>