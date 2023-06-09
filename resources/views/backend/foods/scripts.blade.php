<script>
    $(document).ready(function() {
        //token csfr js
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        function fetchFoods () {
            let datatable = $('#tableFoods').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('foods.fetch') }}",
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
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        render: function(data, type, full, meta) {
                            return "<img src=\"/uploads/foods/" + data + "\" height=\"50\"/>";
                        },
                        orderable: false
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            }).on('draw', function() {
                $('input[name="food_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop("checked", false);
                $('#delAllBtn').addClass('d-none');
            });
        }

        fetchFoods();

        $(document).on('submit', '#addFormFoods', function(e) {
            e.preventDefault();

            let dataForm = $('#addFormFoods')[0];

            try {
                $.ajax({
                    type: "POST",
                    url: $('#addFormFoods').attr('action'),
                    data: new FormData(dataForm),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#addFormFoods').find('span.error-text').text('');
                    },
                    success: function(response) {
                        if(response.status == 400) {
                            $.each(response.message, function(prefix, value) {
                                $('#addFormFoods').find('span.'+prefix+'_error').text(value[0]);
                            })
                        } else {
                            $("#addModalFoods").modal('hide');
                            $('#addFormFoods')[0].reset();
                            $('#tableFoods').DataTable().ajax.reload(null, false);
                            alert(response.message)
                        }
                    },
                })
            } catch (error) {
                console.log(error);
            }
        })
        

        $(document).on('click', '#btnEditFood', function (e) {
            e.preventDefault();

            let idFoods = $(this).data('id');
            
            $.get("{{ route('foods.edit') }}", {idFoods: idFoods}, 
                function(data) {
                    $('#editModalFoods').modal('show');
                    $('#idFoods').val(idFoods);
                    $('#name').val(data.foods.name);
                    $('#harga').val(data.foods.harga);
                    $('#stock').val(data.foods.stock);
                    $('#status').val(data.foods.status);
                    $('#kategori').val(data.foods.kategori);
                }
            )
        })

        $(document).on('submit', '#editFormFoods', function(e) {
            e.preventDefault();

            let dataForm = $('#editFormFoods')[0];
            console.log(dataForm);
            $.ajax({
                type: "POST",
                url: $('#editFormFoods').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormFoods').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#editFormFoods').find('span.'+prefix+'_error_edit').text(value[0]);
                        })
                    } else {
                        $('#tableFoods').DataTable().ajax.reload(null, false);
                        $("#editModalFoods").modal('hide');
                        $('#editFormFoods')[0].reset();
                        console.log(response);
                        alert(response.message);
                    }
                },
            }, "json")
        })

        $(document).on('click', '#btnDelFood', function(e) {
            e.preventDefault();

            let idFoods = $(this).data('id');

            if(confirm('Apakah anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('foods.destroy') }}",
                    data: {idFoods: idFoods},
                    success: function(response) {
                        $('#tableFoods').DataTable().ajax.reload(null, false);
                        alert(response.message);
                    }
                })
            }
        })
        

        function toggleDelAllBtn () {
            if($('input[name="food_checkbox"]:checked').length > 0) {
                $('#delAllBtn').text('Hapus ('+$('input[name="food_checkbox"]:checked').length+')').removeClass('d-none');
            } else {
                $('#delAllBtn').addClass('d-none');
            }
        }

        $(document).on('click', '#main_checkbox', function() {
            if(this.checked) {
                $('input[name="food_checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="food_checkbox"]').each(function() {
                    this.checked = false;
                });
            }
            toggleDelAllBtn();
        })

        $(document).on('click', '#food_checkbox', function() {
            if($('input[name="food_checkbox"]:checked').length == $('input[name="food_checkbox"]').length) {
                $('#main_checkbox').prop("checked", true);
            } else {
                $('#main_checkbox').prop("checked", false);
            }
            toggleDelAllBtn();
        })
    })
</script>