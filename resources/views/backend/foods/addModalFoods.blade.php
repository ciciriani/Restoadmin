<!-- Modal -->
<div class="modal fade" id="addModalFoods" tabindex="-1" aria-labelledby="addModalFoodsLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addFormFoods" action="{{ route('foods.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalFoodsLabel">Tambah Makanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <label for="name">Nama</label>
                      <input type="text" name="name" class="form-control" placeholder="Masukkan nama...">
                      <span class="text-danger error-text name_error"></span>
                  </div>
                  <div class="form-group">
                      <label for="photo">Photo</label>
                      <input type="file" name="photo" class="form-control">
                      <span class="text-danger error-text photo_error"></span>
                  </div>
                  <div class="form-group">
                      <label for="harga">Harga</label>
                      <input type="number" name="harga" class="form-control" placeholder="Masukkan harga...">
                      <span class="text-danger error-text harga_error"></span>
                  </div>
                  <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control">
                          <option value="Tersedia">Tersedia</option>
                          <option value="Tidak Tersedia">Tidak Tersedia</option>
                      </select>
                      <span class="text-danger error-text status_error"></span>
                  </div>
                  <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="cemilan">Cemilan</option>
                    </select>
                    <span class="text-danger error-text kategori_error"></span>
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