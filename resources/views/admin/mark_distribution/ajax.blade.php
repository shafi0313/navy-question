
@foreach ($inputs as $input)
<tr>
    <td><input type="hidden" name="exam_id[]" value="{{ $input->exam_id }}">&nbsp;&nbsp; {{ $input->ques }}</td>
    <td>{{ $input->type }}</td>
    <td>{{ $input->mark }}</td>
    <td>
        <div class="form-button-action">
            <a href="{{ route('admin.question.edit', $input->id) }}" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Show">
                Edit
            </a>
        </div>
    </td>
</tr>
{{-- <h4 class="question">
<input type="hidden" name="exam_id[]" value="{{ $input->exam_id }}">
<label>&nbsp;&nbsp; </label>{{ $input->ques }}
<span style="float:right">{{ $input->mark }}</span>
</h4> --}}
@endforeach
