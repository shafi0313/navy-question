@extends('admin.layout.master')
@section('title', 'Question')
@section('content')
@php $m='question'; $sm=''; $ssm=''; @endphp

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
                                <a href="{{ route('admin.markDistribution.create') }}" class="btn btn-primary btn-round ml-auto text-light" style="min-width: 200px">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
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
                                                <th>Multiple Choice</th>
                                                <th>Sort Question</th>
                                                <th>Long Question</th>
                                                <th>Total Mark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $x = 1 @endphp
                                            @foreach ($chapters as $chapter)
                                            <input type="hidden" name="subject_id" value="{{$subject->id}}">
                                            <input type="hidden" name="chapter_id[]" value="{{$chapter->id}}">
                                            <tr id="calc-{{$chapter->id}}">
                                                <td class="text-center">{{ $x++ }}</td>
                                                <td>{{ $chapter->name }}</td>
                                                <td><input type="text" name="multiple[]" class="form-control"></td>
                                                <td><input type="text" name="sort[]" class="form-control"></td>
                                                <td><input type="text" name="long[]" class="form-control"></td>
                                                <td class="subtotal"></td>

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










                        <div role="form" lang="en-US" dir="ltr">
                            <form action="/test/#" method="post" class="form" novalidate>
                              <table class="table table-responsive table-bordered calculation-table" id="suunto-table">
                                <thead>
                                  <tr>
                                    <th>Item Number</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>US List</th>
                                    <th>Ext. Price</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr id="calc-black">
                                    <td>SS022740000</td>
                                    <td>EON Core Black W/USB</td>
                                    <td><span class="wpcf7-form-control-wrap eon-black-qty">
                                      <input type="number" name="eon-black-qty" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-number" min="0" max="9999" aria-invalid="false">
                                      </span></td>
                                    <td class="value" data-value="995">$995.00</td>
                                    <td class="subtotal" data-id="total" data-value="0"></td>
                                  </tr>
                                  <tr id="calc-white">
                                    <td>SS023081000</td>
                                    <td>EON Core White W/USB</td>
                                    <td><span class="wpcf7-form-control-wrap eon-white-qty">
                                      <input type="number" name="eon-white-qty" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-number" min="0" max="9999" aria-invalid="false">
                                      </span></td>
                                    <td class="value" data-value="995">$995.00</td>
                                    <td class="subtotal" data-id="total" data-value="0"></td>
                                  </tr>
                                  <tr id="calc-lime">
                                    <td>SS023082000</td>
                                    <td>EON Core Lime W/USB</td>
                                    <td><span class="wpcf7-form-control-wrap eon-lime-qty">
                                      <input type="number" name="eon-lime-qty" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-number" min="0" max="9999" aria-invalid="false">
                                      </span></td>
                                    <td class="value" data-value="995">$995.00</td>
                                    <td class="subtotal" data-id="total" data-value="0"></td>
                                  </tr>
                                  <tr id="calc-cable">
                                    <td>SS022740000</td>
                                    <td>EON Core USB Cable</td>
                                    <td><span class="wpcf7-form-control-wrap eon-black-qty">
                                      <input type="number" name="eon-cable-qty" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-number" min="0" max="9999" aria-invalid="false">
                                      </span></td>
                                    <td class="value" data-value="54">$54.00</td>
                                    <td class="subtotal" data-id="total" data-value="0"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4" align="right">Grand Total</td>
                                    <td class="grandTotal"></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="wpcf7-response-output wpcf7-display-none"></div>
                            </form>
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
    <script type="text/javascript">
        $('.calculation-table [id^="calc-"] input').on('keyup',
            function(){
            var value = $(this).val();
            var name = $(this).closest("tr").attr('id');
            var subtotal = $("#"+name + '> td.value').attr('data-value');
            var linetotal = (subtotal * value);
            $("#"+name + "> td.subtotal").text("$ " + linetotal + ".00").attr('data-value', linetotal);

            var grandTotal = 0;

            $('.subtotal').each(function(){
                var rowTotal = parseFloat($(this).attr('data-value'));
                grandTotal = rowTotal + grandTotal;
                $("td.grandTotal").text("$ " + grandTotal + ".00");
            });
        });


    </script>
@endpush
@endsection

