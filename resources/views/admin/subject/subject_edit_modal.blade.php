<!-- Edit Subject -->
<div class="modal fade" id="editSubject" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" autocomplete="off" id="subjectEditForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel" style="color:red;">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exam_id">Exam <span class="t_r">*</span></label>
                                <select type="text" name="exam_id" id="exam" class="form-control " required>
                                    <option id="">Select</option>
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}" class="exam_id">{{ $exam->name }}</option>
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
                                <input type="text" name="name" class="form-control" id="editName" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trade">Trade <span class="t_r">*</span></label>
                                <input type="text" name="trade" class="form-control" id="editTrade" required>
                                @if ($errors->has('trade'))
                                    <div class="alert alert-danger">{{ $errors->first('trade') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
