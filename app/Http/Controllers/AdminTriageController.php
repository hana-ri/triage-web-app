<?php

namespace App\Http\Controllers;

use App\Models\Triage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminTriageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Triage::latest()
                ->with(['user'])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', fn($row) => $row->user->name)
                ->addColumn('action', fn($row) => view('admin.triage.action', ['row' => $row]))
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dashboard');
    }

    public function triageStepOne()
    {
        return view('admin.triage.step-one');
    }

    public function triageStepOneProcess(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'age' => 'required|numeric',
                'gender' => 'required',
            ],

            [
                'required' => ':attribute wajib diisi.',
                'numeric' => ':attribute harus berupa angka.',
            ],
            [
                'name' => 'Nama',
                'age' => 'Usia',
                'gender' => 'Jenis kelamin',
            ],
        );

        if (empty($request->session()->get('triage'))) {
            $triage = new Triage();
            $triage->fill($validatedData);
            $request->session()->put('triage', $triage);
        } else {
            $triage = $request->session()->get('triage');
            $triage->fill($validatedData);
            $request->session()->put('triage', $triage);
        }

        return redirect()->route('admin.triage.step.two');
    }

    public function triageStepOneProcessReset(Request $request)
    {
        $request->session()->forget('triage');
        return redirect()->route('admin.triage.step.one');
    }

    public function triageStepTwo()
    {
        return view('admin.triage.step-two');
    }

    public function triageStepTwoProcess(Request $request)
    {
        $validatedData = $request->validate(
            [
                'sbp' => 'required',
                'dbp' => 'required',
                'hr' => 'required',
                'rr' => 'required',
                'bt' => 'required',
                'saturation' => 'required',
                'triage_vital_o2_device' => 'required',
                'chief_complaint' => 'nullable',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'numeric' => ':attribute harus berupa angka.',
            ],
            [
                'sbp' => 'Tekanan darah sistolik',
                'dbp' => 'Tekanan darah diastolik',
                'hr' => 'Detak jantung',
                'rr' => 'Laju pernapasan',
                'bt' => 'Suhu tubuh',
                'saturation' => 'Saturasi oksigen',
                'triage_vital_o2_device' => 'Alat oksigen triase',
                'chief_complaint' => 'Keluhan utama',
            ],
        );

        $triage = $request->session()->get('triage');
        $validatedData['age'] = $triage->age;
        $validatedData['gender'] = $triage->gender == 'male' || $triage->gender == 1 ? 1 : 0;

        $triage->fill($validatedData);
        $request->session()->put('triage', $triage);

        $modelResponse = $this->predictTriage($validatedData);

        $triage['prediction_level'] = $modelResponse['result'];

        $chief_complaint = [
            'cc_abdominalcramping' => 'keram perut (abdominal cramping)',
            'cc_abdominaldistention' => 'distensi abdomen (abdominal distention)',
            'cc_abdominalpain' => 'nyeri perut (abdominal pain)',
            'cc_abdominalpainpregnant' => 'nyeri perut pada kehamilan (abdominal pain pregnant)',
            'cc_abnormallab' => 'hasil lab abnormal (abnormal lab)',
            'cc_abscess' => 'abses (abscess)',
            'cc_addictionproblem' => 'masalah kecanduan (addiction problem)',
            'cc_agitation' => 'agitasi (agitation)',
            'cc_alcoholintoxication' => 'intoksikasi alkohol (alcohol intoxication)',
            'cc_alcoholproblem' => 'masalah alkohol (alcohol problem)',
            'cc_allergicreaction' => 'reaksi alergi (allergic reaction)',
            'cc_alteredmentalstatus' => 'perubahan status mental (altered mental status)',
            'cc_animalbite' => 'gigitan hewan (animal bite)',
            'cc_ankleinjury' => 'cedera pergelangan kaki (ankle injury)',
            'cc_anklepain' => 'nyeri pergelangan kaki (ankle pain)',
            'cc_anxiety' => 'kecemasan (anxiety)',
            'cc_arminjury' => 'cedera lengan (arm injury)',
            'cc_armpain' => 'nyeri lengan (arm pain)',
            'cc_armswelling' => 'pembengkakan lengan (arm swelling)',
            'cc_assaultvictim' => 'korban penyerangan (assault victim)',
            'cc_asthma' => 'asma (asthma)',
            'cc_backpain' => 'nyeri punggung (back pain)',
            'cc_bleeding/bruising' => 'pendarahan/memar (bleeding/bruising)',
            'cc_blurredvision' => 'penglihatan kabur (blurred vision)',
            'cc_bodyfluidexposure' => 'paparan cairan tubuh (body fluid exposure)',
            'cc_breastpain' => 'nyeri payudara (breast pain)',
            'cc_breathingdifficulty' => 'kesulitan bernapas (breathing difficulty)',
            'cc_breathingproblem' => 'masalah pernapasan (breathing problem)',
            'cc_burn' => 'luka bakar (burn)',
            'cc_cardiacarrest' => 'henti jantung (cardiac arrest)',
            'cc_cellulitis' => 'selulitis (cellulitis)',
            'cc_chestpain' => 'nyeri dada (chest pain)',
            'cc_chesttightness' => 'sesak dada (chest tightness)',
            'cc_chills' => 'menggigil (chills)',
            'cc_coldlikesymptoms' => 'gejala seperti flu (cold like symptoms)',
            'cc_confusion' => 'kebingungan (confusion)',
            'cc_conjunctivitis' => 'konjungtivitis (conjunctivitis)',
            'cc_constipation' => 'konstipasi (constipation)',
            'cc_cough' => 'batuk (cough)',
            'cc_cyst' => 'kista (cyst)',
            'cc_decreasedbloodsugar-symptomatic' => 'penurunan gula darah dengan gejala (decreased blood sugar-symptomatic)',
            'cc_dehydration' => 'dehidrasi (dehydration)',
            'cc_dentalpain' => 'nyeri gigi (dental pain)',
            'cc_depression' => 'depresi (depression)',
            'cc_detoxevaluation' => 'evaluasi detoksifikasi (detox evaluation)',
            'cc_diarrhea' => 'diare (diarrhea)',
            'cc_dizziness' => 'pusing (dizziness)',
            'cc_drug/alcoholassessment' => 'penilaian obat/alkohol (drug / alcohol assessment)',
            'cc_drugproblem' => 'masalah obat (drug problem)',
            'cc_dyspnea' => 'dispnea (dyspnea)',
            'cc_dysuria' => 'disuria (dysuria)',
            'cc_earpain' => 'nyeri telinga (ear pain)',
            'cc_earproblem' => 'masalah telinga (ear problem)',
            'cc_edema' => 'edema (edema)',
            'cc_elbowpain' => 'nyeri siku (elbow pain)',
            'cc_elevatedbloodsugar-nosymptoms' => 'gula darah tinggi tanpa gejala (elevated blood sugar-no symptoms)',
            'cc_elevatedbloodsugar-symptomatic' => 'gula darah tinggi dengan gejala (elevated blood sugar-symptomatic)',
            'cc_emesis' => 'muntah (emesis)',
            'cc_epigastricpain' => 'nyeri epigastrium (epigastric pain)',
            'cc_epistaxis' => 'epistaksis (epistaxis)',
            'cc_exposuretostd' => 'paparan penyakit menular seksual (exposure to std)',
            'cc_extremitylaceration' => 'laserasi ekstremitas (extremity laceration)',
            'cc_extremityweakness' => 'kelemahan ekstremitas (extremity weakness)',
            'cc_eyeinjury' => 'cedera mata (eye injury)',
            'cc_eyepain' => 'nyeri mata (eye pain)',
            'cc_eyeproblem' => 'masalah mata (eye problem)',
            'cc_eyeredness' => 'mata merah (eye redness)',
            'cc_facialinjury' => 'cedera wajah (facial injury)',
            'cc_faciallaceration' => 'laserasi wajah (facial laceration)',
            'cc_facialpain' => 'nyeri wajah (facial pain)',
            'cc_facialswelling' => 'pembengkakan wajah (facial swelling)',
            'cc_fall' => 'jatuh (fall)',
            'cc_fall>65' => 'jatuh >65 tahun (fall >65)',
            'cc_fatigue' => 'kelelahan (fatigue)',
            'cc_femaleguproblem' => 'masalah ginekologi perempuan (female gu problem)',
            'cc_fever' => 'demam (fever)',
            'cc_fever-75yearsorolder' => 'demam pada usia 75 tahun atau lebih (fever-75 years or older)',
            'cc_fever-9weeksto74years' => 'demam pada usia 9 minggu hingga 74 tahun (fever-9 weeks to 74 years)',
            'cc_feverimmunocompromised' => 'demam pada imunosupresi (fever immunocompromised)',
            'cc_fingerinjury' => 'cedera jari (finger injury)',
            'cc_fingerpain' => 'nyeri jari (finger pain)',
            'cc_fingerswelling' => 'pembengkakan jari (finger swelling)',
            'cc_flankpain' => 'nyeri pinggang (flank pain)',
            'cc_follow-upcellulitis' => 'tindak lanjut selulitis (follow-up cellulitis)',
            'cc_footinjury' => 'cedera kaki (foot injury)',
            'cc_footpain' => 'nyeri kaki (foot pain)',
            'cc_footswelling' => 'pembengkakan kaki (foot swelling)',
            'cc_foreignbodyineye' => 'benda asing di mata (foreign body in eye)',
            'cc_fulltrauma' => 'trauma penuh (full trauma)',
            'cc_generalizedbodyaches' => 'nyeri tubuh umum (generalized body aches)',
            'cc_gibleeding' => 'perdarahan saluran cerna (gi bleeding)',
            'cc_giproblem' => 'masalah saluran cerna (gi problem)',
            'cc_groinpain' => 'nyeri selangkangan (groin pain)',
            'cc_hallucinations' => 'halusinasi (hallucinations)',
            'cc_handinjury' => 'cedera tangan (hand injury)',
            'cc_handpain' => 'nyeri tangan (hand pain)',
            'cc_headache' => 'sakit kepala (headache)',
            'cc_headache-newonsetornewsymptoms' => 'sakit kepala - onset baru atau gejala baru (headache- new onset or new symptoms)',
            'cc_headache-recurrentorknowndxmigraines' => 'sakit kepala - kambuhan atau diagnosis migrain diketahui (headache- recurrent or known dx migraines)',
            'cc_headachere-evaluation' => 'evaluasi ulang sakit kepala (headache re-evaluation)',
            'cc_headinjury' => 'cedera kepala (head injury)',
            'cc_headlaceration' => 'laserasi kepala (head laceration)',
            'cc_hematuria' => 'hematuria (hematuria)',
            'cc_hemoptysis' => 'hemoptisis (hemoptysis)',
            'cc_hippain' => 'nyeri panggul (hip pain)',
            'cc_homicidal' => 'berniat membunuh (homicidal)',
            'cc_hyperglycemia' => 'hiperglikemia (hyperglycemia)',
            'cc_hypertension' => 'hipertensi (hypertension)',
            'cc_hypotension' => 'hipotensi (hypotension)',
            'cc_influenza' => 'influenza (influenza)',
            'cc_ingestion' => 'ingesti (ingestion)',
            'cc_insectbite' => 'gigitan serangga (insect bite)',
            'cc_irregularheartbeat' => 'detak jantung tidak teratur (irregular heart beat)',
            'cc_jawpain' => 'nyeri rahang (jaw pain)',
            'cc_jointswelling' => 'pembengkakan sendi (joint swelling)',
            'cc_kneeinjury' => 'cedera lutut (knee injury)',
            'cc_kneepain' => 'nyeri lutut (knee pain)',
            'cc_laceration' => 'laserasi (laceration)',
            'cc_leginjury' => 'cedera kaki (leg injury)',
            'cc_legpain' => 'nyeri kaki (leg pain)',
            'cc_legswelling' => 'pembengkakan kaki (leg swelling)',
            'cc_lethargy' => 'letargi (lethargy)',
            'cc_lossofconsciousness' => 'kehilangan kesadaran (loss of consciousness)',
            'cc_maleguproblem' => 'masalah urologi pria (male gu problem)',
            'cc_mass' => 'massa (mass)',
            'cc_medicalproblem' => 'masalah medis (medical problem)',
            'cc_medicalscreening' => 'penyaringan medis (medical screening)',
            'cc_medicationproblem' => 'masalah obat (medication problem)',
            'cc_medicationrefill' => 'isi ulang obat (medication refill)',
            'cc_migraine' => 'migrain (migraine)',
            'cc_modifiedtrauma' => 'trauma modifikasi (modified trauma)',
            'cc_motorcyclecrash' => 'kecelakaan sepeda motor (motor vehicle crash)',
            'cc_motorvehiclecrash' => 'kecelakaan kendaraan bermotor (motorcycle crash)',
            'cc_multiplefalls' => 'jatuh berulang (multiple falls)',
            'cc_nasalcongestion' => 'hidung tersumbat (nasal congestion)',
            'cc_nausea' => 'mual (nausea)',
            'cc_nearsyncope' => 'hampir pingsan (near syncope)',
            'cc_neckpain' => 'nyeri leher (neck pain)',
            'cc_neurologicproblem' => 'masalah neurologis (neurologic problem)',
            'cc_numbness' => 'kebas (numbness)',
            'cc_oralswelling' => 'pembengkakan mulut (oral swelling)',
            'cc_otalgia' => 'otalgia (otalgia)',
            'cc_other' => 'lainnya (other)',
            'cc_overdose-accidental' => 'overdosis tidak sengaja (overdose- accidental)',
            'cc_overdose-intentional' => 'overdosis disengaja (overdose- intentional)',
            'cc_pain' => 'nyeri (pain)',
            'cc_palpitations' => 'palpitasi (palpitations)',
            'cc_panicattack' => 'serangan panik (panic attack)',
            'cc_pelvicpain' => 'nyeri panggul (pelvic pain)',
            'cc_poisoning' => 'keracunan (poisoning)',
            'cc_post-opproblem' => 'masalah pasca operasi (post-op problem)',
            'cc_psychiatricevaluation' => 'evaluasi psikiatrik (psychiatric evaluation)',
            'cc_psychoticsymptoms' => 'gejala psikotik (psychotic symptoms)',
            'cc_rapidheartrate' => 'detak jantung cepat (rapid heart rate)',
            'cc_rash' => 'ruam (rash)',
            'cc_rectalbleeding' => 'perdarahan rektal (rectal bleeding)',
            'cc_rectalpain' => 'nyeri rektal (rectal pain)',
            'cc_respiratorydistress' => 'distres pernapasan (respiratory distress)',
            'cc_ribinjury' => 'cedera tulang rusuk (rib injury)',
            'cc_ribpain' => 'nyeri tulang rusuk (rib pain)',
            'cc_seizure-newonset' => 'kejang - onset baru (seizure- new onset)',
            'cc_seizure-priorhxof' => 'kejang - riwayat sebelumnya (seizure- prior hx of)',
            'cc_seizures' => 'kejang (seizures)',
            'cc_shortnessofbreath' => 'sesak napas (shortness of breath)',
            'cc_shoulderinjury' => 'cedera bahu (shoulder injury)',
            'cc_shoulderpain' => 'nyeri bahu (shoulder pain)',
            'cc_sicklecellpain' => 'nyeri sel sabit (sickle cell pain)',
            'cc_sinusproblem' => 'masalah sinus (sinus problem)',
            'cc_skinirritation' => 'iritasi kulit (skin irritation)',
            'cc_skinproblem' => 'masalah kulit (skin problem)',
            'cc_sorethroat' => 'sakit tenggorokan (sore throat)',
            'cc_stdcheck' => 'pemeriksaan penyakit menular seksual (std check)',
            'cc_strokealert' => 'waspada stroke (stroke alert)',
            'cc_suicidal' => 'berniat bunuh diri (suicidal)',
            'cc_suture/stapleremoval' => 'pengangkatan jahitan/staples (suture / staple removal)',
            'cc_swallowedforeignbody' => 'menelan benda asing (swallowed foreign body)',
            'cc_syncope' => 'sinkop (syncope)',
            'cc_tachycardia' => 'takikardia (tachycardia)',
            'cc_testiclepain' => 'nyeri testis (testicle pain)',
            'cc_thumbinjury' => 'cedera ibu jari (thumb injury)',
            'cc_tickremoval' => 'pengangkatan kutu (tick removal)',
            'cc_toeinjury' => 'cedera jari kaki (toe injury)',
            'cc_toepain' => 'nyeri jari kaki (toe pain)',
            'cc_trauma' => 'trauma (trauma)',
            'cc_unresponsive' => 'tidak responsif (unresponsive)',
            'cc_uri' => 'infeksi saluran pernapasan atas (uri)',
            'cc_urinaryfrequency' => 'frekuensi buang air kecil meningkat (urinary frequency)',
            'cc_urinaryretention' => 'retensi urin (urinary retention)',
            'cc_urinarytractinfection' => 'infeksi saluran kemih (urinary tract infection)',
            'cc_vaginalbleeding' => 'perdarahan vagina (vaginal bleeding)',
            'cc_vaginaldischarge' => 'keputihan (vaginal discharge)',
            'cc_vaginalpain' => 'nyeri vagina (vaginal pain)',
            'cc_weakness' => 'kelemahan (weakness)',
            'cc_wheezing' => 'mengi (wheezing)',
            'cc_withdrawal-alcohol' => 'penarikan alkohol (withdrawal- alcohol)',
            'cc_woundcheck' => 'pemeriksaan luka (wound check)',
            'cc_woundinfection' => 'infeksi luka (wound infection)',
            'cc_woundre-evaluation' => 'evaluasi ulang luka (wound re-evaluation)',
            'cc_wristinjury' => 'cedera pergelangan tangan (wrist injury)',
            'cc_wristpain' => 'nyeri pergelangan tangan (wrist pain)',
        ];

        $temp_cc = 'Tidak tersedia';
        if (isset($attributes['chief_complaint'])) {
            foreach ($triage->chief_complaint as $key => $value) {
                $temp_cc = $temp_cc .= $chief_complaint[$value];

                $isLastIteration = $key === array_key_last($triage->chief_complaint);
                if (!$isLastIteration) {
                    $temp_cc = $temp_cc .= ', ';
                }
            }
        }

        $triage->chief_complaint = $temp_cc;

        return redirect()->route('admin.triage.validation');
    }

    public function triageValidation()
    {
        return view('admin.triage.step-validation');
    }

    public function triageValidationProcess(Request $request)
    {
        $validatedData = $request->validate(
            [
                'validation' => 'in:1,2,3,4,5',
                'note' => 'nullable',
            ],
            [
                'validation.in' => 'Validasi prediksi model artificial yang dipilih tidak valid, silakan validasi level.',
            ],
        );

        $triage = $request->session()->get('triage');

        $triage->fill($validatedData);
        $triage->gender = $triage->gender == 1 ? 'male' : 'female';
        $triage->user_id = auth()->id();

        $triage->save();
        $request->session()->forget('triage');

        return redirect()->route('admin.dashboard');
    }

    public function predictTriage($data)
    {
        $attributes = $data;

        // Susun data sesuai dengan format yang diinginkan
        $data = [
            'age' => [(int) $attributes['age']],
            'triage_vital_hr' => [(int) $attributes['hr']],
            'triage_vital_sbp' => [(int) $attributes['sbp']],
            'triage_vital_dbp' => [(int) $attributes['dbp']],
            'triage_vital_rr' => [(int) $attributes['rr']],
            'triage_vital_o2' => [(int) $attributes['saturation']],
            'triage_vital_temp' => [(int) $this->celsiusToFahrenheit($attributes['bt'])],
            'gender' => [(int) $attributes['gender']],
            'triage_vital_o2_device' => [(int) $attributes['triage_vital_o2_device']],
            'cc_abdominalcramping' => [0],
            'cc_abdominaldistention' => [0],
            'cc_abdominalpain' => [0],
            'cc_abdominalpainpregnant' => [0],
            'cc_abnormallab' => [0],
            'cc_abscess' => [0],
            'cc_addictionproblem' => [0],
            'cc_agitation' => [0],
            'cc_alcoholintoxication' => [0],
            'cc_alcoholproblem' => [0],
            'cc_allergicreaction' => [0],
            'cc_alteredmentalstatus' => [0],
            'cc_animalbite' => [0],
            'cc_ankleinjury' => [0],
            'cc_anklepain' => [0],
            'cc_anxiety' => [0],
            'cc_arminjury' => [0],
            'cc_armpain' => [0],
            'cc_armswelling' => [0],
            'cc_assaultvictim' => [0],
            'cc_asthma' => [0],
            'cc_backpain' => [0],
            'cc_bleeding/bruising' => [0],
            'cc_blurredvision' => [0],
            'cc_bodyfluidexposure' => [0],
            'cc_breastpain' => [0],
            'cc_breathingdifficulty' => [0],
            'cc_breathingproblem' => [0],
            'cc_burn' => [0],
            'cc_cardiacarrest' => [0],
            'cc_cellulitis' => [0],
            'cc_chestpain' => [0],
            'cc_chesttightness' => [0],
            'cc_chills' => [0],
            'cc_coldlikesymptoms' => [0],
            'cc_confusion' => [0],
            'cc_conjunctivitis' => [0],
            'cc_constipation' => [0],
            'cc_cough' => [0],
            'cc_cyst' => [0],
            'cc_decreasedbloodsugar-symptomatic' => [0],
            'cc_dehydration' => [0],
            'cc_dentalpain' => [0],
            'cc_depression' => [0],
            'cc_detoxevaluation' => [0],
            'cc_diarrhea' => [0],
            'cc_dizziness' => [0],
            'cc_drug/alcoholassessment' => [0],
            'cc_drugproblem' => [0],
            'cc_dyspnea' => [0],
            'cc_dysuria' => [0],
            'cc_earpain' => [0],
            'cc_earproblem' => [0],
            'cc_edema' => [0],
            'cc_elbowpain' => [0],
            'cc_elevatedbloodsugar-nosymptoms' => [0],
            'cc_elevatedbloodsugar-symptomatic' => [0],
            'cc_emesis' => [0],
            'cc_epigastricpain' => [0],
            'cc_epistaxis' => [0],
            'cc_exposuretostd' => [0],
            'cc_extremitylaceration' => [0],
            'cc_extremityweakness' => [0],
            'cc_eyeinjury' => [0],
            'cc_eyepain' => [0],
            'cc_eyeproblem' => [0],
            'cc_eyeredness' => [0],
            'cc_facialinjury' => [0],
            'cc_faciallaceration' => [0],
            'cc_facialpain' => [0],
            'cc_facialswelling' => [0],
            'cc_fall' => [0],
            'cc_fall>65' => [0],
            'cc_fatigue' => [0],
            'cc_femaleguproblem' => [0],
            'cc_fever' => [0],
            'cc_fever-75yearsorolder' => [0],
            'cc_fever-9weeksto74years' => [0],
            'cc_feverimmunocompromised' => [0],
            'cc_fingerinjury' => [0],
            'cc_fingerpain' => [0],
            'cc_fingerswelling' => [0],
            'cc_flankpain' => [0],
            'cc_follow-upcellulitis' => [0],
            'cc_footinjury' => [0],
            'cc_footpain' => [0],
            'cc_footswelling' => [0],
            'cc_foreignbodyineye' => [0],
            'cc_fulltrauma' => [0],
            'cc_generalizedbodyaches' => [0],
            'cc_gibleeding' => [0],
            'cc_giproblem' => [0],
            'cc_groinpain' => [0],
            'cc_hallucinations' => [0],
            'cc_handinjury' => [0],
            'cc_handpain' => [0],
            'cc_headache' => [0],
            'cc_headache-newonsetornewsymptoms' => [0],
            'cc_headache-recurrentorknowndxmigraines' => [0],
            'cc_headachere-evaluation' => [0],
            'cc_headinjury' => [0],
            'cc_headlaceration' => [0],
            'cc_hematuria' => [0],
            'cc_hemoptysis' => [0],
            'cc_hippain' => [0],
            'cc_homicidal' => [0],
            'cc_hyperglycemia' => [0],
            'cc_hypertension' => [0],
            'cc_hypotension' => [0],
            'cc_influenza' => [0],
            'cc_ingestion' => [0],
            'cc_insectbite' => [0],
            'cc_irregularheartbeat' => [0],
            'cc_jawpain' => [0],
            'cc_jointswelling' => [0],
            'cc_kneeinjury' => [0],
            'cc_kneepain' => [0],
            'cc_laceration' => [0],
            'cc_leginjury' => [0],
            'cc_legpain' => [0],
            'cc_legswelling' => [0],
            'cc_lethargy' => [0],
            'cc_lossofconsciousness' => [0],
            'cc_maleguproblem' => [0],
            'cc_mass' => [0],
            'cc_medicalproblem' => [0],
            'cc_medicalscreening' => [0],
            'cc_medicationproblem' => [0],
            'cc_medicationrefill' => [0],
            'cc_migraine' => [0],
            'cc_modifiedtrauma' => [0],
            'cc_motorcyclecrash' => [0],
            'cc_motorvehiclecrash' => [0],
            'cc_multiplefalls' => [0],
            'cc_nasalcongestion' => [0],
            'cc_nausea' => [0],
            'cc_nearsyncope' => [0],
            'cc_neckpain' => [0],
            'cc_neurologicproblem' => [0],
            'cc_numbness' => [0],
            'cc_oralswelling' => [0],
            'cc_otalgia' => [0],
            'cc_other' => [0],
            'cc_overdose-accidental' => [0],
            'cc_overdose-intentional' => [0],
            'cc_pain' => [0],
            'cc_palpitations' => [0],
            'cc_panicattack' => [0],
            'cc_pelvicpain' => [0],
            'cc_poisoning' => [0],
            'cc_post-opproblem' => [0],
            'cc_psychiatricevaluation' => [0],
            'cc_psychoticsymptoms' => [0],
            'cc_rapidheartrate' => [0],
            'cc_rash' => [0],
            'cc_rectalbleeding' => [0],
            'cc_rectalpain' => [0],
            'cc_respiratorydistress' => [0],
            'cc_ribinjury' => [0],
            'cc_ribpain' => [0],
            'cc_seizure-newonset' => [0],
            'cc_seizure-priorhxof' => [0],
            'cc_seizures' => [0],
            'cc_shortnessofbreath' => [0],
            'cc_shoulderinjury' => [0],
            'cc_shoulderpain' => [0],
            'cc_sicklecellpain' => [0],
            'cc_sinusproblem' => [0],
            'cc_skinirritation' => [0],
            'cc_skinproblem' => [0],
            'cc_sorethroat' => [0],
            'cc_stdcheck' => [0],
            'cc_strokealert' => [0],
            'cc_suicidal' => [0],
            'cc_suture/stapleremoval' => [0],
            'cc_swallowedforeignbody' => [0],
            'cc_syncope' => [0],
            'cc_tachycardia' => [0],
            'cc_testiclepain' => [0],
            'cc_thumbinjury' => [0],
            'cc_tickremoval' => [0],
            'cc_toeinjury' => [0],
            'cc_toepain' => [0],
            'cc_trauma' => [0],
            'cc_unresponsive' => [0],
            'cc_uri' => [0],
            'cc_urinaryfrequency' => [0],
            'cc_urinaryretention' => [0],
            'cc_urinarytractinfection' => [0],
            'cc_vaginalbleeding' => [0],
            'cc_vaginaldischarge' => [0],
            'cc_vaginalpain' => [0],
            'cc_weakness' => [0],
            'cc_wheezing' => [0],
            'cc_withdrawal-alcohol' => [0],
            'cc_woundcheck' => [0],
            'cc_woundinfection' => [0],
            'cc_woundre-evaluation' => [0],
            'cc_wristinjury' => [0],
            'cc_wristpain' => [0],
        ];

        if (isset($attributes['chief_complaint'])) {
            foreach ($attributes['chief_complaint'] as $cc) {
                $data[$cc] = [1];
            }
        }

        $client = new Client();

        try {
            $url = env('API_TRIASE', 'http://127.0.0.1:5000');
            $url = $url . '/predict';

            $response = $client->post($url, [
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

    public function celsiusToFahrenheit($celsius)
    {
        $fahrenheit = ($celsius * 9) / 5 + 32;
        return $fahrenheit;
    }

    public function chiefComplaintFromArrayToString($triage)
    {
        $chief_complaint = [
            'cc_abdominalcramping' => 'keram perut (abdominal cramping)',
            'cc_abdominaldistention' => 'distensi abdomen (abdominal distention)',
            'cc_abdominalpain' => 'nyeri perut (abdominal pain)',
            'cc_abdominalpainpregnant' => 'nyeri perut pada kehamilan (abdominal pain pregnant)',
            'cc_abnormallab' => 'hasil lab abnormal (abnormal lab)',
            'cc_abscess' => 'abses (abscess)',
            'cc_addictionproblem' => 'masalah kecanduan (addiction problem)',
            'cc_agitation' => 'agitasi (agitation)',
            'cc_alcoholintoxication' => 'intoksikasi alkohol (alcohol intoxication)',
            'cc_alcoholproblem' => 'masalah alkohol (alcohol problem)',
            'cc_allergicreaction' => 'reaksi alergi (allergic reaction)',
            'cc_alteredmentalstatus' => 'perubahan status mental (altered mental status)',
            'cc_animalbite' => 'gigitan hewan (animal bite)',
            'cc_ankleinjury' => 'cedera pergelangan kaki (ankle injury)',
            'cc_anklepain' => 'nyeri pergelangan kaki (ankle pain)',
            'cc_anxiety' => 'kecemasan (anxiety)',
            'cc_arminjury' => 'cedera lengan (arm injury)',
            'cc_armpain' => 'nyeri lengan (arm pain)',
            'cc_armswelling' => 'pembengkakan lengan (arm swelling)',
            'cc_assaultvictim' => 'korban penyerangan (assault victim)',
            'cc_asthma' => 'asma (asthma)',
            'cc_backpain' => 'nyeri punggung (back pain)',
            'cc_bleeding/bruising' => 'pendarahan/memar (bleeding/bruising)',
            'cc_blurredvision' => 'penglihatan kabur (blurred vision)',
            'cc_bodyfluidexposure' => 'paparan cairan tubuh (body fluid exposure)',
            'cc_breastpain' => 'nyeri payudara (breast pain)',
            'cc_breathingdifficulty' => 'kesulitan bernapas (breathing difficulty)',
            'cc_breathingproblem' => 'masalah pernapasan (breathing problem)',
            'cc_burn' => 'luka bakar (burn)',
            'cc_cardiacarrest' => 'henti jantung (cardiac arrest)',
            'cc_cellulitis' => 'selulitis (cellulitis)',
            'cc_chestpain' => 'nyeri dada (chest pain)',
            'cc_chesttightness' => 'sesak dada (chest tightness)',
            'cc_chills' => 'menggigil (chills)',
            'cc_coldlikesymptoms' => 'gejala seperti flu (cold like symptoms)',
            'cc_confusion' => 'kebingungan (confusion)',
            'cc_conjunctivitis' => 'konjungtivitis (conjunctivitis)',
            'cc_constipation' => 'konstipasi (constipation)',
            'cc_cough' => 'batuk (cough)',
            'cc_cyst' => 'kista (cyst)',
            'cc_decreasedbloodsugar-symptomatic' => 'penurunan gula darah dengan gejala (decreased blood sugar-symptomatic)',
            'cc_dehydration' => 'dehidrasi (dehydration)',
            'cc_dentalpain' => 'nyeri gigi (dental pain)',
            'cc_depression' => 'depresi (depression)',
            'cc_detoxevaluation' => 'evaluasi detoksifikasi (detox evaluation)',
            'cc_diarrhea' => 'diare (diarrhea)',
            'cc_dizziness' => 'pusing (dizziness)',
            'cc_drug/alcoholassessment' => 'penilaian obat/alkohol (drug / alcohol assessment)',
            'cc_drugproblem' => 'masalah obat (drug problem)',
            'cc_dyspnea' => 'dispnea (dyspnea)',
            'cc_dysuria' => 'disuria (dysuria)',
            'cc_earpain' => 'nyeri telinga (ear pain)',
            'cc_earproblem' => 'masalah telinga (ear problem)',
            'cc_edema' => 'edema (edema)',
            'cc_elbowpain' => 'nyeri siku (elbow pain)',
            'cc_elevatedbloodsugar-nosymptoms' => 'gula darah tinggi tanpa gejala (elevated blood sugar-no symptoms)',
            'cc_elevatedbloodsugar-symptomatic' => 'gula darah tinggi dengan gejala (elevated blood sugar-symptomatic)',
            'cc_emesis' => 'muntah (emesis)',
            'cc_epigastricpain' => 'nyeri epigastrium (epigastric pain)',
            'cc_epistaxis' => 'epistaksis (epistaxis)',
            'cc_exposuretostd' => 'paparan penyakit menular seksual (exposure to std)',
            'cc_extremitylaceration' => 'laserasi ekstremitas (extremity laceration)',
            'cc_extremityweakness' => 'kelemahan ekstremitas (extremity weakness)',
            'cc_eyeinjury' => 'cedera mata (eye injury)',
            'cc_eyepain' => 'nyeri mata (eye pain)',
            'cc_eyeproblem' => 'masalah mata (eye problem)',
            'cc_eyeredness' => 'mata merah (eye redness)',
            'cc_facialinjury' => 'cedera wajah (facial injury)',
            'cc_faciallaceration' => 'laserasi wajah (facial laceration)',
            'cc_facialpain' => 'nyeri wajah (facial pain)',
            'cc_facialswelling' => 'pembengkakan wajah (facial swelling)',
            'cc_fall' => 'jatuh (fall)',
            'cc_fall>65' => 'jatuh >65 tahun (fall >65)',
            'cc_fatigue' => 'kelelahan (fatigue)',
            'cc_femaleguproblem' => 'masalah ginekologi perempuan (female gu problem)',
            'cc_fever' => 'demam (fever)',
            'cc_fever-75yearsorolder' => 'demam pada usia 75 tahun atau lebih (fever-75 years or older)',
            'cc_fever-9weeksto74years' => 'demam pada usia 9 minggu hingga 74 tahun (fever-9 weeks to 74 years)',
            'cc_feverimmunocompromised' => 'demam pada imunosupresi (fever immunocompromised)',
            'cc_fingerinjury' => 'cedera jari (finger injury)',
            'cc_fingerpain' => 'nyeri jari (finger pain)',
            'cc_fingerswelling' => 'pembengkakan jari (finger swelling)',
            'cc_flankpain' => 'nyeri pinggang (flank pain)',
            'cc_follow-upcellulitis' => 'tindak lanjut selulitis (follow-up cellulitis)',
            'cc_footinjury' => 'cedera kaki (foot injury)',
            'cc_footpain' => 'nyeri kaki (foot pain)',
            'cc_footswelling' => 'pembengkakan kaki (foot swelling)',
            'cc_foreignbodyineye' => 'benda asing di mata (foreign body in eye)',
            'cc_fulltrauma' => 'trauma penuh (full trauma)',
            'cc_generalizedbodyaches' => 'nyeri tubuh umum (generalized body aches)',
            'cc_gibleeding' => 'perdarahan saluran cerna (gi bleeding)',
            'cc_giproblem' => 'masalah saluran cerna (gi problem)',
            'cc_groinpain' => 'nyeri selangkangan (groin pain)',
            'cc_hallucinations' => 'halusinasi (hallucinations)',
            'cc_handinjury' => 'cedera tangan (hand injury)',
            'cc_handpain' => 'nyeri tangan (hand pain)',
            'cc_headache' => 'sakit kepala (headache)',
            'cc_headache-newonsetornewsymptoms' => 'sakit kepala - onset baru atau gejala baru (headache- new onset or new symptoms)',
            'cc_headache-recurrentorknowndxmigraines' => 'sakit kepala - kambuhan atau diagnosis migrain diketahui (headache- recurrent or known dx migraines)',
            'cc_headachere-evaluation' => 'evaluasi ulang sakit kepala (headache re-evaluation)',
            'cc_headinjury' => 'cedera kepala (head injury)',
            'cc_headlaceration' => 'laserasi kepala (head laceration)',
            'cc_hematuria' => 'hematuria (hematuria)',
            'cc_hemoptysis' => 'hemoptisis (hemoptysis)',
            'cc_hippain' => 'nyeri panggul (hip pain)',
            'cc_homicidal' => 'berniat membunuh (homicidal)',
            'cc_hyperglycemia' => 'hiperglikemia (hyperglycemia)',
            'cc_hypertension' => 'hipertensi (hypertension)',
            'cc_hypotension' => 'hipotensi (hypotension)',
            'cc_influenza' => 'influenza (influenza)',
            'cc_ingestion' => 'ingesti (ingestion)',
            'cc_insectbite' => 'gigitan serangga (insect bite)',
            'cc_irregularheartbeat' => 'detak jantung tidak teratur (irregular heart beat)',
            'cc_jawpain' => 'nyeri rahang (jaw pain)',
            'cc_jointswelling' => 'pembengkakan sendi (joint swelling)',
            'cc_kneeinjury' => 'cedera lutut (knee injury)',
            'cc_kneepain' => 'nyeri lutut (knee pain)',
            'cc_laceration' => 'laserasi (laceration)',
            'cc_leginjury' => 'cedera kaki (leg injury)',
            'cc_legpain' => 'nyeri kaki (leg pain)',
            'cc_legswelling' => 'pembengkakan kaki (leg swelling)',
            'cc_lethargy' => 'letargi (lethargy)',
            'cc_lossofconsciousness' => 'kehilangan kesadaran (loss of consciousness)',
            'cc_maleguproblem' => 'masalah urologi pria (male gu problem)',
            'cc_mass' => 'massa (mass)',
            'cc_medicalproblem' => 'masalah medis (medical problem)',
            'cc_medicalscreening' => 'penyaringan medis (medical screening)',
            'cc_medicationproblem' => 'masalah obat (medication problem)',
            'cc_medicationrefill' => 'isi ulang obat (medication refill)',
            'cc_migraine' => 'migrain (migraine)',
            'cc_modifiedtrauma' => 'trauma modifikasi (modified trauma)',
            'cc_motorcyclecrash' => 'kecelakaan sepeda motor (motor vehicle crash)',
            'cc_motorvehiclecrash' => 'kecelakaan kendaraan bermotor (motorcycle crash)',
            'cc_multiplefalls' => 'jatuh berulang (multiple falls)',
            'cc_nasalcongestion' => 'hidung tersumbat (nasal congestion)',
            'cc_nausea' => 'mual (nausea)',
            'cc_nearsyncope' => 'hampir pingsan (near syncope)',
            'cc_neckpain' => 'nyeri leher (neck pain)',
            'cc_neurologicproblem' => 'masalah neurologis (neurologic problem)',
            'cc_numbness' => 'kebas (numbness)',
            'cc_oralswelling' => 'pembengkakan mulut (oral swelling)',
            'cc_otalgia' => 'otalgia (otalgia)',
            'cc_other' => 'lainnya (other)',
            'cc_overdose-accidental' => 'overdosis tidak sengaja (overdose- accidental)',
            'cc_overdose-intentional' => 'overdosis disengaja (overdose- intentional)',
            'cc_pain' => 'nyeri (pain)',
            'cc_palpitations' => 'palpitasi (palpitations)',
            'cc_panicattack' => 'serangan panik (panic attack)',
            'cc_pelvicpain' => 'nyeri panggul (pelvic pain)',
            'cc_poisoning' => 'keracunan (poisoning)',
            'cc_post-opproblem' => 'masalah pasca operasi (post-op problem)',
            'cc_psychiatricevaluation' => 'evaluasi psikiatrik (psychiatric evaluation)',
            'cc_psychoticsymptoms' => 'gejala psikotik (psychotic symptoms)',
            'cc_rapidheartrate' => 'detak jantung cepat (rapid heart rate)',
            'cc_rash' => 'ruam (rash)',
            'cc_rectalbleeding' => 'perdarahan rektal (rectal bleeding)',
            'cc_rectalpain' => 'nyeri rektal (rectal pain)',
            'cc_respiratorydistress' => 'distres pernapasan (respiratory distress)',
            'cc_ribinjury' => 'cedera tulang rusuk (rib injury)',
            'cc_ribpain' => 'nyeri tulang rusuk (rib pain)',
            'cc_seizure-newonset' => 'kejang - onset baru (seizure- new onset)',
            'cc_seizure-priorhxof' => 'kejang - riwayat sebelumnya (seizure- prior hx of)',
            'cc_seizures' => 'kejang (seizures)',
            'cc_shortnessofbreath' => 'sesak napas (shortness of breath)',
            'cc_shoulderinjury' => 'cedera bahu (shoulder injury)',
            'cc_shoulderpain' => 'nyeri bahu (shoulder pain)',
            'cc_sicklecellpain' => 'nyeri sel sabit (sickle cell pain)',
            'cc_sinusproblem' => 'masalah sinus (sinus problem)',
            'cc_skinirritation' => 'iritasi kulit (skin irritation)',
            'cc_skinproblem' => 'masalah kulit (skin problem)',
            'cc_sorethroat' => 'sakit tenggorokan (sore throat)',
            'cc_stdcheck' => 'pemeriksaan penyakit menular seksual (std check)',
            'cc_strokealert' => 'waspada stroke (stroke alert)',
            'cc_suicidal' => 'berniat bunuh diri (suicidal)',
            'cc_suture/stapleremoval' => 'pengangkatan jahitan/staples (suture / staple removal)',
            'cc_swallowedforeignbody' => 'menelan benda asing (swallowed foreign body)',
            'cc_syncope' => 'sinkop (syncope)',
            'cc_tachycardia' => 'takikardia (tachycardia)',
            'cc_testiclepain' => 'nyeri testis (testicle pain)',
            'cc_thumbinjury' => 'cedera ibu jari (thumb injury)',
            'cc_tickremoval' => 'pengangkatan kutu (tick removal)',
            'cc_toeinjury' => 'cedera jari kaki (toe injury)',
            'cc_toepain' => 'nyeri jari kaki (toe pain)',
            'cc_trauma' => 'trauma (trauma)',
            'cc_unresponsive' => 'tidak responsif (unresponsive)',
            'cc_uri' => 'infeksi saluran pernapasan atas (uri)',
            'cc_urinaryfrequency' => 'frekuensi buang air kecil meningkat (urinary frequency)',
            'cc_urinaryretention' => 'retensi urin (urinary retention)',
            'cc_urinarytractinfection' => 'infeksi saluran kemih (urinary tract infection)',
            'cc_vaginalbleeding' => 'perdarahan vagina (vaginal bleeding)',
            'cc_vaginaldischarge' => 'keputihan (vaginal discharge)',
            'cc_vaginalpain' => 'nyeri vagina (vaginal pain)',
            'cc_weakness' => 'kelemahan (weakness)',
            'cc_wheezing' => 'mengi (wheezing)',
            'cc_withdrawal-alcohol' => 'penarikan alkohol (withdrawal- alcohol)',
            'cc_woundcheck' => 'pemeriksaan luka (wound check)',
            'cc_woundinfection' => 'infeksi luka (wound infection)',
            'cc_woundre-evaluation' => 'evaluasi ulang luka (wound re-evaluation)',
            'cc_wristinjury' => 'cedera pergelangan tangan (wrist injury)',
            'cc_wristpain' => 'nyeri pergelangan tangan (wrist pain)',
        ];

        $temp_cc = '';

        foreach ($triage->chief_complaint as $key => $value) {
            $temp_cc = $temp_cc .= $chief_complaint[$value];

            $isLastIteration = $key === array_key_last($triage->chief_complaint);
            if (!$isLastIteration) {
                $temp_cc = $temp_cc .= ', ';
            }
        }

        return $temp_cc;
    }

    public function show(Triage $triage)
    {
        return view('admin.triage.show', ['triage' => $triage]);
    }

    public function edit(Triage $triage, Request $request)
    {
        return view('admin.triage.edit', ['triage' => $triage]);
    }

    public function update(Triage $triage, Request $request)
    {
        $rules = [
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'sbp' => 'required|numeric',
            'dbp' => 'required|numeric',
            'hr' => 'required|numeric',
            'rr' => 'required|numeric',
            'bt' => 'required|numeric',
            'saturation' => 'required|numeric',
            'triage_vital_o2_device' => 'required',
            'validation' => 'in:1,2,3,4,5',
            'note' => 'nullable',
        ];

        if ($request->filled('chief_complaint')) {
            $rules['chief_complaint'] = 'required';
        }

        $validatedData = $request->validate($rules);
        $triage->fill($validatedData);

        if (isset($validatedData['chief_complaint'])) {
            $triage->chief_complaint = $this->chiefComplaintFromArrayToString($triage);
        }

        $triage->save();

        return redirect()
            ->route('admin.triage.edit', $triage->id)
            ->with('success', 'Data triase pasien berhasil diperbarui!');
    }

    public function destroy(Triage $triage)
    {
        $triage->delete();
        return response()->json(['success' => 'Triage deleted successfully.']);
    }
}
