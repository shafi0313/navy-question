
            <style>
                .title h4{
                    text-align: center;
                    padding: 0;
                    margin: 0;
                    text-transform: uppercase;
                }
            </style>
            <div class="navy">
                <div class="title">
                    <h4>CONFIDENTIAL</h4>
                    <h4>EXAM IN CONFIDENCE</h4>
                    <h4>PROGRAM EXAM FOR THE RANK OF {{$questionPapers->first()->exam->name}}</h4>
                    <h4>TRADE: {{$questionPapers->first()->exam->trade}}</h4>
                    <h4>SUBJECT: {{ $questionPapers->first()->question->subject->name }}</h4>
                    <table class="table table-bordered text-left">
                        <tr>
                            <td>Mode of Examination</td>
                            <td> : {{$questionPapers->first()->exam->mode}}</td>
                            <td>Total Marks</td>
                            <td> : {{$questionPapers->first()->exam->total_mark}}</td>
                        </tr>
                        <tr>
                            <td>Duration of Examination</td>
                            <td> : {{$questionPapers->first()->exam->duration}}</td>
                            <td>Pass Marks</td>
                            <td>: {{$questionPapers->first()->exam->pass_mark}}</td>
                        </tr>
                    </table>
                </div>
            </div>
