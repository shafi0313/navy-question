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


    .navy table,.navy th,.navy td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    table {
        width: 100%;
    }

    .sl {
        width: 22px
    }
</style>

<div class="navy">
    <div class="title">
        <h4>CONFIDENTIAL</h4>
        <h4>EXAM IN CONFIDENCE</h4>
        <h4>PROGRAM EXAM FOR THE RANK OF {{$questionPapers->first()->quesInfo->name}}</h4>
        <h4>TRADE: {{$questionPapers->first()->quesInfo->trade}}</h4>
        <h4>SUBJECT: {{ $questionPapers->first()->question->subject->name }}</h4>
        <table>
            <tr>
                <td>Mode of Examination</td>
                <td>{{$questionPapers->first()->quesInfo->mode}}</td>
                <td>Total Marks</td>
                <td>{{$totalMark}}</td>
            </tr>
            <tr>
                <td>Duration of Examination</td>
                <td>{{$questionPapers->first()->quesInfo->d_hour}} Hrs {{$questionPapers->first()->quesInfo->d_minute}}
                    Min</td>
                <td>Pass Marks</td>
                <td>{{$passMark}}</td>
            </tr>
        </table>
    </div>
</div>
<br>


<table>
    <tr>
        <td>Question</td>
        <td style="text-align: right">Marks</td>
    </tr>
</table>


@php $x = 1 @endphp
@if($questionPapers->where('type','Multiple Choice')->count() > 0)
    <h4 class="quesType">Multiple Choice</h4>
    @foreach ($questionPapers->where('type','Multiple Choice') as $key => $question)
        <table style="width: 100%">
            <tr>
                <td class="sl">{{$x++}}. </td>
                <td style="text-align:left;">{!! $question->question->ques !!}</td>
                <td style="text-align:right">{{ $question->question->mark }}</td>
            </tr>
        </table>
        @isset($question->question->image)
            <img src="{{asset('uploads/images/question/'.$question->question->image)}}" alt="">
        @endisset

        @foreach ($question->question->options as $option)
            <div class="col-md-6 option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$option->id}}" id="exampleRadios{{$option->id}}">
                    <label class="form-check-label" for="exampleRadios{{$option->id}}" id="exampleRadios{{$option->id}}">
                        {{ $option->option }}
                    </label>
                </div>
            </div>
        @endforeach
        </div>
    @endforeach
    <br>
@endif


@if ($questionPapers->where('type','Short Question')->count() > 0)
    <h4 class="quesType">Short Question</h4>
    @foreach ($questionPapers->where('type','Short Question') as $question)
        <table style="width: 100%">
            <tr>
                <td class="sl">{{$x++}}. </td>
                <td style="text-align:left;">{!! $question->question->ques !!}</td>
                <td style="text-align:right">{{ $question->question->mark }}</td>
            </tr>
        </table>
        @isset($question->question->image)
            <img src="{{asset('uploads/images/question/'.$question->question->image)}}" alt="">
        @endisset
    @endforeach
    <br>
@endif

@if ($questionPapers->where('type','Long Question')->count() > 0)
<h4 class="quesType">Long Question</h4>
@foreach ($questionPapers->where('type','Short Question') as $question)
<table style="width: 100%">
    <tr>
        <td class="sl">{{$x++}}. </td>
        <td style="text-align:left;">{!! $question->question->ques !!}</td>
        <td style="text-align:right">{{ $question->question->mark }}</td>
    </tr>
</table>
@isset($question->question->image)
<img src="{{asset('uploads/images/question/'.$question->question->image)}}" alt="">
@endisset
@endforeach
<br>
@endif
<script type="text/php">
    if (isset($pdf)) {
        $text = "page {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
