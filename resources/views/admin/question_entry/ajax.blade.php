@php $x = 1 @endphp
@foreach ($inputs as $input)
    <tr>
        <td class="text-center">{{ $x++ }}</td>
        <td><input type="hidden" name="exam_id[]" value="{{ $input->exam_id }}">{!! $input->ques !!}</td>
        <td>{{ ucfirst(preg_replace('/[^a-z]/', ' ', $input->type)) }}</td>
        <td class="text-center">{{ $input->mark }}</td>
        <td class="text-center">
            <div class="form-button-action">
                <a href="{{ route('admin.question.edit', $input->id) }}" title="Edit" class="btn btn-link btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <span class="px-1">|</span>
                <form action="{{ route('admin.question.destroy', $input->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" title="Delete" class="btn btn-link btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
<style>
    p {
        font-size: 14px;
        line-height: 0;
        margin-bottom: 0;
    }
</style>
