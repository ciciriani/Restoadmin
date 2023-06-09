<!-- Modal -->
<div class="modal fade" id="editModalMeja" tabindex="-1" aria-labelledby="editModalMejaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editFormMeja" action="{{ route('tables.update') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalMejaLabel">Edit Meja</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" name="idMeja" id="idMeja">
              <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <label for="no_meja">No Meja</label>
                      <input type="number" name="no_meja" placeholder="No Meja" id="no_meja" class="form-control">
                      <span class="text-danger error-text no_meja_error_edit"></span>
                  </div>
              </div>
              <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <label for="status">Status Meja</label>
                      <select name="status" id="status" class="select form-control">
                          <option value="Kosong">Kosong</option>
                          <option value="Terisi">Terisi</option>
                      </select>
                      <span class="text-danger error-text status_error_edit"></span>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save changes</button>
          </div>
        </div>
      </form>
    </div>
</div>