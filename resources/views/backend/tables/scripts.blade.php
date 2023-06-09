
<script>
    $(document).ready(function() {
        //token csfr js
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        function fetchTables () {
            let datatable = $('#tableMeja').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('tables.fetch') }}",
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
                        data: 'no_meja',
                        name: 'no_meja'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            }).on('draw', function() {
                $('input[name="table_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop("checked", false);
                $('#delAllBtn').addClass('d-none');
            });
        }

        fetchTables();

        $(document).on('submit', '#addFormMeja', function(e) {
            e.preventDefault();

            let dataForm = $('#addFormMeja')[0];

            $.ajax({
                type: "POST",
                url: $('#addFormMeja').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#addFormMeja').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#addFormMeja').find('span.'+prefix+'_error').text(value[0]);
                        })
                    } else {
                        $('#tableMeja').DataTable().ajax.reload(null, false);
                        $("#addModalMeja").modal('hide');
                        $('#addFormMeja')[0].reset();
                        alert(response.message);
                    }
                },
            })
        })

        $(document).on('click', '#btnEditTable', function (e) {
            e.preventDefault();

            let idMeja = $(this).data('id');
            
            $.get("{{ route('tables.edit') }}", {idMeja: idMeja}, 
                function(data) {
                    $('#editModalMeja').modal('show');
                    $('#idMeja').val(idMeja);
                    $('#no_meja').val(data.meja.no_meja);
                    $('#status').val(data.meja.status);
                }
            )
        })

        $(document).on('submit', '#editFormMeja', function(e) {
            e.preventDefault();

            let dataForm = $('#editFormMeja')[0];

            $.ajax({
                type: "POST",
                url: $('#editFormMeja').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormMeja').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#editFormMeja').find('span.'+prefix+'_error_edit').text(value[0]);
                        })
                    } else {
                        $('#tableMeja').DataTable().ajax.reload(null, false);
                        $("#editModalMeja").modal('hide');
                        $('#editFormMeja')[0].reset();
                        alert(response.message);
                    }
                },
            })
        })

        //ajax delete
        $(document).on('click', '#btnDelTable', function(e) {
            e.preventDefault();

            let idMeja = $(this).data('id');
            //confirm first using browser alert
            if(confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('tables.destroy') }}",
                    data: {idMeja: idMeja},
                    success: function(response) {
                        $('#tableMeja').DataTable().ajax.reload(null, false);
                        alert(response.message)
                    }
                })
            }

        })

        function toggleDelAllBtn () {
            if($('input[name="table_checkbox"]:checked').length > 0) {
                $('#delAllBtn').text('Hapus ('+$('input[name="table_checkbox"]:checked').length+')').removeClass('d-none');
            } else {
                $('#delAllBtn').addClass('d-none');
            }
        }

        $(document).on('click', '#main_checkbox', function() {
            if(this.checked) {
                $('input[name="table_checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="table_checkbox"]').each(function() {
                    this.checked = false;
                });
            }
            toggleDelAllBtn();
        })

        $(document).on('click', '#table_checkbox', function() {
            if($('input[name="table_checkbox"]:checked').length == $('input[name="table_checkbox"]').length) {
                $('#main_checkbox').prop("checked", true);
            } else {
                $('#main_checkbox').prop("checked", false);
            }
            toggleDelAllBtn();
        })

        //delete selected data
        $(document).on('click', '#delAllBtn', function(e) {
            e.preventDefault();

            let idMeja = [];
            $('input[name="table_checkbox"]:checked').each(function() {
                idMeja.push($(this).data('id'));
            });

            if(idMeja.length <= 0) {
                alert('Tidak ada data yang dipilih!');
            } else {
                if(confirm('Yakin ingin menghapus data yang dipilih?')) {
                    $.post("{{ route('tables.destroySelected') }}", {idMeja: idMeja}, 
                    function(data) {
                        $('#tableMeja').DataTable().ajax.reload(null, false);
                        alert(data.message);
                    }, 'json')
                }
            }
        })
    });
</script>