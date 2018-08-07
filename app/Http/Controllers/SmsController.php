<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Sms;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
//use GuzzleHttp\psr7\Request;
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
    public function downloadPDF(Request $request){
        $receiver = $_GET['receiver'];
        $startDate  = $_GET['startDate'];
        $endDate = $_GET['endDate'];
        $tgl = date('d F Y');

        $client = new Client(); //GuzzleHttp\Client
        $response = $client->get('https://spi.spicelabs.in/messages/smsTest?sort=received%7Casc&page=1&per_page=10&receiver='.$receiver.'&start-date='.$startDate.'&end-date='.$endDate.'');
        $json = \GuzzleHttp\json_decode($response->getBody());

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->setFont('Arial', '', 9);
        $pdf->Image('images/paypro-logo@2x.png',10,10,-100);
        $pdf->Cell(0, 7, date('F d, Y', strtotime($tgl)), 20, 1, 'R');
        $pdf->ln(3);
        $pdf->setFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Paris Van Java Parking Service ", 20, 1, 'R');
        $pdf->ln(10);
        $pdf->setFont('Arial', 'B', 17);
        $pdf->SetTextColor(138, 39, 133);
        $pdf->Cell(0, 5, "Report ", 20, 1, 'L');
        $pdf->ln(3);
        $pdf->setFont('Arial', '',12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 5, "Receiver (MSISDN)",  7, 1,'L');
        $pdf->setFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, "$receiver From $startDate  -  $endDate", 20, 1, 'L');
        $pdf->ln(3);
        $pdf->setFont('Arial', 'B', 12);
        $total = 0;
        foreach ($json->data as $obj) {
            $total += $obj->amount;
        }
        $pdf->setFont('Arial', 'B', 12);
        $pdf->Cell(0, 5,'Total Amount Rp.' . number_format(
                $total,
                3,
                '.',
                ','
            ), 20, 1, 'L');
        $pdf->ln(7);
        $pdf->SetFont('Arial','B', 12);
        $pdf->Cell(55, 7, 'Date & time', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Amount', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Receiver', 1, 0, 'C');
        $pdf->Cell(25, 7, 'MSISDN', 1, 0, 'C');
        $pdf->ln();

        $pdf->SetFont('Arial','', 10);

        foreach ($json->data as $obj) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $height = 10;

            $pdf->MultiCell(55, $height, $obj->received, 1, 'C');

            $pdf->SetXY($x += 55, $y);
            $pdf->MultiCell(45, $height, 'Rp.' . number_format(
                    $obj->amount,
                    3,
                    '.',
                    ','
                ), 1, 'C');
            $pdf->SetXY($x += 45, $y);

            $pdf->MultiCell(45, $height, $obj->receiver, 1, 'C');
            $pdf->SetXY($x += 45, $y);

            $pdf->MultiCell(25, $height, $obj->msisdn, 1, 'C');
            $total += $obj->amount;
        }
        $response = $pdf->Output('s');
        return response($response, 200)
            ->header('Content-Type', 'application/pdf');
    }
    /**
     * Download PDF
     * @return [type] [description]
     */
    public function downloadPDF2(Request $request) {
        echo "test coba";
        $sms = Sms::orderBy('id', 'asc');
//     $sms = ('http://192.168.2.20:8005/sms/smsTest'):: orderBy('id', 'asc');
        foreach ($request->input('data') as $key => $val) {
            $sms->orWhere('id', $val);
        }
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B', 7);
        $pdf->SetFillColor(128,128,128);
        $pdf->Cell(25, 7, 'Date & time', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Amount', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Receiver', 1, 0, 'C');
        $pdf->Cell(20, 7, 'MSISDN', 1, 0, 'C');
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

        }

        $pdf->ln();

        $response = $pdf->Output('s');

        return response($response, 200)
                  ->header('Content-Type', 'application/pdf');
    }
}
