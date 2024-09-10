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
                            <form action="{{ route('admin.mark-distributions.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center">{{ $exam->name }}</h2>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-secondary thw text-center">
                                                <tr class="text-center">
                                                    <th rowspan="2">SL</th>
                                                    <th rowspan="2">Subject</th>
                                                    <th colspan="2">Multiple Choice</th>
                                                </tr>
                                                <tr>
                                                    <th>No Of Question</th>
                                                    <th>Mark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $x = 1 @endphp
                                                @foreach ($exam->subjects as $k => $subject)
                                                    <input type="hidden" name="subject_id[]" value="{{ $subject->id }}">
                                                    @php
                                                        $multiple = $subject->markDistribution->multiple ?? 0;
                                                        $sort = $subject->markDistribution->sort ?? 0;
                                                        $long = $subject->markDistribution->long ?? 0;
                                                    @endphp
                                                    <tr id="calc-{{ $subject->id }}" class="text-center">
                                                        <td class="text-center">{{ $x++ }}</td>
                                                        <td class="text-left">{{ $subject->name }}</td>
                                                        <td>{{ $subject->questions->where('type', 'multiple_choice')->count() }}</td>
                                                        <td>
                                                            <input type="text" name="multiple[]"
                                                                class="sum{{ $k }} text-center" value="{{ $multiple }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    @endpush
@endsection
