
@foreach ($inputs as $input)
<h4 class="question">
<input type="hidden" name="exam_id[]" value="{{ $input->exam_id }}">
<label>&nbsp;&nbsp; </label>{{ $input->ques }}
<span style="float:right">{{ $input->mark }}</span>
</h4>
@endforeach
