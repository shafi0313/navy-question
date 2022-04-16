@extends('admin.layout.master')
@section('title', 'Visitor Info')
@section('content')
@php $m='visitor'; $sm=''; $ssm=''; @endphp
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                    <a href="{{ route('admin.dashboard')}}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Visitor Info</a>
                    </li>
                </ul>
            </div>
            <div class="divider1"></div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('admin.visitorInfo.destroySelected')}}" method="POST">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Visitor Info</h4>
                                    <button type="submit" class="btn btn-warning btn-round ml-auto">Delete Selected</button>

                                    <a class="btn btn-danger btn-round " href="{{ route('admin.visitorInfo.destroyAll') }}">
                                        <i class="fa fa-plus"></i>
                                        Delete All
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="multi-filter-select" class="display table table-striped table-hover">
                                        <thead class="bg-secondary thw">
                                            <tr>
                                                <th>
                                                    <label class="text-light font-weight-bold"><input  type="checkbox" id="checkAll" > &nbsp;&nbsp; SL</label>
                                                </th>
                                                <th>IP</th>
                                                <th>Country Name</th>
                                                <th>Region Name</th>
                                                <th>City Name</th>
                                                <th>Zip Code</th>
                                                <th>Latitude</th>
                                                <th>Longitude </th>
                                                <th>currency</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visitors as $key=>$visitor)
                                            <tr>
                                                <td>
                                                    <label><input value="{{$visitor->id}}" type="checkbox" name="id[]" class="child" > &nbsp;&nbsp; {{$key+1}}</label>
                                                </td>
                                                <td>{{$visitor->ip}} </td>
                                                <td>
                                                    <span><i class="{{strtolower($visitor->country)}} flag"></i></span>
                                                    {{$visitor->country}}
                                                </td>
                                                <td>{{$visitor->state_name}} </td>
                                                <td>{{$visitor->city}} </td>
                                                <td>{{$visitor->postal_code}} </td>
                                                <td>{{$visitor->lat}} </td>
                                                <td>{{$visitor->lon}} </td>
                                                <td>{{$visitor->currency}} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 @include('include.footer')
</div>

@push('custom_scripts')
@include('include.data_table')
<script>
    $(function () {
        $("#checkAll").on("click", function () {
            if($(this).is(":checked")){
                $('.child').prop('checked', true);
            } else {
                $('.child').prop('checked', false);
            }
        })
    });
</script>
@endpush
@endsection

