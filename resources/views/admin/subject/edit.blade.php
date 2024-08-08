<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalModalLabel">Exam Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.subjects.update', $subject->id) }}" method="post"
                onsubmit="ajaxStore(event, this, 'POST', 'editModal')" class="form-horizontal">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exam_id">Exam <span class="t_r">*</span></label>
                                <select name="exam_id" id="exam_id" class="form-control" required>
                                    <option value="{{ $subject->exam_id }}" @selected($subject->exam_id == $subject->exam->id)>
                                        {{ $subject->exam->name }}</option>
                                </select>
                                @if ($errors->has('exam_id'))
                                    <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="name">Name <span class="t_r">*</span></label>
                            <input type="text" name="name"
                                class="form-control" value="{{ $subject->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
