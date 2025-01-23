<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\QuesInfo;
use App\Models\QuestionInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Traits\QuestionPaperTrait;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuestionPaperController extends Controller
{
    use QuestionPaperTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $queInfos = QuestionInfo::with([
                'exam:id,name',
                'rank:id,name',
                'questionSubjectInfo'
            ])
                ->whereStatus(2)
                ->latest();

            return DataTables::of($queInfos)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return bdDate($row->date);
                })
                ->addColumn('time', function ($row) {
                    return time12($row->time);
                })
                ->addColumn('duration', function ($row) {
                    return $row->d_hour . ':' . $row->d_minute . ' Minute';
                })
                // ->addColumn('content', function ($row) {
                //     return '<textarea class="form-control">'.strip_tags($row->content).'</textarea>';
                // })
                ->addColumn('set', function ($row) {
                    $setColorCodes = [
                        1 => '#dc3545', // Red (Bootstrap's badge-danger)
                        2 => '#6c757d', // Brown/Secondary
                        3 => '#ffc107', // Yellow (Bootstrap's badge-warning)
                        4 => '#007bff', // Blue (Bootstrap's badge-primary)
                        5 => '#6f42c1', // Purple (custom color)
                        6 => '#28a745', // Green (Bootstrap's badge-success)
                    ];

                    $btn = '';
                    for ($i = 1; $i <= 6; $i++) {
                        $colorCode = $setColorCodes[$i];
                        $btn .= '<a href="' . route('admin.generated_question.show', [$row->id, $i, 'show']) . '" class="badge mb-1" style="background-color: ' . htmlspecialchars($colorCode) . '; color: white;">Set ' . questionSetInBangla($i) . '</a> ';
                    }

                    return $btn;
                })
                ->addColumn('answer', function ($row) {
                    $setColorCodes = [
                        1 => '#dc3545', // Red (Bootstrap's badge-danger)
                        2 => '#6c757d', // Brown/Secondary
                        3 => '#ffc107', // Yellow (Bootstrap's badge-warning)
                        4 => '#007bff', // Blue (Bootstrap's badge-primary)
                        5 => '#6f42c1', // Purple (custom color)
                        6 => '#28a745', // Green (Bootstrap's badge-success)
                    ];

                    $btn = '';
                    for ($i = 1; $i <= 6; $i++) {
                        $colorCode = $setColorCodes[$i];
                        $btn .= '<a href="' . route('admin.generated_question.answer_sheet', [$row->id, $i, 'pdf']) . '" class="badge mb-1" style="background-color: ' . htmlspecialchars($colorCode) . '; color: white;">Set ' . questionSetInBangla($i) . '</a> ';
                    }

                    return $btn;
                })
                // ->addColumn('action', function ($row) {
                //     $btn = '';
                //     if (userCan('slider-edit')) {
                //         $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.sliders.edit', $row->id), 'row' => $row]);
                //     }
                //     if (userCan('slider-delete')) {
                //         $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.sliders.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                //     }

                //     return $btn;
                // })
                ->rawColumns(['answer', 'set', 'generate', 'action'])
                ->make(true);
        }

        return view('admin.question_paper.index');
    }

    public function show($quesInfoId, $set, $type)
    {
        $data = $this->questionPaperShow($quesInfoId, $set, $type);

        if ($type == 'show') {
            return view('admin.question_paper.pdf', $data);
        } elseif ($type == 'pdf') {
            // return $data;
            // return view('admin.question_paper.pdf', $data);
            $pdf = PDF::loadView('admin.question_paper.pdf', $data);

            return $pdf->download($data['questionInfo']->exam_name . ' - ' . date('h:i:sa d-M-Y') . '.pdf');
        }
    }

    public function questionPFD()
    {
        Browsershot::url('http://navy-question.test/admin/question-paper/show/1/1/show')->savePdf('example2.pdf');

        // Browsershot::url('https://www.itsolutionstuff.com')
        //     ->setOption('landscape', true)
        //     ->windowSize(3840, 2160)
        //     ->waitUntilNetworkIdle()
        //     ->save('itsolutionstuff.jpg');
        // dd("Done");
    }

    public function answerSheet($quesInfoId, $set, $type)
    {
        $data = $this->questionPaperShow($quesInfoId, $set, $type);

        if ($type == 'show') {
            return view('admin.question_paper.answer_sheet', $data);
        } elseif ($type == 'pdf') {
            // return $data;
            // return view('admin.question_paper.pdf', $data);
            $pdf = PDF::loadView('admin.question_paper.answer_sheet_pdf', $data);

            return $pdf->download($data['questionInfo']->exam_name . ' - ' . date('h:i:sa d-M-Y') . '.pdf');
        }
    }

    public function destroy($id)
    {
        try {
            QuesInfo::find($id)->delete();
            QuestionPaper::whereQues_info_id($id)->delete();
            toast('Success!', 'success');

            return back();
        } catch (\Exception $ex) {
            toast('Error', 'error');

            return redirect()->back();
        }
    }
}
