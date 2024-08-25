@extends('admin.layout.master')
@section('title', 'Question Paper')
@section('content')
    @php
        $m = 'generatedQues';
        $sm = '';
        $ssm = '';
    @endphp

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <ul class="breadcrumbs">
                        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home"></i></a></li>
                        <li class="separator"><i class="flaticon-right-arrow"></i></li>
                        <li class="nav-item">Question Paper</li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    {{-- <h4 class="card-title">Add Row</h4> --}}
                                    {{-- <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($datum->count() > 0)
                                    @php  $examInfo = $datum->first()->first();  @endphp
                                    <div class="text-center">
                                        <strong style="font-size: 18px">Exam/Course:
                                            {{ $examInfo->exam->name }}</strong><br>
                                        <strong>Year: {{ \Carbon\Carbon::parse($examInfo->date)->format('Y') }}</strong><br>
                                        <strong>Mode: {{ $examInfo->mode }}</strong><br>
                                        <strong>Trade: {{ $examInfo->trade }}</strong><br>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Set</th>
                                                <th>Status</th>
                                                <th>Exam Date & Time</th>
                                                <th>Exam Duration</th>
                                                <th class="no-sort" width="40px">Action</th>
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
                                            @php $x = 1 @endphp
                                            @foreach ($datum as $data)
                                                <tr>
                                                    <td class="text-center">{{ $x++ }}</td>
                                                    <td>{{ quesSet($data->set) }}</td>
                                                    <td>{{ $data->status }}</td>
                                                    <td>{{ examDateTime($data->date) }}</td>
                                                    <td>{{ $data->d_hour }} Hrs {{ $data->d_minute }} Min</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.generated_question.show', $data->id) }}"
                                                                data-toggle="tooltip" title=""
                                                                class="btn btn-link btn-primary btn-lg"
                                                                data-original-title="Show">
                                                                Show
                                                            </a>

                                                            {{-- <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button> --}}
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
