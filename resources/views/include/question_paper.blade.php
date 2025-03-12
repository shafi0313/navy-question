@include('admin.question_paper.css')

<htmlpageheader name="page-header">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">গোপনীয়</p>
</htmlpageheader>

@foreach ($questionSubjectInfos as $questionSubjectInfo)
    @php
        $totalQuestionMark = 0;
    @endphp
    <div class="navy" style="margin-bottom: 5px">
        <span>{{ questionSetBn((int) $questionSubjectInfo->set) }}</span>
        <div class="title">
            <h4 class="exam_title">
                @if ($questionInfo->status == 'Pending')
                    <h2>Draft Question Paper</h2>
                @endif
                {{ $questionInfo->exam_name }} <br>
                {{ $questionInfo->rank->name }}
            </h4>

            {{-- <table class="table table-bordered text-left">
                <tr>
                    <td>Mode of Examination</td>
                    <td>{{ $questionInfo->mode }}</td>
                    <td>Duration of Examination</td>
                    <td>{{ $questionInfo->d_hour }} Hrs {{ $questionInfo->d_minute }} Min</td>
                </tr>
            </table> --}}
            {{-- <p style="margin: 6px 0px"><b>{{ $questionInfo->note }}</b></p>
            <p style="margin-bottom: 10px"><b><u>{{ $questionInfo->option_note }}</u></b></p> --}}
        </div>
    </div>

    <p class="answer-instruction">
        সঠিক উত্তরটি নির্বাচন করে সরবরাহকৃত উত্তর পত্রে বৃত্ত পূরণ করতে হবে । যে উত্তরটি সঠিক, উত্তর পত্রের বিষয়
        ভিত্তিক
        প্রশ্ন নম্বরে প্রদত্ত ক্রমিকে(ক, খ, গ, ঘ/a, b, c, d) বৃত্ত পূরণ করতে হবে। যেমন 'খ' উত্তরটি সঠিক হলে উত্তর
        পত্রের
        বিষয় ভিত্তিক প্রশ্ন নম্বরের 'খ' উত্তরটিতে বৃত্ত পূরণ করতে হবে। একটি প্রশ্নের জন্য একটি উত্তর পূরণ করতে হবে।
        একাধিক বৃত্ত পূরণ করলে তা বাতিল বলে গণ্য হবে।
    </p>

    {{-- For total question mark start --}}
    @foreach ($questionSubjectInfo->questionPapers as $item)
        @php
            $totalQuestionMark += $item->question->mark ?? 0;
        @endphp
    @endforeach
    {{-- For total question mark end --}}
    @php
        $subject = $questionSubjectInfo->subject->name;
    @endphp
    <table>
        <tr>
            <th style="text-align:left">বিষয়: {{ $subject }}</th>
            <th style="text-align:right">পূর্ণমান:
                @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                    {{ $totalQuestionMark }}
                @else
                    {{ bnNumber($totalQuestionMark) }}
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
                @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                    {{ $questionPaper->question->mark }}
                @else
                    {{ bnNumber($questionPaper->question->mark ?? 0) }}
                @endif

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
                <label class="option">
                    @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                        {{ numberToEnWord($index + 1). ') ' }}
                    @else
                        {{ numberToBnWord($index + 1). ') ' }}
                    @endif
                     {!! $option->option !!}
                </label>
            @endforeach
        @endif
    @endforeach
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
