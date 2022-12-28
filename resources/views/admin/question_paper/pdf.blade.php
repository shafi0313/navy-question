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
        {{-- <p>CONFIDENTIAL</p>
        <p style="margin-bottom: 10px">EXAM IN CONFIDENCE</p> --}}
        <h4 class="exam_title">
            {{ $chapters->first()->first()->quesInfo->exam->name }} -
            {{ \Carbon\Carbon::parse($chapters->first()->first()->quesInfo->date)->format('F Y') }}</h4>
        <h4 class="exam_title">TRADE: {{ $chapters->first()->first()->quesInfo->trade }}</h4>
        <h4 style="margin-bottom: 15px" class="exam_title">SUBJECT:
            {{ $chapters->first()->first()->question->subject->name }}</h4>
        <table class="table table-bordered text-left">
            <tr>
                <td>Mode of Examination</td>
                <td>{{ $chapters->first()->first()->quesInfo->mode }}</td>
                <td>Total Marks</td>
                <td>{{ $totalMark }}</td>
            </tr>
            <tr>
                <td>Duration of Examination</td>
                <td>{{ $chapters->first()->first()->quesInfo->d_hour }} Hrs
                    {{ $chapters->first()->first()->quesInfo->d_minute }} Min</td>
                <td>Pass Marks</td>
                <td>{{ $passMark }}</td>
            </tr>
        </table>
        <p style="margin: 6px 0px"><b>{{ $chapters->first()->first()->quesInfo->note }}</b></p>
        <p style="margin-bottom: 10px"><b><u>{{ $chapters->first()->first()->quesInfo->option_note }}</u></b></p>
    </div>
</div>
<br>

<table>
    <tr>
        <td>Question</td>
        <td style="text-align: right">Marks</td>
    </tr>
</table>
<header>
    <p style="display: block; width: 100%;">EXAM IN CONFIDENCE <br>CONFIDENTIAL</p>
</header>
<footer>
    <p style="display: block; width: 100%;">EXAM IN CONFIDENCE <br>CONFIDENTIAL</p>
</footer>

@php $x = 1 @endphp
@foreach ($chapters as $chapter => $questions)
    <h4 class="chapter"><u>{{ $questions->first()->question->chapter->name }}</u></h4>
    @foreach ($questions as $question)
        <table style="width: 100%">
            <tr>
                <td class="sl">{{ $x++ }}. </td>
                <td style="text-align:left;">{!! $question->question->ques !!}</td>
                <td style="text-align:right">{{ $question->question->mark }}</td>
            </tr>
        </table>
        @isset($question->image)
            <img src="{{ asset('uploads/images/question/' . $question->question->image) }}" alt="">
        @endisset
        @if ($question->options->count() > 0)
            @foreach ($question->options as $option)
                <div class="col-md-6 option">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $option->id }}"
                            id="exampleRadios{{ $option->id }}">
                        <label class="form-check-label" for="exampleRadios{{ $option->id }}"
                            id="exampleRadios{{ $option->id }}">
                            {{ $option->option }}
                        </label>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
    @endforeach
@endforeach
<br>

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
