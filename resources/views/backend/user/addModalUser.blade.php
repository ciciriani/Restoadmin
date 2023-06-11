<!-- Modal -->
<div class="modal fade" id="addModalUser" tabindex="-1" aria-labelledby="addModalUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addFormUser" action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalUserLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Masukkan nama...">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Masukkan email...">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="roles">Roles</label> <span style="color: #888">*Hanya sebagai
                                    admin</span>
                                <select name="roles" class="custom-select" disabled>
                                    <option value="admin" selected>Admin</option>
                                </select>
                                <span class="text-danger error-text roles_error"></span>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password...">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
