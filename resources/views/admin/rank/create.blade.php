<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add New Rank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.ranks.store') }}" method="post"
                onsubmit="ajaxStore(event, this, 'post', 'createModal')">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name <span class="t_r">*</span></label>
                            <input type="text" name="name" class="form-control">
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
