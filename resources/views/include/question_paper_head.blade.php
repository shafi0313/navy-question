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
            {{ $quesInfo->exam->name }} -
            {{ \Carbon\Carbon::parse($quesInfo->date)->format('F Y') }}</h4>
        <h4 class="exam_title">TRADE: {{ $quesInfo->subject->trade }}</h4>
        <h4 style="margin-bottom: 15px" class="exam_title">SUBJECT:
            {{ $quesInfo->subject->name }}</h4>
        <table class="table table-bordered text-left">
            <tr>
                <td>Mode of Examination</td>
                <td>{{ $quesInfo->mode }}</td>
                <td>Total Marks</td>
                <td>{{ $totalMark }}</td>
            </tr>
            <tr>
                <td>Duration of Examination</td>
                <td>{{ $quesInfo->d_hour }} Hrs
                    {{ $quesInfo->d_minute }} Min</td>
                <td>Pass Marks</td>
                <td>{{ $passMark }}</td>
            </tr>
        </table>
        <p style="margin-bottom: 6px"><b>{{ $quesInfo->note }}</b></p>
        <p style="margin-bottom: 10px"><b><u>{{ $quesInfo->option_note }}</u></b></p>
    </div>
</div>
