
@include('admin.question_paper.css')
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
            <span>{{ questionSetInBangla((int) $questionSubjectInfo->set) }}</span>
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
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">CONFIDENTIAL <br>EXAM IN CONFIDENCE
    </p>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <p style="display: block; width: 100%; text-align: center; line-height: 15px">EXAM IN CONFIDENCE <br>CONFIDENTIAL
    </p>
</htmlpagefooter>


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
