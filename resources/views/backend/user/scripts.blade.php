
<script>
    $(document).ready(function() {
        //token csfr js
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        function fetchUser () {
            let datatable = $('#tableUser').DataTable({
                processing: true,
                serverSide: true,
                info: true,
                ajax: {
                    url: "{{ route('user.fetch') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            }).on('draw', function() {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop("checked", false);
                $('#delAllBtn').addClass('d-none');
            });
        }

        fetchUser();

        $(document).on('submit', '#addFormUser', function(e) {
            e.preventDefault();

            let dataForm = $('#addFormUser')[0];
            $.ajax({
                type: "POST",
                url: $('#addFormUser').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#addFormUser').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#addFormUser').find('span.'+prefix+'_error').text(value[0]);
                        })
                    } else {
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        $("#addModalUser").modal('hide');
                        $('#addFormUser')[0].reset();
                        alert(response.message);
                    }
                },
            })
        })

        $(document).on('click', '#btnEditUser', function (e) {
            e.preventDefault();

            let idUser = $(this).data('id');
            
            $.get("{{ route('user.edit') }}", {idUser: idUser}, 
                function(data) {
                    $('#editModalUser').modal('show');
                    $('#idUser').val(idUser);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);
                    $('#roles').val(data.user.roles);
                }
            )
        })

        $(document).on('submit', '#editFormUser', function(e) {
            e.preventDefault();

            let dataForm = $('#editFormUser')[0];
            $.ajax({
                type: "POST",
                url: $('#editFormUser').attr('action'),
                data: new FormData(dataForm),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#editFormUser').find('span.error-text').text('');
                },
                success: function(response) {
                    if(response.status == 400) {
                        $.each(response.message, function(prefix, value) {
                            $('#editFormUser').find('span.'+prefix+'_error_edit').text(value[0]);
                        })
                    } else {
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        $("#editModalUser").modal('hide');
                        $('#editFormUser')[0].reset();
                        alert(response.message);
                    }
                },
            })
        })

        //ajax delete
        $(document).on('click', '#btnDelUser', function(e) {
            e.preventDefault();

            let idUser = $(this).data('id');
            //confirm first using browser alert
            if(confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.destroy') }}",
                    data: {idUser: idUser},
                    success: function(response) {
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        alert(response.message)
                    }
                })
            }

        })

        function toggleDelAllBtn () {
            if($('input[name="user_checkbox"]:checked').length > 0) {
                $('#delAllBtn').text('Hapus ('+$('input[name="user_checkbox"]:checked').length+')').removeClass('d-none');
            } else {
                $('#delAllBtn').addClass('d-none');
            }
        }

        $(document).on('click', '#main_checkbox', function() {
            if(this.checked) {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = true;
                });
            } else {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = false;
                });
            }
            toggleDelAllBtn();
        })

        $(document).on('click', '#user_checkbox', function() {
            if($('input[name="user_checkbox"]:checked').length == $('input[name="user_checkbox"]').length) {
                $('#main_checkbox').prop("checked", true);
            } else {
                $('#main_checkbox').prop("checked", false);
            }
            toggleDelAllBtn();
        })

        //delete selected data
        $(document).on('click', '#delAllBtn', function(e) {
            e.preventDefault();

            let idUsers = [];
            $('input[name="user_checkbox"]:checked').each(function() {
                idUsers.push($(this).data('id'));
            });

            if(idUsers.length <= 0) {
                alert('Tidak ada data yang dipilih!');
            } else {
                if(confirm('Yakin ingin menghapus data yang dipilih?')) {
                    $.post("{{ route('user.destroySelected') }}", {idUsers: idUsers}, 
                    function(data) {
                        $('#tableUser').DataTable().ajax.reload(null, false);
                        alert(data.message);
                    }, 'json')
                }
            }
        })
    });
</script>