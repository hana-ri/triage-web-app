@php
    // $chief_complaint = [
    //     'cc_abdominalcramping' => 'abdominal cramping',
    //     'cc_abdominaldistention' => 'abdominal distention',
    //     'cc_abdominalpain' => 'abdominal pain',
    //     'cc_abdominalpainpregnant' => 'abdominal pain pregnant',
    //     'cc_abnormallab' => 'abnormal lab',
    //     'cc_abscess' => 'abscess',
    //     'cc_addictionproblem' => 'addiction problem',
    //     'cc_agitation' => 'agitation',
    //     'cc_alcoholintoxication' => 'alcohol intoxication',
    //     'cc_alcoholproblem' => 'alcohol problem',
    //     'cc_allergicreaction' => 'allergic reaction',
    //     'cc_alteredmentalstatus' => 'altered mental status',
    //     'cc_animalbite' => 'animal bite',
    //     'cc_ankleinjury' => 'ankle injury',
    //     'cc_anklepain' => 'ankle pain',
    //     'cc_anxiety' => 'anxiety',
    //     'cc_arminjury' => 'arm injury',
    //     'cc_armpain' => 'arm pain',
    //     'cc_armswelling' => 'arm swelling',
    //     'cc_assaultvictim' => 'assault victim',
    //     'cc_asthma' => 'asthma',
    //     'cc_backpain' => 'back pain',
    //     'cc_bleeding/bruising' => 'bleeding/bruising',
    //     'cc_blurredvision' => 'blurred vision',
    //     'cc_bodyfluidexposure' => 'body fluid exposure',
    //     'cc_breastpain' => 'breast pain',
    //     'cc_breathingdifficulty' => 'breathing difficulty',
    //     'cc_breathingproblem' => 'breathing problem',
    //     'cc_burn' => 'burn',
    //     'cc_cardiacarrest' => 'cardiac arrest',
    //     'cc_cellulitis' => 'cellulitis',
    //     'cc_chestpain' => 'chest pain',
    //     'cc_chesttightness' => 'chest tightness',
    //     'cc_chills' => 'chills',
    //     'cc_coldlikesymptoms' => 'cold like symptoms',
    //     'cc_confusion' => 'confusion',
    //     'cc_conjunctivitis' => 'conjunctivitis',
    //     'cc_constipation' => 'constipation',
    //     'cc_cough' => 'cough',
    //     'cc_cyst' => 'cyst',
    //     'cc_decreasedbloodsugar-symptomatic' => 'decreased blood sugar-symptomatic',
    //     'cc_dehydration' => 'dehydration',
    //     'cc_dentalpain' => 'dental pain',
    //     'cc_depression' => 'depression',
    //     'cc_detoxevaluation' => 'detox evaluation',
    //     'cc_diarrhea' => 'diarrhea',
    //     'cc_dizziness' => 'dizziness',
    //     'cc_drug/alcoholassessment' => 'drug / alcohol assessment',
    //     'cc_drugproblem' => 'drug problem',
    //     'cc_dyspnea' => 'dyspnea',
    //     'cc_dysuria' => 'dysuria',
    //     'cc_earpain' => 'ear pain',
    //     'cc_earproblem' => 'ear problem',
    //     'cc_edema' => 'edema',
    //     'cc_elbowpain' => 'elbow pain',
    //     'cc_elevatedbloodsugar-nosymptoms' => 'elevated blood sugar-no symptoms',
    //     'cc_elevatedbloodsugar-symptomatic' => 'elevated blood sugar-symptomatic',
    //     'cc_emesis' => 'emesis',
    //     'cc_epigastricpain' => 'epigastric pain',
    //     'cc_epistaxis' => 'epistaxis',
    //     'cc_exposuretostd' => 'exposure to std',
    //     'cc_extremitylaceration' => 'extremity laceration',
    //     'cc_extremityweakness' => 'extremity weakness',
    //     'cc_eyeinjury' => 'eye injury',
    //     'cc_eyepain' => 'eye pain',
    //     'cc_eyeproblem' => 'eye problem',
    //     'cc_eyeredness' => 'eye redness',
    //     'cc_facialinjury' => 'facial injury',
    //     'cc_faciallaceration' => 'facial laceration',
    //     'cc_facialpain' => 'facial pain',
    //     'cc_facialswelling' => 'facial swelling',
    //     'cc_fall' => 'fall',
    //     'cc_fall>65' => 'fall >65',
    //     'cc_fatigue' => 'fatigue',
    //     'cc_femaleguproblem' => 'female gu problem',
    //     'cc_fever' => 'fever',
    //     'cc_fever-75yearsorolder' => 'fever-75 years or older',
    //     'cc_fever-9weeksto74years' => 'fever-9 weeks to 74 years',
    //     'cc_feverimmunocompromised' => 'fever immunocompromised',
    //     'cc_fingerinjury' => 'finger injury',
    //     'cc_fingerpain' => 'finger pain',
    //     'cc_fingerswelling' => 'finger swelling',
    //     'cc_flankpain' => 'flank pain',
    //     'cc_follow-upcellulitis' => 'follow-up cellulitis',
    //     'cc_footinjury' => 'foot injury',
    //     'cc_footpain' => 'foot pain',
    //     'cc_footswelling' => 'foot swelling',
    //     'cc_foreignbodyineye' => 'foreign body in eye',
    //     'cc_fulltrauma' => 'full trauma',
    //     'cc_generalizedbodyaches' => 'generalized body aches',
    //     'cc_gibleeding' => 'gi bleeding',
    //     'cc_giproblem' => 'gi problem',
    //     'cc_groinpain' => 'groin pain',
    //     'cc_hallucinations' => 'hallucinations',
    //     'cc_handinjury' => 'hand injury',
    //     'cc_handpain' => 'hand pain',
    //     'cc_headache' => 'headache',
    //     'cc_headache-newonsetornewsymptoms' => 'headache- new onset or new symptoms',
    //     'cc_headache-recurrentorknowndxmigraines' => 'headache- recurrent or known dx migraines',
    //     'cc_headachere-evaluation' => 'headache re-evaluation',
    //     'cc_headinjury' => 'head injury',
    //     'cc_headlaceration' => 'head laceration',
    //     'cc_hematuria' => 'hematuria',
    //     'cc_hemoptysis' => 'hemoptysis',
    //     'cc_hippain' => 'hip pain',
    //     'cc_homicidal' => 'homicidal',
    //     'cc_hyperglycemia' => 'hyperglycemia',
    //     'cc_hypertension' => 'hypertension',
    //     'cc_hypotension' => 'hypotension',
    //     'cc_influenza' => 'influenza',
    //     'cc_ingestion' => 'ingestion',
    //     'cc_insectbite' => 'insect bite',
    //     'cc_irregularheartbeat' => 'irregular heart beat',
    //     'cc_jawpain' => 'jaw pain',
    //     'cc_jointswelling' => 'joint swelling',
    //     'cc_kneeinjury' => 'knee injury',
    //     'cc_kneepain' => 'knee pain',
    //     'cc_laceration' => 'laceration',
    //     'cc_leginjury' => 'leg injury',
    //     'cc_legpain' => 'leg pain',
    //     'cc_legswelling' => 'leg swelling',
    //     'cc_lethargy' => 'lethargy',
    //     'cc_lossofconsciousness' => 'loss of consciousness',
    //     'cc_maleguproblem' => 'male gu problem',
    //     'cc_mass' => 'mass',
    //     'cc_medicalproblem' => 'medical problem',
    //     'cc_medicalscreening' => 'medical screening',
    //     'cc_medicationproblem' => 'medication problem',
    //     'cc_medicationrefill' => 'medication refill',
    //     'cc_migraine' => 'migraine',
    //     'cc_modifiedtrauma' => 'modified trauma',
    //     'cc_motorcyclecrash' => 'motor vehicle crash',
    //     'cc_motorvehiclecrash' => 'motorcycle crash',
    //     'cc_multiplefalls' => 'multiple falls',
    //     'cc_nasalcongestion' => 'nasal congestion',
    //     'cc_nausea' => 'nausea',
    //     'cc_nearsyncope' => 'near syncope',
    //     'cc_neckpain' => 'neck pain',
    //     'cc_neurologicproblem' => 'neurologic problem',
    //     'cc_numbness' => 'numbness',
    //     'cc_oralswelling' => 'oral swelling',
    //     'cc_otalgia' => 'otalgia',
    //     'cc_other' => 'other',
    //     'cc_overdose-accidental' => 'overdose- accidental',
    //     'cc_overdose-intentional' => 'overdose- intentional',
    //     'cc_pain' => 'pain',
    //     'cc_palpitations' => 'palpitations',
    //     'cc_panicattack' => 'panic attack',
    //     'cc_pelvicpain' => 'pelvic pain',
    //     'cc_poisoning' => 'poisoning',
    //     'cc_post-opproblem' => 'post-op problem',
    //     'cc_psychiatricevaluation' => 'psychiatric evaluation',
    //     'cc_psychoticsymptoms' => 'psychotic symptoms',
    //     'cc_rapidheartrate' => 'rapid heart rate',
    //     'cc_rash' => 'rash',
    //     'cc_rectalbleeding' => 'rectal bleeding',
    //     'cc_rectalpain' => 'rectal pain',
    //     'cc_respiratorydistress' => 'respiratory distress',
    //     'cc_ribinjury' => 'rib injury',
    //     'cc_ribpain' => 'rib pain',
    //     'cc_seizure-newonset' => 'seizure- new onset',
    //     'cc_seizure-priorhxof' => 'seizure- prior hx of',
    //     'cc_seizures' => 'seizures',
    //     'cc_shortnessofbreath' => 'shortness of breath',
    //     'cc_shoulderinjury' => 'shoulder injury',
    //     'cc_shoulderpain' => 'shoulder pain',
    //     'cc_sicklecellpain' => 'sickle cell pain',
    //     'cc_sinusproblem' => 'sinus problem',
    //     'cc_skinirritation' => 'skin irritation',
    //     'cc_skinproblem' => 'skin problem',
    //     'cc_sorethroat' => 'sore throat',
    //     'cc_stdcheck' => 'std check',
    //     'cc_strokealert' => 'stroke alert',
    //     'cc_suicidal' => 'suicidal',
    //     'cc_suture/stapleremoval' => 'suture / staple removal',
    //     'cc_swallowedforeignbody' => 'swallowed foreign body',
    //     'cc_syncope' => 'syncope',
    //     'cc_tachycardia' => 'tachycardia',
    //     'cc_testiclepain' => 'testicle pain',
    //     'cc_thumbinjury' => 'thumb injury',
    //     'cc_tickremoval' => 'tick removal',
    //     'cc_toeinjury' => 'toe injury',
    //     'cc_toepain' => 'toe pain',
    //     'cc_trauma' => 'trauma',
    //     'cc_unresponsive' => 'unresponsive',
    //     'cc_uri' => 'uri',
    //     'cc_urinaryfrequency' => 'urinary frequency',
    //     'cc_urinaryretention' => 'urinary retention',
    //     'cc_urinarytractinfection' => 'urinary tract infection',
    //     'cc_vaginalbleeding' => 'vaginal bleeding',
    //     'cc_vaginaldischarge' => 'vaginal discharge',
    //     'cc_vaginalpain' => 'vaginal pain',
    //     'cc_weakness' => 'weakness',
    //     'cc_wheezing' => 'wheezing',
    //     'cc_withdrawal-alcohol' => 'withdrawal- alcohol',
    //     'cc_woundcheck' => 'wound check',
    //     'cc_woundinfection' => 'wound infection',
    //     'cc_woundre-evaluation' => 'wound re-evaluation',
    //     'cc_wristinjury' => 'wrist injury',
    //     'cc_wristpain' => 'wrist pain',
    // ];
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

