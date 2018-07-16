<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Sms;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use FPDF;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort     = explode('|', $request->query('sort', 'id|asc'));
        $page     = (int) $request->get('page', 1);
        $limit    = 10;
        $total    = Sms::all()->count();
        $lastPage = ceil($total / $limit);
        $offset   = ($page - 1) * $limit;
        $from     = $offset;
        $to       = $from + $limit;
        $data     = Sms::limit($limit)
            ->offset($offset)
            ->orderBy($sort[0], $sort[1]);

        // Apply Filter
        if ($receiver = $request->input('receiver')) {
            $data->where('receiver', 'like', '%' . $receiver. '%');
            // $data->where('receiver', 'like', '%' . $msisdn. '%');
        }

        if (! empty($startDate = $request->input('start-date')) &&
            ! empty($endDate = $request->input('end-date'))) {
            $data->whereBetween('received', [
                date('Y-m-d H:i:s', strtotime($startDate)),
                date('Y-m-d H:i:s', strtotime($endDate))
            ]);
        }
        return response()->json([
            'total'         => $total,
            'per_page'      => $limit,
            'current_page'  => $page,
            'last_page'     => $lastPage,
            'next_page_url' => ($page == $lastPage) ? null : url()->current() . '?page=' . ($page + 1),
            'prev_page_url' => ($page == 1) ? null : url()->current() . '?page=' . ($page - 1),
            'to'            => $to,
            'from'          => $from,
            'data'          => $data->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Sms::find($id);
        return response()->json($result);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'telepon' => 'bail|required',
            'email'    => 'bail|required|email'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors' => $errors->all()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = Sms::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->telepon = $request->input('telepon');
        $user->level = $request->input('level');
        $user->nm_merchant = $request->input('nm_merchant');
        $user->logo = $request->input('logo');
        if(!empty($request->input('password'))){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return response()->json([
            'success' => true
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Sms::find($id);
        $user->delete();
        return response()->json([
            'succcess' => true
        ]);
    }

    /**
     * Download PDF
     * @return [type] [description]
     */
    public function downloadPDF(Request $request) {
        $sms = Sms::orderBy('id', 'asc');
        foreach ($request->input('data') as $key => $val) {
            $sms->orWhere('id', $val);
        }
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 7);

        $pdf->Cell(25, 7, 'Date & time', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Amount', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Receiver', 1, 0, 'C');
        $pdf->Cell(20, 7, 'MSISDN', 1, 0, 'C');
        $pdf->Cell(88, 7, 'Message', 1, 0, 'C');
        $pdf->ln();

        $pdf->SetFont('Arial','', 7);
        foreach ($sms->get() as $val) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $height = 10;

            $pdf->MultiCell(25, $height, $val->received, 1, 'C');

            $pdf->SetXY($x += 25, $y);
            $pdf->MultiCell(25, $height, 'Rp.' . number_format(
                $val->amount,
                2,
                '.',
                ','
            ), 1, 'C');
            $pdf->SetXY($x += 25, $y);
            $pdf->MultiCell(30, $height, number_format(
                $val->receiver,
                3,
                ' ',
                ' '
            ), 1, 'C');

            $pdf->SetXY($x += 30, $y);
            $pdf->MultiCell(20, $height, $val->sdn, 1, 'C');

            $pdf->SetXY($x += 20, $y);
            $pdf->MultiCell(88, $height, 'Message', 1, 'C');
        }

        $pdf->ln();

        $response = $pdf->Output('s');

        return response($response, 200)
                  ->header('Content-Type', 'application/pdf');
    }
}
