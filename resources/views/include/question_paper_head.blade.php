
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
                    <h4>PROGRAM EXAM FOR THE RANK OF {{$questionPapers->first()->quesInfo->name}}</h4>
                    <h4>TRADE: {{$questionPapers->first()->quesInfo->trade}}</h4>
                    <h4>SUBJECT: {{ $questionPapers->first()->question->subject->name }}</h4>
                    <table class="table table-bordered text-left">
                        <tr>
                            <td>Mode of Examination</td>
                            <td>{{$questionPapers->first()->quesInfo->mode}}</td>
                            <td>Total Marks</td>
                            <td>{{$totalMark}}</td>
                        </tr>
                        <tr>
                            <td>Duration of Examination</td>
                            <td>{{$questionPapers->first()->quesInfo->d_hour}} Hrs {{$questionPapers->first()->quesInfo->d_minute}} Min</td>
                            <td>Pass Marks</td>
                            <td>{{$passMark}}</td>
                        </tr>
                    </table>
                </div>
            </div>
