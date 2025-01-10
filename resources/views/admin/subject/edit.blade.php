<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalModalLabel">Edit Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="post"
                onsubmit="ajaxStore(event, this, 'POST', 'editModal')" class="form-horizontal">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rank_id">Rank <span class="t_r">*</span></label>
                                <select name="rank_id" class="form-control rank_id" required>
                                    <option value="{{ $subject->rank_id }}" @selected($subject->rank->id)>
                                        {{ $subject->rank->name }}</option>
                                </select>
                                @if ($errors->has('rank_id'))
                                    <div class="alert alert-danger">{{ $errors->first('rank_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name <span class="t_r">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $subject->name }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
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

<script>
    $(document).ready(function() {
        $('.rank_id').select2({
            dropdownParent: $('#editModal'),
            width: '100%',
            placeholder: 'Select...',
            allowClear: true,
            ajax: {
                url: window.location.origin + '/admin/select-2-ajax',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    return {
                        q: $.trim(params.term),
                        type: 'getRank',
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
    });
</script>
