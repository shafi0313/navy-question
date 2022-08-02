@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
@php $m=''; $sm=''; $ssm=''; @endphp

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
                                {{-- <a href="{{ route('admin.markDistribution.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a> --}}
                            </div>
                        </div>
                        <form action="{{ route('admin.markDistribution.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-striped table-hover calculation-table" id="suunto-table">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>SL</th>
                                                <th>Chapter</th>
                                                <th>multiple_choice</th>
                                                <th>Sort Question</th>
                                                <th>long_question</th>
                                                <th>Total Mark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $x = 1 @endphp
                                            @foreach ($chapters as $k => $chapter)
                                            <input type="hidden" name="subject_id" value="{{$subject->id}}">
                                            <input type="hidden" name="chapter_id[]" value="{{$chapter->id}}">
                                            @php
                                                $multiple = $chapter->markDistribution->multiple??0;
                                                $sort = $chapter->markDistribution->sort??0;
                                                $long = $chapter->markDistribution->long??0;
                                            @endphp
                                            <tr id="calc-{{$chapter->id}}">
                                                <td class="text-center">{{ $x++ }}</td>
                                                <td>{{ $chapter->name }}</td>
                                                <td><input type="text" name="multiple[]" class="sum{{$k}}" id="" value="{{ $multiple }}"></td>
                                                <td><input type="text" name="sort[]" class="sum{{$k}}" value="{{ $sort }}"></td>
                                                <td><input type="text" name="long[]" class="sum{{$k}}" value="{{ $long }}"></td>
                                                <td >{{$multiple + $sort +  $long }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pass_mark">Pass Marks <span class="t_r">*</span></label>
                                        <input type="text" name="pass_mark" class="form-control" value="{{ $chapter->markDistribution->pass_mark??0 }}" onInput="this.value = this.value.replace(/[a-zA-z\-*/]/g,'');" required>
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
        $(document).on("input", "input:text", function () {
            var strClass = $(this).prop("class");
            var intTotal = 0;
            $.each($("input:text." + strClass), function () {
                var intInputValue = parseInt($(this).val());
                if (!isNaN(intInputValue))
                {
                    intTotal = intTotal + intInputValue;
                }
            });
            $(this).parent("td").siblings("td:last").text(intTotal);
        });

    </script>
@endpush
@endsection

