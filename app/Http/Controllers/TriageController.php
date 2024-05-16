<?php

namespace App\Http\Controllers;

use App\Models\Triage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Mockery\Matcher\Any;

class TriageController extends Controller
{
    public function triageStepOne(): View
    {
        return view('triage.step-one');
    }

    public function createTriageStepOne(Request $request)
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
        // $request->session()->forget('triage');
        if (empty($request->session()->get('triage'))) {
            return redirect()->route('triage.step.one');
        }
        return view('triage.step-two');
    }

    public function createTriageStepTwo(Request $request)
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
            "mental" => "required",
            "pain" => "required",
            "nrs_pain" => "required"
        ]);
        // dd($validatedData);

        $triage = $request->session()->get('triage');

        $triage->fill($validatedData);

        $request->session()->put('triage', $triage);

        $result = $this->predictTriage($triage);
        $request->session()->forget('triage');

        return redirect()->route('triage.result')->with('result', $result);
    }

    public function predictionResult(Request $request)
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
            "Patients number per hour" => [6],
            "Age" => [(int)$attributes['age']],
            "NRS_pain" => [(int)$attributes['nrs_pain'] ?? 0],
            "SBP" => [(int)$attributes['sbp']],
            "DBP" => [(int)$attributes['dbp']],
            "HR" => [(int)$attributes['hr']],
            "RR" => [(int)$attributes['rr']],
            "BT" => [(int)$attributes['bt']],
            "Saturation" => [(int)$attributes['saturation']],
            "Group_Regional ED" => [0],
            "Sex_Male" => [$attributes['gender'] == 'male' ? 1 : 0],
            "Arrival mode_Private Ambulance" => [$attributes['arrival_mode'] == 2 ? 1 : 0],
            "Arrival mode_Private Vehicle" => [$attributes['arrival_mode'] == 3 ? 1 : 0],
            "Arrival mode_Public Ambulance" => [$attributes['arrival_mode'] == 1 ? 1 : 0],
            "Arrival mode_Walking" => [$attributes['arrival_mode'] == 4 ? 1 : 0],
            "Injury_Yes" => [(int)$attributes['injury'] ?? 0],
            "Mental_Pain Response" => [$attributes['mental'] == 3 ? 1 : 0],
            "Mental_Unresponsive" => [$attributes['mental'] == 4 ? 1 : 0],
            "Mental_Verbose Response" => [$attributes['mental'] == 2 ? 1 : 0],
            "Pain_Yes" => [(int)$attributes['pain'] ?? 0],
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
}
