@include('admin.question_paper.css')
{{-- <htmlpageheader name="page-header">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">গোপনীয়</p>
</htmlpageheader> --}}

<style>
    :root {
        --option: #f92d71;
    }

    .question-div {
        /* margin-top: 20px; */
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
        color: var(--option);
        border: 1px solid var(--option);
        height: 20px;
        width: 20px;
        border-radius: 50%;
        display: inline-block;
        background: var(--option);
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

@foreach ($questionSubjectInfos as $questionSubjectInfo)
    {{-- <div class="row">
    @php
        $totalQuestionMark = 0;
    @endphp
    <div class="navy" style="margin-bottom: 5px">
        <span>{{ questionSetInBangla((int) $questionSubjectInfo->set) }}</span>
        <div class="title">
            <h4 class="exam_title">
                {{ $questionInfo->exam_name }} <br>
                {{ $questionInfo->rank->name }}
            </h4>
        </div>
    </div>
</div> --}}


    <div class="question-div">
        <table>
            <tr>
                <th style="font-size: 12px; width: 25px">প্রশ্ন <br> নং</th>
                <th style="text-align:left; font-size: 14px;">উত্তর
                    ({{ Str::limit($questionSubjectInfo->subject->name, 7) }})
                </th>
            </tr>
        </table>
        @php $x = 1 @endphp

        {{-- Question paper subject info start --}}
        @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
            <table>
                <tr>
                    <td class="sl">{{ banglaNumber($x++) }} </td>
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
                                    <i class="fa-regular fa-circle-check"></i>
                                </div>
                            @else
                                <div class="option">
                                    <span class="">
                                        {{ numberToBanglaWord($index + 1) }}
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
