<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalModalLabel">Add New Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('admin.subjects.store') }}" method="post" onsubmit="ajaxStore(event, this, 'post', 'addModal')">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rank_id">Rank <span class="t_r">*</span></label>
                            <select name="rank_id" id="rank_id" class="form-control" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name <span class="t_r">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>



