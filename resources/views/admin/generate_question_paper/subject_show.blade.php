@extends('admin.layout.master')
@section('title', 'Generated Question')
@section('content')
@php $m=''; $sm=''; $ssm=''; @endphp

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                    <li class="separator"><i class="flaticon-right-arrow"></i></li>
                    <li class="nav-item">Generated Question</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                {{-- <h4 class="card-title">Add Row</h4> --}}
                                <a href="{{ route('admin.generateQuestion.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($datum->count() > 0)
                                @php  $examInfo = $datum->first()->first();  @endphp
                                <div class="text-center">
                                    <span style="font-size: 18px">
                                        Exam/Course: <b>{{$examInfo->exam->name}}</b>
                                    </span>
                                    
                                    {{-- <strong>Year: {{ \Carbon\Carbon::parse($examInfo->date)->format('Y') }}</strong><br> --}}
                                    {{-- <strong>Mode: {{ $examInfo->mode }}</strong><br>
                                    <strong>Trade: {{ $examInfo->trade }}</strong><br> --}}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover">
                                    <thead class="bg-secondary thw">
                                        <tr>
                                            <th>SL</th>
                                            <th>Subject</th>
                                            <th>Trade</th>
                                            <th>Mode</th>
                                            <th>Exam Date & Time</th>
                                            <th>Exam Duration</th>
                                            <th class="no-sort">Show By Set</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($datum->groupBy('subject_id') as $dat)
                                        @php
                                            $data = $dat->first()
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ @$x += 1 }}</td>
                                            <td>{{ $data->subject->name }}</td>
                                            <td>{{ $data->subject->trade }}</td>
                                            <td>{{ $data->mode }}</td>
                                            <td>{{ examDateTime($data->date) }}</td>
                                            <td>{{ $data->d_hour }} Hrs {{ $data->d_minute }} Min</td>
                                            <td>
                                                <div class="form-button-action">
                                                    @foreach ($datum as $data)
                                                    <a href="{{ route('admin.generateQuestion.show',$data->id) }}" data-toggle="tooltip" title="Question Set" class="btn btn-primary btn-sm ml-1">
                                                        {{ quesSet( $data->set) }}
                                                    </a>
                                                    <form action="{{ route('admin.generatedQues.destroy', $data->id) }}" method="post">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" data-toggle="tooltip" title="" class="btn btn-sm ml-1 btn-danger" data-original-title="Delete" onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
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

@push('custom_scripts')
    <!-- Datatables -->
    @include('include.data_table')
@endpush
@endsection

