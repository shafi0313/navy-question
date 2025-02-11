@include('admin.question_paper.css')
<style>
    :root {
        --option: #f92d71;
        --background: rgba(248, 155, 210, 0.3) !important;
    }

    body {
        width: 190mm;
        margin: 8mm 10mm 10mm 10mm;

    }

    .body-image {
        margin-left: -10px;
    }

    .body-image img {
        margin-left: 16px;
        height: 313px;

    }

    .ans-table {
        margin-left: 6px;
    }

    .question-div {
        margin-right: 8px;
        /* width: 190px; */
        width: 130px;
        display: inline-block;
    }

    table {
        border-collapse: collapse !important;
    }

    table,
    th,
    td {
        border: 1px solid var(--option);
        padding: 1px 3px;
        height: 24px;
    }

    table tbody tr:nth-child(even) {
        background-color: var(--background);
    }

    .sl {
        color: var(--option);
        font-weight: bold;
        text-align: center;
        /* width: 25px !important; */
        width: 16px !important;
        font-size: 12px;
    }

    .correct-option {
        text-align: center;
        color: #000;
        border: 1px solid #000;
        /* height: 18px;
        width: 18px; */
        height: 16px;
        width: 16px;
        border-radius: 50%;
        display: inline-block;
        background: #000;
    }

    .option {
        text-align: center;
        border: 1px solid var(--option);
        /* height: 20px;
        width: 20px; */
        height: 16px;
        width: 14px;
        border-radius: 50%;
        display: inline-block;
        color: var(--option);
        position: relative;
    }

    .option span {
        font-size: 12px;
        font-weight: bold;
        position: absolute;
        left: 1px;
        top: 0;
    }    

    .option-english span {
        left: 3px;
        top: 0;
    }

    .ans {
        text-align: center;
        margin: 10px 12px 10px 6px;
        border: 1px solid var(--option);
        padding: 5px 0;
        background-color: var(--background);
    }

    .ans p {
        font-size: 16px;
        font-weight: bold;
    }

    .header-image img {
        width: 98%;
        margin-bottom: 20px;
    }
</style>

@php
    $formatPath = 'uploads/question-format/';
    switch ($set) {
        case 1:
            $setPath = $formatPath . 'set_1.png';
            break;
        case 2:
            $setPath = $formatPath . 'set_2.png';
            break;
        case 3:
            $setPath = $formatPath . 'set_3.png';
            break;
        case 4:
            $setPath = $formatPath . 'set_1.png';
            break;
        case 5:
            $setPath = $formatPath . 'set_1.png';
            break;
        case 6:
            $setPath = $formatPath . 'set_1.png';
            break;
        default:
            $setPath = $formatPath . 'set.png';
            break;
    }

    switch ($questionInfo->rank_id) {
        case 1:
            $groupPath = $formatPath . 'group_1.png';
            break;
        case 2:
            $groupPath = $formatPath . 'group_2.png';
            break;
        case 3:
            $groupPath = $formatPath . 'group_3.png';
            break;
        case 4:
            $groupPath = $formatPath . 'group_1.png';
            break;
        case 5:
            $groupPath = $formatPath . 'group_1.png';
            break;
        case 6:
            $groupPath = $formatPath . 'group_1.png';
            break;
        default:
            $groupPath = $formatPath . 'group.png';
            break;
    }
@endphp

{{-- <div class="title" style="margin-bottom: 20px">
    <h4 class="exam_title">
        {{ $questionInfo->exam_name }} <br>
        {{ $questionInfo->rank->name }}
    </h4>
</div> --}}

<div class="header-image">
    <img src="{{ asset($formatPath . '/header.png') }}" alt="">
</div>

<div class="body-image">
    <img src="{{ asset($formatPath . '/roll.png') }}" alt="Roll">
    <img src="{{ asset($setPath) }}" alt="Set">
    <img src="{{ asset($groupPath) }}" alt="Group">
    <img src="{{ asset($formatPath . '/instruction.png') }}" alt="Instruction">
</div>

<div class="ans">
    <p>উত্তরসমূহ</p>
</div>

<div class="ans-table">
    @foreach ($questionSubjectInfos as $questionSubjectInfo)
        @php
            $subject = $questionSubjectInfo->subject->name;
        @endphp

        <div class="question-div">
            <table>
                <tr>
                    {{-- <th style="font-size: 12px; width: 25px">প্রশ্ন <br> নং</th> --}}
                    <th style="font-size: 9px; width: 16px">প্রশ্ন <br> নং</th>
                    <th style="text-align:left; font-size: 10px;">উত্তর
                        ({{ Str::limit($subject, 7) }})
                    </th>
                </tr>
                {{-- </table> --}}

                {{-- Question paper subject info start --}}
                @php $x = 1 @endphp
                <tbody>
                    @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
                        {{-- <table> --}}
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
                                        <span style="padding-right: 4px"></span>
                                        {{-- &nbsp; --}}
                                    @endif

                                    @if ($option->correct == 1)
                                        <div class="correct-option">
                                            a
                                        </div>
                                    @else
                                    @php
                                        $isEnglish = in_array($subject, ['ইংরেজি', 'ইংরেজী', 'English', 'english']);
                                    @endphp
                                        <div class="option {{ $isEnglish ? 'option-english': '' }}">
                                            <span class="">
                                                @if ($isEnglish)
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
                        {{-- </table> --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<div class="footer-image">
    <img src="{{ asset('uploads/Navy_2023_v3_footer.png') }}" style="width: 98%;" alt="">
</div>
