@include('admin.question_paper.css')

@foreach ($questionSubjectInfos as $questionSubjectInfo)
    @php
        $totalQuestionMark = 0;
    @endphp
    <div class="navy" style="margin-bottom: 20px">
        <div class="title">
            <h4 class="exam_title">
                @if ($questionInfo->status == 'Pending')
                    <h2>Draft Question Paper</h2>
                @endif
                {{ $questionInfo->exam->name }} -
                {{ \Carbon\Carbon::parse($questionInfo->date)->format('F Y') }}
            </h4>
            <span>{{ questionSetInBangla((int) $questionSubjectInfo->set) }}</span>
            <table class="table table-bordered text-left">
                <tr>
                    <td>Mode of Examination</td>
                    <td>{{ $questionInfo->mode }}</td>
                    <td>Duration of Examination</td>
                    <td>{{ $questionInfo->d_hour }} Hrs {{ $questionInfo->d_minute }} Min</td>
                </tr>
            </table>
            <p style="margin: 6px 0px"><b>{{ $questionInfo->note }}</b></p>
            <p style="margin-bottom: 10px"><b><u>{{ $questionInfo->option_note }}</u></b></p>
        </div>
    </div>
    {{-- For total question mark start --}}
    @foreach ($questionSubjectInfo->questionPapers as $item)
        @php
            $totalQuestionMark += $item->question->mark;
        @endphp
    @endforeach
    {{-- For total question mark end --}}
    <table style="margin-bottom: 20px">
        <tr>
            <td>বিষয়: {{ $questionSubjectInfo->subject->name }}</td>
            <th style="text-align:right">পূর্ণমান: {{ $totalQuestionMark }}</th>
        </tr>
    </table>
    @php $x = 1 @endphp
    {{-- Question paper subject info start --}}
    @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
        <input type="hidden" name="get_question_id[]" value="{{ $questionPaper->question_id }}">
        <input type="hidden" name="question_subject_info_id[]" value="{{ $questionPaper->question_subject_info_id }}">
        <table class="question-table">
            <tr>
                <td class="sl">{{ $x++ }}. </td>
                <td style="text-align:left;">{!! $questionPaper->question->ques !!}</td>
                <td style="text-align:right">{{ $questionPaper->question->mark }}
                    <span>
                        @if (!empty($edit))
                            <a href="{{ route('admin.generate_question.edit', [$questionPaper->question->id, $questionInfo->id]) }}"
                                style="margin-left: 20px" class="text-info">Edit</a>
                        @endif
                        @if (!empty($delete))
                            <a href="{{ route('admin.generate_question.quesDestroy', $questionPaper->id) }}"
                                style="margin-left: 20px" class="text-danger">Delete</a>
                        @endif
                    </span>
                </td>
            </tr>
        </table>
        @if ($questionPaper->question->image)
            <img src="{{ asset('uploads/images/question/' . $questionPaper->question->image) }}" alt="">
        @endif
        @if ($questionPaper->options)
            @php
                $i = 1;
            @endphp
            @foreach ($questionPaper->options as $option)
                <div class="col-md-6 option">
                    <label class="form-check-label" for="exampleRadios{{ $option->id }}">
                        {{ numberToBanglaWord($i++) . ') ' }} {{ $option->option }}
                    </label>
                </div>
            @endforeach
        @endif
    @endforeach
    <div class="page-break"></div>
@endforeach
<br>

<htmlpageheader name="page-header">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">CONFIDENTIAL <br>EXAM IN CONFIDENCE
    </p>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">EXAM IN CONFIDENCE <br>CONFIDENTIAL
    </p>
</htmlpagefooter>






{{-- @if (!empty($edit))
    <a href="{{ route('admin.generate_question.edit', [$questionPaper->id, $questionPaper->question_info_id]) }}"
        style="margin-left: 20px" class="text-info">Edit</a>
@endif
@if (!empty($delete))
    <a href="{{ route('admin.generate_question.quesDestroy', [$questionPaper->id, $questionPaper->question_info_id]) }}"
        style="margin-left: 20px" class="text-danger">Delete</a>
@endif --}}
