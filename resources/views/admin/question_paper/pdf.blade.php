<style>
    .quesType {
        font-size: 18px;
        border-bottom: 1px solid gray;
        margin-bottom: 10px !important;
        margin-top: 5px !important;
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

    .sl {
        width: 22px
    }

    .chapter {
        margin: 5px 0;
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


<div class="navy">
    <div class="title">

        <h4 class="exam_title">
            @if ($questionInfo->status == 'Pending')
                 <h2>Draft Question Paper</h2>
            @endif
            {{ $questionInfo->exam->name }} -
            {{ \Carbon\Carbon::parse($questionInfo->date)->format('F Y') }}
        </h4>
        {{-- <h4 class="exam_title">TRADE: {{ $questionInfo->subject->trade }}</h4> --}}
        {{-- <h4 style="margin-bottom: 15px" class="exam_title">SUBJECT: {{ $questionInfo->subject->name }}</h4> --}}
        <table class="table table-bordered text-left">
            {{-- <tr>
                <td>Mode of Examination</td>
                <td>{{ $questionInfo->mode }}</td>
                <td>Total Marks</td>
                <td>{{ $totalMark }}</td>
            </tr> --}}
            <tr>
                <td>Duration of Examination</td>
                <td>{{ $questionInfo->d_hour }} Hrs {{ $questionInfo->d_minute }} Min</td>
                <td>Pass Marks</td>
                {{-- <td>{{ $passMark }}</td> --}}
            </tr>
        </table>
        <p style="margin: 6px 0px"><b>{{ $questionInfo->note }}</b></p>
        <p style="margin-bottom: 10px"><b><u>{{ $questionInfo->option_note }}</u></b></p>
    </div>
</div>
<br>

<table>
    <tr>
        <td>Question</td>
        <td style="text-align: right">Marks</td>
    </tr>
</table>


@foreach ($questionSubjectInfos as $questionSubjectInfo)
<div class="subject">
    <h3>Subject: {{ $questionSubjectInfo->subject->name }}</h3>
    <h3>Mark: 20</h3>
</div>
@php $x = 1 @endphp
    {{-- <h4 class="chapter"><u>{{ $questionPapers->first()->question->chapter->name }}</u></h4> --}}
    @foreach ($questionSubjectInfo->questionPapers as $questionPaper)
        <table style="width: 100%">
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
@endforeach
<br>

<header>
    <p style="display: block; width: 100%;">CONFIDENTIAL <br>EXAM IN CONFIDENCE </p>
</header>
<footer>
    <p style="display: block; width: 100%;">EXAM IN CONFIDENCE <br>CONFIDENTIAL</p>
</footer>

<script type="text/php">
    if (isset($pdf)) {
        $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
        $size = 8;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2 + 20;
        $y = $pdf->get_height() - 70;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
