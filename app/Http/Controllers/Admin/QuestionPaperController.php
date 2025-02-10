<?php

namespace App\Http\Controllers\Admin;

// use Mpdf\Mpdf;
// use PDF;
use App\Models\QuesInfo;
use App\Models\QuestionInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use Spatie\LaravelPdf\Enums\Unit;
use App\Traits\QuestionPaperTrait;
use Spatie\LaravelPdf\Facades\Pdf;
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
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Draft' : 'Created';
                })
                // ->addColumn('duration', function ($row) {
                //     return $row->d_hour . ':' . $row->d_minute . ' Minute';
                // })
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
                        $btn .= '<a href="' . route('admin.generated_question.show', [$row->id, $i, 'show']) . '" class="badge mb-1" style="background-color: ' . htmlspecialchars($colorCode) . '; color: white;">Set ' . questionSetBn($i) . '</a> ';
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
                        $btn .= '<a href="' . route('admin.generated_question.answer_sheet', [$row->id, $i, 'pdf']) . '" class="badge mb-1" style="background-color: ' . htmlspecialchars($colorCode) . '; color: white;">Set ' . questionSetBn($i) . '</a> ';
                    }

                    return $btn;
                })
                ->rawColumns(['answer', 'set'])
                ->make(true);
        }

        return view('admin.question_paper.index');
    }

    public function show($quesInfoId, $set, $type)
    {
        // return base_path('public/fonts/Nirmala.ttf');
        $data = $this->questionPaperShow($quesInfoId, $set, $type);

        if ($type == 'show') {
            return view('admin.question_paper.show', $data);
        } elseif ($type == 'pdf') {
            // return $data;
            // return view('admin.question_paper.pdf', $data);
            $filePath = public_path('uploads/question/' . slug($data['questionInfo']->exam_name) . '-' . questionSetBn($set) . '.pdf');
            Pdf::view('admin.question_paper.pdf', $data)
                ->format('a4')
                ->margins(80, 80, 80, 80, Unit::Pixel)
                ->save($filePath);

            if (file_exists($filePath)) {
                return response()->download($filePath)->deleteFileAfterSend(true);
            }
        }
    }

    public function answerSheet($quesInfoId, $set, $type)
    {
        $data = $this->questionPaperShow($quesInfoId, $set, $type);

        if ($type == 'show') {
            return view('admin.question_paper.answer_sheet', $data);
        } elseif ($type == 'pdf') {
            // return $data;
            // return view('admin.question_paper.answer_sheet_pdf', $data);
            $filePath = public_path('uploads/question/উত্তর-পত্র-' . slug($data['questionInfo']->exam_name) . '-' . questionSetBn($set) . '.pdf');
            Pdf::view('admin.question_paper.answer_sheet_pdf', $data)
                ->format('a4')
                // ->landscape()
                ->save($filePath);

            if (file_exists($filePath)) {
                return response()->download($filePath)->deleteFileAfterSend(true);
            }


            // return view('admin.question_paper.answer_sheet_pdf', $data);
            // $pdf = PDF::loadView('admin.question_paper.answer_sheet_pdf', $data);

            // return $pdf->download($data['questionInfo']->exam_name . ' - ' . date('h:i:sa d-M-Y') . '.pdf');
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
