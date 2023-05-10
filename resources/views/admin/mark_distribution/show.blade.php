@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
    @php
        $m = '';
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
                        <li class="nav-item">Question</li>
                    </ul>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Mark Distribution Table</h4>
                                </div>
                            </div>
                            <style>
                                input[type=text] {
                                    width: 100%;
                                    border: 1px solid rgb(192, 191, 191);
                                    border-radius: 3px;
                                    padding: 0rem .5rem;
                                }
                            </style>
                            <form action="{{ route('admin.markDistribution.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center">{{ $subject->name }}</h2>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-bordered table-hover calculation-table"
                                            id="suunto-table">
                                            <thead class="bg-secondary thw text-center">
                                                <tr class="text-center">
                                                    <th rowspan="2">SL</th>
                                                    <th rowspan="2">Chapter</th>
                                                    <th colspan="2">Multiple Choice</th>
                                                    <th colspan="2">Sort Question</th>
                                                    <th colspan="2">Long Question</th>
                                                    <th rowspan="2">Total Mark</th>
                                                </tr>
                                                <tr>
                                                    <th>No Of Question</th>
                                                    <th>Mark</th>
                                                    <th>No Of Question</th>
                                                    <th>Mark</th>
                                                    <th>No Of Question</th>
                                                    <th>Mark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $x = 1 @endphp
                                                @foreach ($chapters as $k => $chapter)
                                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                                    <input type="hidden" name="chapter_id[]" value="{{ $chapter->id }}">
                                                    @php
                                                        $multiple = $chapter->markDistribution->multiple ?? 0;
                                                        $sort = $chapter->markDistribution->sort ?? 0;
                                                        $long = $chapter->markDistribution->long ?? 0;
                                                    @endphp
                                                    <tr id="calc-{{ $chapter->id }}" class="text-center">
                                                        <td class="text-center">{{ $x++ }}</td>
                                                        <td class="text-left">{{ $chapter->name }}</td>
                                                        <td>{{ $chapter->question->where('type', 'multiple_choice')->count() }}</td>
                                                        <td>
                                                            <input type="text" name="multiple[]" class="sum{{ $k }}" value="{{ $multiple }}">
                                                        </td>
                                                        <td>{{ $chapter->question->where('type', 'short_question')->count() }}</td>
                                                        <td>
                                                            <input type="text" name="sort[]" class="sum{{ $k }}" value="{{ $sort }}">
                                                        </td>
                                                        <td>{{ $chapter->question->where('type', 'long_question')->count() }}</td>
                                                        <td>
                                                            <input type="text" name="long[]" class="sum{{ $k }}"  value="{{ $long }}">
                                                        </td>
                                                        <td>{{ $multiple + $sort + $long }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody> 
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pass_mark">Pass Marks <span class="t_r">*</span></label>
                                            <input type="text" name="pass_mark" class="form-control"
                                                value="{{ $chapter->markDistribution->pass_mark ?? 0 }}"
                                                onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
                                            @if ($errors->has('pass_mark'))
                                                <div class="alert alert-danger">{{ $errors->first('pass_mark') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center card-action">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </div>
                            </form>
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
        <script>
            $(document).on("input", "input:text", function() {
                var strClass = $(this).prop("class");
                var intTotal = 0;
                $.each($("input:text." + strClass), function() {
                    var intInputValue = parseInt($(this).val());
                    if (!isNaN(intInputValue)) {
                        intTotal = intTotal + intInputValue;
                    }
                });
                $(this).parent("td").siblings("td:last").text(intTotal);
            });
        </script>
    @endpush
@endsection
