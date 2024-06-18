<x-guest-layout>
    <x-slot:title>Prediction result</x-slot:title>
    <div class="page-body triage-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="steps steps-green steps-counter my-4">
                                <li class="step-item">Informasi pasien</li>
                                <li class="step-item">Triase</li>
                                <li class="step-item active">Hasil prediksi</li>
                            </ul>
                        </div>
                        <div class="card-body text-center">
                            {{-- <h2 class="text-center mt-3 text-blue">Hasil prediksi</h2> --}}
                            <div class="d-flex justify-content-center">
                                @php
                                    if ($data['result'] == '1.0') {
                                        $flag = 'danger';
                                        $triageTitle = 'Resusitasi';
                                        $triageMessage = 'Kondisi medis yang mengancam jiwa diharapkan segera mendapat penanganan.';
                                    } elseif ($data['result'] == '2.0') {
                                        $flag = 'warning';
                                        $triageTitle = 'Emergensi';
                                        $triageMessage = 'Kondisi medis yang serius diharapkan mendapatkan penanganan setelah pasien yang berwarna triase level 1 distabilkan.';
                                    } elseif ($data['result'] == '3.0') {
                                        $flag = 'yellow';
                                        $triageTitle = 'Urgensi';
                                        $triageMessage = 'Kondisi medis yang serius diharapkan mendapatkan penanganan setelah pasien yang berwarna triase level 2 distabilkan.';
                                    } elseif ($data['result'] == '4.0') {
                                        $flag = 'success';
                                        $triageTitle = 'Kurang Urgensi';
                                        $triageMessage = 'Pasien dengan kondisi yang tidak mendesak yang mungkin membutuhkan perawatan, tetapi dapat menunggu lebih lama daripada pasien dengan triase level 3.';
                                    } else {
                                        $flag = 'blue';
                                        $triageTitle = 'Tidak Urgensi';
                                        $triageMessage = 'Pasien dengan kondisi non-urgent atau minor yang membutuhkan perawatan minimal dan bisa menunggu perawatan untuk jangka waktu yang lebih lama daripada pasien di tingkat lain.';
                                    }
                                @endphp
                                <div class="alert alert-{{ $flag }}" role="{{ $flag }}">
                                    <div class="d-flex">
                                        <div>
                                            <h4 class="alert-title"> <i class="ti icon ti-alert-circle"></i>
                                                Triase {{ $data['result'] }} {{ $triageTitle }}!</h4>
                                            <div class="text-secondary">{{ $triageMessage }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="text-center mt-3">Mengapa harus ada triase?</h2>
                            <p class="text-secondary text-center">Mungkin sistem triase tidak sesederhana sistem antrian (first come first serve), tapi ini diperlukan ketika IGD untuk memperlakukan pasien secara adil sesuai dengan gejala yang dialami pasien.</p>
                            <a href="{{ route('triage.step.one') }}">Lakukan triase kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
