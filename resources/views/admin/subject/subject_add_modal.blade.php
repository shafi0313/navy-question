<!-- Add Subject-->
<div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="subjectModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('admin.subject.store') }}" method="post">
          @csrf
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="exam_id">Exam <span class="t_r">*</span></label>
                          <select type="text" name="exam_id" class="form-control" value="{{ old('exam_id') }}" required>
                            <option value="">Select</option>
                            @foreach ($exams as $exam)
                            <option value="{{ $exam->id }}" @selected( $exam->id == old('exam_id'))>{{ $exam->name }}</option>
                            @endforeach
                        </select>
                          @if ($errors->has('exam_id'))
                          <div class="alert alert-danger">{{ $errors->first('exam_id') }}</div>
                          @endif
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="name">Subject Name <span class="t_r">*</span></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                          @if ($errors->has('name'))
                          <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                          @endif
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="trade">Trade <span class="t_r">*</span></label>
                          <input type="text" name="trade" class="form-control" value="{{ old('trade') }}" required>
                          @if ($errors->has('trade'))
                          <div class="alert alert-danger">{{ $errors->first('trade') }}</div>
                          @endif
                      </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
