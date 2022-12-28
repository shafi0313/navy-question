<style>
    .title h4 {
        text-align: center;
        padding: 0;
        margin: 0;
        text-transform: uppercase;
    }

    .exam_title {
        text-decoration: underline;
        font-weight: bold;
    }
</style>
<div class="navy">
    <div class="title">
        <p>CONFIDENTIAL</p>
        <p style="margin-bottom: 10px">EXAM IN CONFIDENCE</p>
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
        <p style="margin-bottom: 6px"><b>{{ $chapters->first()->first()->quesInfo->note }}</b></p>
        <p style="margin-bottom: 10px"><b><u>{{ $chapters->first()->first()->quesInfo->option_note }}</u></b></p>
    </div>
</div>
