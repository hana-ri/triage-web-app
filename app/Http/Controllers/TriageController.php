<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Triage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TriageController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Triage::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', fn($row) => view('admin.roles-and-permissions.action', ['row' => $row]))
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dashboard');
    }
    public function triageStepOne(Request $request): View
    {
        $request->session()->forget('triage');

        return view('triage.step-one');
    }

    public function triageStepOneProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
        ]);

        if (empty($request->session()->get('triage'))) {
            $triage = new Triage();
            $triage->fill($validatedData);
            $request->session()->put('triage', $triage);
        } else {
            $triage = $request->session()->get('triage');
            $triage->fill($validatedData);
            $request->session()->put('triage', $triage);
        }

        return redirect()->route('triage.step.two');
    }

    public function triageStepTwo(Request $request)
    {
        // dd(Setting::where('key', 'hospital_type')->pluck('value')->first());
        // $request->session()->forget('triage');
        if (empty($request->session()->get('triage'))) {
            return redirect()->route('triage.step.one');
        }
        return view('triage.step-two');
    }

    public function triageStepTwoProcess(Request $request)
    {
        $validatedData = $request->validate([
            "sbp" => "required",
            "dbp" => "required",
            "hr" => "required",
            "rr" => "required",
            "bt" => "required",
            "saturation" => "required",
            "arrival_mode" => "required",
            "injury" => "required",
            "AVPU_scale" => "required",
            "is_pain" => "required",
            "nrs_pain" => "required"
        ]);

        $startDate = Carbon::parse($request->input('start_date', now()->startOfDay()));
        $endDate = Carbon::parse($request->input('end_date', now()->endOfDay()));
        $validatedData["patients_number_per_hour"] = $this->getPatientCountPerHour($startDate, $endDate)->last() ?? 1;

        $validatedData["hospital_type"] = Setting::where('key', 'hospital_type')->pluck('value')->first();

        $triage = $request->session()->get('triage');

        $triage->fill($validatedData);
        $request->session()->put('triage', $triage);

        $modelResponse = $this->predictTriage($triage);
        $triage["prediction_level"] = $modelResponse['result'];

        $triage->save();
        $request->session()->forget('triage');

        return redirect()->route('triage.prediction.result')->with('result', $modelResponse);
    }

    public function triagePredictionResult(Request $request)
    {
        if (!session('result')) {
            $request->session()->forget('triage');
            return redirect()->route('triage.step.one');
        }

        $predictionResult = session('result');
        // $predictionResult = ['result' => 'Level 1'];

        return view('triage.prediction-result', ["data" => $predictionResult]);
    }

    public function predictTriage($data)
    {
        $attributes = $data->attributesToArray();

        // Susun data sesuai dengan format yang diinginkan
        $data = [
            "Patients number per hour" => [(int)$attributes["patients_number_per_hour"]],
            "Age" => [(int)$attributes['age']],
            "NRS_pain" => [(int)$attributes['nrs_pain'] ?? 0],
            "SBP" => [(int)$attributes['sbp']],
            "DBP" => [(int)$attributes['dbp']],
            "HR" => [(int)$attributes['hr']],
            "RR" => [(int)$attributes['rr']],
            "BT" => [(int)$attributes['bt']],
            "Saturation" => [(int)$attributes['saturation']],
            "Group_Regional ED" => [(int)$attributes["hospital_type"] == 'regional' ? 1 : 0 ],
            "Sex_Male" => [$attributes['gender'] == 'male' ? 1 : 0],
            "Arrival mode_Private Ambulance" => [$attributes['arrival_mode'] == 2 ? 1 : 0],
            "Arrival mode_Private Vehicle" => [$attributes['arrival_mode'] == 3 ? 1 : 0],
            "Arrival mode_Public Ambulance" => [$attributes['arrival_mode'] == 1 ? 1 : 0],
            "Arrival mode_Walking" => [$attributes['arrival_mode'] == 4 ? 1 : 0],
            "Injury_Yes" => [(int)$attributes['injury'] ?? 0],
            "Mental_Pain Response" => [$attributes['AVPU_scale'] == 3 ? 1 : 0],
            "Mental_Unresponsive" => [$attributes['AVPU_scale'] == 4 ? 1 : 0],
            "Mental_Verbose Response" => [$attributes['AVPU_scale'] == 2 ? 1 : 0],
            "Pain_Yes" => [(int)$attributes['is_pain'] ?? 0],
        ];

        $client = new Client();

        try {
            $response = $client->post('http://127.0.0.1:5000/predict/create', [
                'json' => $data
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return $responseBody;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = json_decode($e->getResponse()->getBody(), true);
                return response()->json(['error' => $errorBody], $e->getResponse()->getStatusCode());
            } else {
                return response()->json(['error' => 'Request failed'], 500);
            }
        }
    }

    public function getPatientCountPerHour(Carbon $startDate, Carbon $endDate) {
        return Triage::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d H:00:00'); // Group by hour
            })
            ->map(function ($hour) {
                return count($hour); // Count patients per hour
            });
    }
}
