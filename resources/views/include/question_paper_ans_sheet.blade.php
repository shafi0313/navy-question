@include('admin.question_paper.css')
{{-- <htmlpageheader name="page-header">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">গোপনীয়</p>
</htmlpageheader> --}}

<style>
    :root {
        --option: #f92d71;
    }

    body {
        margin: 8mm 10mm 10mm 10mm;
    }

    .question-div {
        margin-right: 10px;
        width: 190px;
        display: inline-block;
    }

    table {
        border-collapse: collapse !important;
    }

    table,
    th,
    td {
        border: 1px solid var(--option);
        padding: 5px 8px;
        height: 24px;
    }

    table tr:nth-child(even) {
        background-color: #f433a6 !important;
    }

    .sl {
        color: var(--option);
        font-weight: bold;
        text-align: center;
        width: 25px !important;
    }

    .correct-option {
        text-align: center;
        color: #000;
        border: 1px solid #000;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        display: inline-block;
        background: #000;
    }

    .option {
        text-align: center;
        border: 1px solid var(--option);
        height: 20px;
        width: 20px;
        border-radius: 50%;
        display: inline-block;
        color: var(--option);
    }
</style>

<div class="title" style="margin-bottom: 20px">
    <h4 class="exam_title">
        {{ $questionInfo->exam_name }} <br>
        {{ $questionInfo->rank->name }}
    </h4>
</div>
@foreach ($questionSubjectInfos as $questionSubjectInfo)
    {{-- <div class="row">
    @php
        $totalQuestionMark = 0;
    @endphp
    <div class="navy" style="margin-bottom: 5px">
        <span>{{ questionSetBn((int) $questionSubjectInfo->set) }}</span>
        <div class="title">
            <h4 class="exam_title">
                {{ $questionInfo->exam_name }} <br>
                {{ $questionInfo->rank->name }}
            </h4>
        </div>
    </div>
</div> --}}
    @php
        $subject = $questionSubjectInfo->subject->name;
    @endphp

    <div class="question-div">
        <table>
            <tr>
                <th style="font-size: 12px; width: 25px">প্রশ্ন <br> নং</th>
                <th style="text-align:left; font-size: 14px;">উত্তর
                    ({{ Str::limit($subject, 7) }})
                </th>
            </tr>
        </table>

        {{-- Question paper subject info start --}}
        @php $x = 1 @endphp
        @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
            <table>
                <tr>
                    <td class="sl">
                        @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                            {{ $x++ }}
                        @else
                            {{ bnNumber($x++) }}
                        @endif
                    </td>
                    <td>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($questionPaper->options as $index => $option)
                            @if (!$loop->first)
                                &nbsp;
                            @endif

                            @if ($option->correct == 1)
                                <div class="correct-option">
                                    a
                                </div>
                            @else
                                <div class="option">
                                    <span class="">
                                        @if (in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']))
                                            {{ numberToEnWord($index + 1) }}
                                        @else
                                            {{ numberToBnWord($index + 1) }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        @endforeach
    </div>
@endforeach
