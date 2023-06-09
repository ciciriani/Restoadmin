<!-- Modal -->
{{-- action="{{ route('orders.store') }}" --}}
<div class="modal fade" id="addModalOrders" tabindex="-1" aria-labelledby="addModalOrdersLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addFormOrders" action="{{ route('ordersDetail') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalOrdersLabel">Tambah Makanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                  <div class="form-group">
                      <label for="id_foods">Makanan/Minuman</label>
                      <select name="id_foods[]" class="form-control js-example-basic-multiple">
                          @foreach ($foods as $food)
                              <option value="{{ $food->id }}">{{ $food->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="nama_pelanggan">
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