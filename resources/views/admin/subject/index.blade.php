@extends('admin.layout.master')
@section('title', 'Subject and Chapter')
@section('content')
@php $m=''; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Subject and Chapter</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Subject and Chapter List</h4>
                                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#subjectModal">
                                    Add New Subject
                                  </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Exam and Subject Name</th>
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
                                        <tr class="bg-primary text-light">
                                            <td >{{ $x++ }}</td>
                                            <td>{{ $subject->exam->name ?? ''}} => {{ $subject->name }}</td>
                                            <td>{{ bdDate($subject->created_at) }}</td>
                                            <td class="text-right">
                                                <div class="form-button-action">
                                                    <span class="btn btn-danger btn-sm addChapter" data-toggle="modal" data-target="#addChapter" data-id="{{$subject->id}}" data-subject="{{ $subject->name }}">Add Chapter</span>
                                                    <span class="btn btn-info btn-sm editSubject" data-toggle="modal" data-target="#editSubject" data-url="{{route('admin.subject.update', $subject->id)}}" data-name="{{$subject->name}}" data-exam_id="{{$subject->exam_id}}"><i class="fa fa-edit"></i></span>
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
                                                    {{-- <span class="btn btn-danger btn-sm addChapter" data-toggle="modal" data-target="#addChapter" data-id="{{$subject->id}}" data-subject="{{ $subject->name }}">Add Chapter</span> --}}
                                                    <span class="btn btn-info btn-sm editChapter" data-toggle="modal" data-target="#editChapter" data-url="{{route('admin.chapter.update', $chapter->id)}}" data-name="{{$chapter->name}}"><i class="fa fa-edit"></i></span>
                                                    <form action="{{ route('admin.chapter.destroy', $chapter->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
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

@include('admin.subject.subject_add_modal')
@include('admin.subject.subject_edit_modal')





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

<!-- Edit Chapter -->
<div class="modal fade" id="editChapter" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
  <form action="" method="POST" autocomplete="off" id="editChapterForm">
      @csrf
       <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="editLabel" style="color:red;">Edit Chapter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-10">
                      <div class="form-group">
                          <label for="name">Chapter <span class="t_r">*</span></label>
                          <input type="text" name="name" class="form-control" id="editChapterName" required>
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

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
    <script>
        $(".editSubject").on('click', function(){
            $('#subjectEditForm').attr('action',$(this).data('url'));
            $('#editName').val($(this).data('name'));
            $('#editExamId').val($(this).data('exam_id'));
        });

        $(".addChapter").on('click', function(){
            $('#subject_id').val($(this).data('id'));
            $('#subjectName').val($(this).data('subject'));
        });

        $(".editChapter").on('click', function(){
            $('#editChapterForm').attr('action',$(this).data('url'));
            $('#editChapterName').val($(this).data('name'));
        });

    </script>
@endpush
@endsection

