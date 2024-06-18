<?php

namespace App\Http\Controllers;

use App\Models\Triage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TriageController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Triage::latest()->get();

    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('action', fn($row) => view('admin.roles-and-permissions.action', ['row' => $row]))
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('admin.dashboard');
    // }

    public function triageStepOne(Request $request): View
    {
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
        if (empty($request->session()->get('triage'))) {
            return redirect()->route('triage.step.one');
        }
        return view('triage.step-two');
    }

    public function triageStepTwoProcess(Request $request)
    {
        $validatedData = $request->validate([
            'sbp' => 'required',
            'dbp' => 'required',
            'hr' => 'required',
            'rr' => 'required',
            'bt' => 'required',
            'saturation' => 'required',
            'triage_vital_o2_device' => 'required',
            'chief_complaint' => 'required',
        ]);

        $triage = $request->session()->get('triage');
        $validatedData['age'] = $triage->age;

        $triage->fill($validatedData);
        $request->session()->put('triage', $triage);

        $modelResponse = $this->predictTriage($validatedData);

        $triage['prediction_level'] = $modelResponse['result'];

        // $triage->save();
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

        return view('triage.prediction-result', ['data' => $predictionResult]);
    }

    public function predictTriage($data)
    {
        $attributes = $data;

        // Susun data sesuai dengan format yang diinginkan
        $data = [
            "age" => [(int)$attributes['age']],
            "triage_vital_hr" => [(int)$attributes['hr']],
            "triage_vital_sbp" => [(int)$attributes['sbp']],
            "triage_vital_dbp" => [(int)$attributes['dbp']],
            "triage_vital_rr" => [(int)$attributes['rr']],
            "triage_vital_o2" => [(int)$attributes['saturation']],
            "triage_vital_o2_device" => [(int)$attributes['triage_vital_o2_device']],
            "triage_vital_temp" => [(int)$this->celsiusToFahrenheit($attributes['bt'])],
            "cc_abdominalcramping" => [0],
            "cc_abdominaldistention" => [0],
            "cc_abdominalpain" => [0],
            "cc_abdominalpainpregnant" => [0],
            "cc_abnormallab" => [0],
            "cc_abscess" => [0],
            "cc_addictionproblem" => [0],
            "cc_agitation" => [0],
            "cc_alcoholintoxication" => [0],
            "cc_alcoholproblem" => [0],
            "cc_allergicreaction" => [0],
            "cc_alteredmentalstatus" => [0],
            "cc_animalbite" => [0],
            "cc_ankleinjury" => [0],
            "cc_anklepain" => [0],
            "cc_anxiety" => [0],
            "cc_arminjury" => [0],
            "cc_armpain" => [0],
            "cc_armswelling" => [0],
            "cc_assaultvictim" => [0],
            "cc_asthma" => [0],
            "cc_backpain" => [0],
            "cc_bleeding/bruising" => [0],
            "cc_blurredvision" => [0],
            "cc_bodyfluidexposure" => [0],
            "cc_breastpain" => [0],
            "cc_breathingdifficulty" => [0],
            "cc_breathingproblem" => [0],
            "cc_burn" => [0],
            "cc_cardiacarrest" => [0],
            "cc_cellulitis" => [0],
            "cc_chestpain" => [0],
            "cc_chesttightness" => [0],
            "cc_chills" => [0],
            "cc_coldlikesymptoms" => [0],
            "cc_confusion" => [0],
            "cc_conjunctivitis" => [0],
            "cc_constipation" => [0],
            "cc_cough" => [0],
            "cc_cyst" => [0],
            "cc_decreasedbloodsugar-symptomatic" => [0],
            "cc_dehydration" => [0],
            "cc_dentalpain" => [0],
            "cc_depression" => [0],
            "cc_detoxevaluation" => [0],
            "cc_diarrhea" => [0],
            "cc_dizziness" => [0],
            "cc_drug/alcoholassessment" => [0],
            "cc_drugproblem" => [0],
            "cc_dyspnea" => [0],
            "cc_dysuria" => [0],
            "cc_earpain" => [0],
            "cc_earproblem" => [0],
            "cc_edema" => [0],
            "cc_elbowpain" => [0],
            "cc_elevatedbloodsugar-nosymptoms" => [0],
            "cc_elevatedbloodsugar-symptomatic" => [0],
            "cc_emesis" => [0],
            "cc_epigastricpain" => [0],
            "cc_epistaxis" => [0],
            "cc_exposuretostd" => [0],
            "cc_extremitylaceration" => [0],
            "cc_extremityweakness" => [0],
            "cc_eyeinjury" => [0],
            "cc_eyepain" => [0],
            "cc_eyeproblem" => [0],
            "cc_eyeredness" => [0],
            "cc_facialinjury" => [0],
            "cc_faciallaceration" => [0],
            "cc_facialpain" => [0],
            "cc_facialswelling" => [0],
            "cc_fall" => [0],
            "cc_fall>65" => [0],
            "cc_fatigue" => [0],
            "cc_femaleguproblem" => [0],
            "cc_fever" => [0],
            "cc_fever-75yearsorolder" => [0],
            "cc_fever-9weeksto74years" => [0],
            "cc_feverimmunocompromised" => [0],
            "cc_fingerinjury" => [0],
            "cc_fingerpain" => [0],
            "cc_fingerswelling" => [0],
            "cc_flankpain" => [0],
            "cc_follow-upcellulitis" => [0],
            "cc_footinjury" => [0],
            "cc_footpain" => [0],
            "cc_footswelling" => [0],
            "cc_foreignbodyineye" => [0],
            "cc_fulltrauma" => [0],
            "cc_generalizedbodyaches" => [0],
            "cc_gibleeding" => [0],
            "cc_giproblem" => [0],
            "cc_groinpain" => [0],
            "cc_hallucinations" => [0],
            "cc_handinjury" => [0],
            "cc_handpain" => [0],
            "cc_headache" => [0],
            "cc_headache-newonsetornewsymptoms" => [0],
            "cc_headache-recurrentorknowndxmigraines" => [0],
            "cc_headachere-evaluation" => [0],
            "cc_headinjury" => [0],
            "cc_headlaceration" => [0],
            "cc_hematuria" => [0],
            "cc_hemoptysis" => [0],
            "cc_hippain" => [0],
            "cc_homicidal" => [0],
            "cc_hyperglycemia" => [0],
            "cc_hypertension" => [0],
            "cc_hypotension" => [0],
            "cc_influenza" => [0],
            "cc_ingestion" => [0],
            "cc_insectbite" => [0],
            "cc_irregularheartbeat" => [0],
            "cc_jawpain" => [0],
            "cc_jointswelling" => [0],
            "cc_kneeinjury" => [0],
            "cc_kneepain" => [0],
            "cc_laceration" => [0],
            "cc_leginjury" => [0],
            "cc_legpain" => [0],
            "cc_legswelling" => [0],
            "cc_lethargy" => [0],
            "cc_lossofconsciousness" => [0],
            "cc_maleguproblem" => [0],
            "cc_mass" => [0],
            "cc_medicalproblem" => [0],
            "cc_medicalscreening" => [0],
            "cc_medicationproblem" => [0],
            "cc_medicationrefill" => [0],
            "cc_migraine" => [0],
            "cc_modifiedtrauma" => [0],
            "cc_motorcyclecrash" => [0],
            "cc_motorvehiclecrash" => [0],
            "cc_multiplefalls" => [0],
            "cc_nasalcongestion" => [0],
            "cc_nausea" => [0],
            "cc_nearsyncope" => [0],
            "cc_neckpain" => [0],
            "cc_neurologicproblem" => [0],
            "cc_numbness" => [0],
            "cc_oralswelling" => [0],
            "cc_otalgia" => [0],
            "cc_other" => [0],
            "cc_overdose-accidental" => [0],
            "cc_overdose-intentional" => [0],
            "cc_pain" => [0],
            "cc_palpitations" => [0],
            "cc_panicattack" => [0],
            "cc_pelvicpain" => [0],
            "cc_poisoning" => [0],
            "cc_post-opproblem" => [0],
            "cc_psychiatricevaluation" => [0],
            "cc_psychoticsymptoms" => [0],
            "cc_rapidheartrate" => [0],
            "cc_rash" => [0],
            "cc_rectalbleeding" => [0],
            "cc_rectalpain" => [0],
            "cc_respiratorydistress" => [0],
            "cc_ribinjury" => [0],
            "cc_ribpain" => [0],
            "cc_seizure-newonset" => [0],
            "cc_seizure-priorhxof" => [0],
            "cc_seizures" => [0],
            "cc_shortnessofbreath" => [0],
            "cc_shoulderinjury" => [0],
            "cc_shoulderpain" => [0],
            "cc_sicklecellpain" => [0],
            "cc_sinusproblem" => [0],
            "cc_skinirritation" => [0],
            "cc_skinproblem" => [0],
            "cc_sorethroat" => [0],
            "cc_stdcheck" => [0],
            "cc_strokealert" => [0],
            "cc_suicidal" => [0],
            "cc_suture/stapleremoval" => [0],
            "cc_swallowedforeignbody" => [0],
            "cc_syncope" => [0],
            "cc_tachycardia" => [0],
            "cc_testiclepain" => [0],
            "cc_thumbinjury" => [0],
            "cc_tickremoval" => [0],
            "cc_toeinjury" => [0],
            "cc_toepain" => [0],
            "cc_trauma" => [0],
            "cc_unresponsive" => [0],
            "cc_uri" => [0],
            "cc_urinaryfrequency" => [0],
            "cc_urinaryretention" => [0],
            "cc_urinarytractinfection" => [0],
            "cc_vaginalbleeding" => [0],
            "cc_vaginaldischarge" => [0],
            "cc_vaginalpain" => [0],
            "cc_weakness" => [0],
            "cc_wheezing" => [0],
            "cc_withdrawal-alcohol" => [0],
            "cc_woundcheck" => [0],
            "cc_woundinfection" => [0],
            "cc_woundre-evaluation" => [0],
            "cc_wristinjury" => [0],
            "cc_wristpain" => [0]
        ];

        foreach ($attributes['chief_complaint'] as $cc) {
            $data[$cc] = [1];
        }

        $client = new Client();

        try {
            $response = $client->post('http://127.0.0.1:5000/predict/create', [
                'json' => $data,
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

    function celsiusToFahrenheit($celsius) {
        $fahrenheit = ($celsius * 9/5) + 32;
        return $fahrenheit;
    }
}
