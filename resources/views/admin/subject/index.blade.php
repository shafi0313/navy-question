@extends('admin.layout.master')
@section('title', 'Subject')
@section('content')
@php $m='subject'; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Subject</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Add Row</h4>
                                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#subjectModal">
                                    Add Subject
                                  </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Subject Name</th>
                                            <th>Created at</th>
                                            <th class="no-sort" width="40px">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php $x = 1 @endphp
                                        @foreach ($subjects as $subject)
                                        <tr>
                                            <td >{{ $x++ }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ bdDate($subject->created_at) }}</td>
                                            <td class="text-right">
                                                <div class="form-button-action">
                                                    <span class="btn btn-danger btn-sm addChapter" data-toggle="modal" data-target="#addChapter" data-id="{{$subject->id}}" data-subject="{{ $subject->name }}">Add Chapter</span>
                                                    <span class="btn btn-info btn-sm editSubject" data-toggle="modal" data-target="#editSubject" data-url="{{route('admin.subject.update', $subject->id)}}" data-name="{{$subject->name}}"><i class="fa fa-edit"></i></span>
                                                    {{-- <form action="" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @if ($subject->chapters->count() > 0)
                                        <thead class="bg-success thw">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Chapter Name</th>
                                                <th class="text-center">Created at</th>
                                                <th class="no-sort" width="40px">Action</th>
                                            </tr>
                                        </thead>
                                        @php $xx = 1 @endphp
                                        @foreach ($subject->chapters as $chapter)
                                        <tr class="text-center">
                                            <td class="text-center">{{ $xx++ }}</td>
                                            <td>{{ $chapter->name }}</td>
                                            <td>{{ bdDate($subject->created_at) }}</td>
                                            <td class="text-right">
                                                <div class="form-button-action">
                                                    {{-- <span class="btn btn-danger btn-sm addChapter" data-toggle="modal" data-target="#addChapter" data-id="{{$subject->id}}" data-subject="{{ $subject->name }}">Add Chapter</span>
                                                    <span class="btn btn-info btn-sm editSubject" data-toggle="modal" data-target="#editSubject" data-url="{{route('admin.subject.update', $subject->id)}}" data-name="{{$subject->name}}"><i class="fa fa-edit"></i></span> --}}
                                                    {{-- <form action="" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 @include('include.footer')
</div>

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
                          <label for="name">Subject Name<span class="t_r">*</span></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                          @if ($errors->has('name'))
                          <div class="alert alert-danger">{{ $errors->first('name') }}</div>
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
                          <label for="name">Subject Name <span class="t_r">*</span></label>
                          <input type="text" name="name" class="form-control" id="editName" required>
                          @if ($errors->has('name'))
                          <div class="alert alert-danger">{{ $errors->first('name') }}</div>
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



<!-- Add Chapter -->
<div class="modal fade" id="addChapter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Chapter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('admin.chapter.store') }}" method="post">
          @csrf
          <input type="hidden" id="subject_id" name="subject_id">
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="name">Subject Name <span class="t_r">*</span></label>
                          <input type="text"  class="form-control" id="subjectName" readonly>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="name">Chapter Name <span class="t_r">*</span></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                              placeholder="Enter name" required>
                          @if ($errors->has('name'))
                          <div class="alert alert-danger">{{ $errors->first('name') }}</div>
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

<!-- Option Edit -->
{{-- <div class="modal fade" id="optionEdit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <form action="" method="POST" autocomplete="off" id="optionEditForm">
      @csrf
       <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editLabel" style="color:red;">Edit Question</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-10">
                      <div class="form-group">
                          <label for="option">Option <span class="t_r">*</span></label>
                          <input type="text" name="option" class="form-control" id="editOption" required>
                          @if ($errors->has('option'))
                          <div class="alert alert-danger">{{ $errors->first('option') }}</div>
                          @endif
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="correct">Correct <span class="t_r">*</span></label>
                          <input type="checkbox" name="correct"  class="form-control" id="editCorrect">
                          @if ($errors->has('correct'))
                          <div class="alert alert-danger">{{ $errors->first('correct') }}</div>
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
</div> --}}

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    <script>
        $(".editSubject").on('click', function(){
            $('#subjectEditForm').attr('action',$(this).data('url'));
            $('#editName').val($(this).data('name'));
        });

        $(".addChapter").on('click', function(){
            $('#subject_id').val($(this).data('id'));
            $('#subjectName').val($(this).data('subject'));
        });

        $(".optionEdit").on('click', function(){
        $('#optionEditForm').attr('action',$(this).data('url'));
        $('#editOption').val($(this).data('option'));
        $('#editCorrect').val($(this).data('correct'));
        // console.log($(this).data('correct'))
        if($(this).data('correct') == 1){
            $('#editCorrect').prop("checked", true);
        }else{
            $('#editCorrect').prop("checked", false);
        }
    });

    </script>
@endpush
@endsection