@endphp

<x-guest-layout>
    <x-slot:title>Step 2</x-slot:title>
    <div class="page-body triage-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="steps steps-green steps-counter my-4">
                                <li class="step-item">Informasi pasien</li>
                                <li class="step-item active">Triase</li>
                                <li class="step-item">Hasil prediksi</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('triage.step.two.process') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Teknan darah sistolik</label>
                                    <div class="col">
                                        <input type="number" step="0.01" name="sbp"
                                            class="form-control @error('sbp') is-invalid @enderror" placeholder="120"
                                            value="{{ old('sbp', session()->get('triage')->sbp ?? '') }}">
                                        <small class="form-hint">Tekanan darah maksimum selama kontraksi
                                            ventrikel.</small>
                                        @error('sbp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Telamam darah diastolik</label>
                                    <div class="col">
                                        <input type="number" step="0.01" name="dbp"
                                            class="form-control @error('dbp') is-invalid @enderror" placeholder="80"
                                            value="{{ old('dbp', session()->get('triage')->dbp ?? '') }}">
                                        <small class="form-hint">Tekanan minimum yang dicatat sesaat sebelum kontraksi
                                            berikutnya.</small>
                                        @error('dbp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Denyut jantung</label>
                                    <div class="col">
                                        <input type="number" step="0.01" name="hr"
                                            class="form-control @error('hr') is-invalid @enderror" placeholder="70"
                                            value="{{ old('hr', session()->get('triage')->hr ?? '') }}">
                                        <small class="form-hint">Berapa kali jantung berdenyut per menit.</small>
                                        @error('hr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Lajut respirasi</label>
                                    <div class="col">
                                        <input type="number" step="0.01" name="rr"
                                            class="form-control @error('rr') is-invalid @enderror" placeholder="20"
                                            value="{{ old('rr', session()->get('triage')->rr ?? '') }}">
                                        <small class="form-hint">Jumlah napas yang diambil seseorang per menit.</small>
                                        @error('rr')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Suhu tubuh</label>
                                    <div class="col">
                                        <input type="number" step="0.01" name="bt"
                                            class="form-control @error('bt') is-invalid @enderror" placeholder="37"
                                            value="{{ old('bt', session()->get('triage')->bt ?? '') }}">
                                        <small class="form-hint">Skala suhu tubuh yang digunakan adalah skala celcius
                                            ℃.</small>
                                        @error('bt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Saturasi oksigen</label>
                                    <div class="col">
                                        <input type="text" name="saturation"
                                            class="form-control @error('saturation') is-invalid @enderror"
                                            placeholder="98"
                                            value="{{ old('saturation', session()->get('triage')->saturation ?? '') }}">
                                        <small class="form-hint">Kadar oksigen didalam darah.</small>
                                        @error('saturation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Perangkat O2</label>
                                    <div class="col">
                                        <select name="triage_vital_o2_device"
                                            class="form-select @error('triage_vital_o2_device') is-invalid @enderror">
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                        @error('triage_vital_o2_device')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Tersedia alat yang dapat digunakan untuk memberikan
                                            oksigen ekstra kepada pasien, seperti tabung oksigen, masker oksigen, atau
                                            kanula hidung.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Keluhan utama</label>
                                    <div class="col">
                                        <select id="select-state" name="chief_complaint[]" multiple
                                            class="@error('chief_complaint') is-invalid @enderror"
                                            placeholder="Select a state..." autocomplete="off">
                                            <option value="">Select a state...</option>
                                            @foreach ($chief_complaint as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('chief_complaint')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        {{-- <small class="form-hint">presence of supplementary O2 device at triage</small> --}}
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Triase</button>
                                <div class="container d-flex align-items-center justify-content-center">
                                    <a href="{{ route('triage.step.one') }}" class="">Kembali ke langkah awal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    @endpush
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        <script>
            new TomSelect("#select-state", {});
        </script>
    @endpush
</x-guest-layout>
