@include('admin.question_paper.css')
{{-- <style>
    header {
        display: flex;
        margin-top: 150px;
        justify-content: space-between;
     }
</style>
<header>
    <p>1R</p>
    <p>Page @pageNumber of @totalPages</p>
    <p>1R</p>     
</header> --}}

<div>
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">গোপনীয়</p>
</div>

<div class="navy" style="margin-bottom: 5px;">
    <span>{{ questionSetBn((int) $questionSubjectInfos->first()->set) }}</span>
    <div class="title" style="text-align: center">
        <h4 class="exam_title">
            @if ($questionInfo->status == 1)
                <h2>Draft Question Paper</h2>
            @endif
            {{ $questionInfo->exam_name }} <br>
            {{ $questionInfo->rank->name }}
        </h4>
    </div>
</div>

<p class="answer-instruction" style="text-align: justify; margin-bottom: 20px;">
    সঠিক উত্তরটি নির্বাচন করে সরবরাহকৃত উত্তর পত্রে বৃত্ত পূরণ করতে হবে । যে উত্তরটি সঠিক, উত্তর পত্রের বিষয়
    ভিত্তিক
    প্রশ্ন নম্বরে প্রদত্ত ক্রমিকে(ক, খ, গ, ঘ/a, b, c, d) বৃত্ত পূরণ করতে হবে। যেমন 'খ' উত্তরটি সঠিক হলে উত্তর
    পত্রের
    বিষয় ভিত্তিক প্রশ্ন নম্বরের 'খ' উত্তরটিতে বৃত্ত পূরণ করতে হবে। একটি প্রশ্নের জন্য একটি উত্তর পূরণ করতে হবে।
    একাধিক বৃত্ত পূরণ করলে তা বাতিল বলে গণ্য হবে।
</p>

@foreach ($questionSubjectInfos as $questionSubjectInfo)
    @php
        $totalQuestionMark = 0;
    @endphp

    {{-- For total question mark start --}}
    @foreach ($questionSubjectInfo->questionPapers as $item)
        @php
            $totalQuestionMark += $item->question->mark ?? 0;
        @endphp
    @endforeach
    {{-- For total question mark end --}}

    @if (!$loop->first)
        <div style="margin: 12px 0 8px 0;">
            .............................................................................................................................................................................
        </div>
    @endif

    @php
        $subject = $questionSubjectInfo->subject->name;
    @endphp
    <table>
        <tr>
            <th style="text-align:left">বিষয়: {{ $subject }}</th>
            <th style="text-align:right">পূর্ণমান: 
                @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                    2x10={{ $totalQuestionMark }}
                @else
                {{ bnNumber(2) }}x{{ bnNumber(10) }}={{ bnNumber($totalQuestionMark) }}
                @endif
            </th>
        </tr>
    </table>

    {{-- Question paper subject info start --}}
    @php $x = 1 @endphp
    @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
        <input type="hidden" name="get_question_id[]" value="{{ $questionPaper->question_id }}">
        <input type="hidden" name="question_subject_info_id[]" value="{{ $questionPaper->question_subject_info_id }}">
        <table class="question-table">
            <td class="sl">
                @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                    {{ $x++ }}
                @else
                    {{ bnNumber($x++) }}
                @endif
                .
            </td>
            <td style="text-align:left;">{!! $questionPaper->question->ques ?? '' !!}</td>
            <td style="text-align:right">
                {{-- @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                    {{ $questionPaper->question->mark }}
                @else
                    {{ bnNumber($questionPaper->question->mark ?? 0) }}
                @endif --}}

                <span>
                    @if (!empty($edit))
                        <a href="{{ route('admin.generate_question.edit', [$questionPaper->question->id, $questionInfo->id, $set]) }}"
                            style="margin-left: 20px" class="text-info">Edit</a>
                    @endif
                    @if (!empty($delete))
                        <a href="{{ route('admin.generate_question.quesDestroy', $questionPaper->id) }}"
                            style="margin-left: 20px" class="text-danger"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    @endif
                </span>
            </td>
            </tr>
        </table>
        @if ($questionPaper->question?->image)
            <img src="{{ asset('uploads/images/question/' . $questionPaper->question->image) }}" alt="">
        @endif
        @if ($questionPaper->options)
            @php
                $i = 1;
            @endphp
            @foreach ($questionPaper->options as $index => $option)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @php
                    if ($questionInfo->status == 1 && $option->correct == 1) {
                        $correct = 1;
                    }else{
                        $correct = 0;
                    }
                @endphp
                <label class="option {{ $correct == 1 ? 'correct' : '' }}">
                    @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                        {{ numberToEnWord($index + 1) . ') ' }}
                    @else
                        {{ numberToBnWord($index + 1) . ') ' }}
                    @endif
                    {!! $option->option !!}
                </label>
            @endforeach
        @endif
    @endforeach
    {{-- @if (!$loop->last)
        <div class="page-break"></div>
    @endif --}}
@endforeach
