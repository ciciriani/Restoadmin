<!-- Modal -->
<div class="modal fade" id="addModalMeja" tabindex="-1" aria-labelledby="addModalMejaLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addFormMeja" action="{{ route('tables.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalMejaLabel">Tambah Meja</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <label for="no_meja">No Meja</label>
                      <input type="number" name="no_meja" placeholder="No Meja" class="form-control">
                      <span class="text-danger error-text no_meja_error"></span>
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