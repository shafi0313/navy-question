<style>
    body {
        font-family: 'bangla', sans-serif;
    }

    .option {
        margin-left: 30px;
    }

    .form-check [type=checkbox]:checked,
    .form-check [type=checkbox]:not(:checked) {
        position: absolute;
        left: 0;
    }

    .form-check,
    .form-group {
        margin-bottom: 0;
        padding: 0px;
    }

    .title h4 {
        text-align: center;
        padding: 0;
        margin: 0;
        text-transform: uppercase;
    }

    .title p {
        text-align: center;
        padding: 0;
        margin: 0;
        text-transform: uppercase;
    }


    .navy table,
    .navy th,
    .navy td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    table {
        width: 100%;
    }

    .question-table tr td {
        padding: 10px 0;
    }

    .sl {
        width: 22px
    }

    p {
        padding: 0;
        margin: 0;
    }

    .exam_title {
        text-decoration: underline;
        font-weight: bold;
    }

    @page {
        margin-bottom: 100px;
        margin-top: 60px;
    }

    @page {
        header: page-header;
        footer: page-footer;
    }

    .page-break {
        page-break-after: always;
    }

    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        text-align: center;
        font-size: 12px;
        width: 100%;
        z-index: 1;
    }

    header {
        position: fixed;
        top: -30px;
        /* height: 50px; */
        text-align: center;
        font-size: 12px;
        width: 100%;
        z-index: 1;
    }
</style>

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
    @foreach ($questionSubjectInfo->questionPapers as $item)
        @php
            $totalQuestionMark += $item->question->mark;
        @endphp
    @endforeach
    <table style="margin-bottom: 20px">
        <tr>
            <td>বিষয়: {{ $questionSubjectInfo->subject->name }}</td>
            <th style="text-align:right">পূর্ণমান: {{ $totalQuestionMark }}</th>
        </tr>
    </table>
    @php $x = 1 @endphp
    @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
        <table class="question-table">
            <tr>
                <td class="sl">{{ $x++ }}. </td>
                <td style="text-align:left;">{!! $questionPaper->question->ques !!}</td>
                <td style="text-align:right">{{ $questionPaper->question->mark }}</td>
            </tr>
        </table>
        @if ($questionPaper->question->image)
            <img src="{{ asset('uploads/images/question/' . $questionPaper->question->image) }}" alt="">
        @endif
        @if ($questionPaper->options)
            @foreach ($questionPaper->options as $option)
                <div class="col-md-6 option">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $option->id }}"
                            id="exampleRadios{{ $option->id }}">
                        <label class="form-check-label" for="exampleRadios{{ $option->id }}">
                            {{ $option->option }}
                        </label>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
    <div class="page-break"></div>
@endforeach
<br>

<htmlpageheader name="page-header">
    <p style="display: block; width: 100%;">CONFIDENTIAL <br>EXAM IN CONFIDENCE </p>
</htmlpageheader>
{{-- <header>
    <p style="display: block; width: 100%;">CONFIDENTIAL <br>EXAM IN CONFIDENCE </p>
</header> --}}
<htmlpagefooter name="page-footer">
    <p style="display: block; width: 100%;">EXAM IN CONFIDENCE <br>CONFIDENTIAL</p>
</htmlpagefooter>
{{-- <footer>
    <p style="display: block; width: 100%;">EXAM IN CONFIDENCE <br>CONFIDENTIAL</p>
</footer> --}}

{{-- <script type="text/php">
    if (isset($pdf)) {
        $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
        $size = 8;
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2 + 20;
        $y = $pdf->get_height() - 70;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script> --}}
