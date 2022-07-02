<option>Select</option>
@foreach ($inputs as $input)
<option value="{{$input->id}}">{{$input->name}}</option>

@endforeach

