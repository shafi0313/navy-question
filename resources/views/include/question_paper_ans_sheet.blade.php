@include('admin.question_paper.css')
{{-- <htmlpageheader name="page-header">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">গোপনীয়</p>
</htmlpageheader> --}}

<style>
    :root {
        --option: #f92d71;
        --background: #ecccdf;
    }

    body {
        margin: 8mm 10mm 10mm 10mm;
    }

    .ans-table {
        margin-left: 10px;
    }

    .question-div {
        margin-right: 8px;
        /* width: 190px; */
        width: 128px;
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
        background-color: rgba(248, 155, 210, 0.3) !important;
        /* Adjust the alpha value as needed */
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
    }

    .option span {
        font-size: 12px;
        font-weight: bold;
    }

    /* .ans {
        text-align: center;
        margin-bottom: 10px;
        border: 1px solid var(--option);
        padding: 8px 0;
        background-color: var(--background) !important;
    }

    .ans p {
        font-size: 20px;
        font-weight: bold;
    } */

    .image img {
        width: 98%;
        margin-bottom: 20px;
    }
</style>

<div class="image">
    <img src="{{ asset('uploads/Navy_2023_v3.png') }}" alt="">
</div>

{{-- <div class="title" style="margin-bottom: 20px">
    <h4 class="exam_title">
        {{ $questionInfo->exam_name }} <br>
        {{ $questionInfo->rank->name }}
    </h4>
</div>
<div class="ans">
    <p>উত্তরসমূহ</p>
</div> --}}
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
                                    <span style="padding-right: 3px"></span>
                                    {{-- &nbsp; --}}
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
                    {{-- </table> --}}
                @endforeach
            </tbody>
            </table>
        </div>
    @endforeach
</div>
<div class="image">
    <img src="{{ asset('uploads/Navy_2023_v3_footer.png') }}" alt="">
</div>
