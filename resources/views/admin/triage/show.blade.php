<x-app-layout>
    <x-slot:title>Detail triase pasien</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Detail triase pasien" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="datagrid mb-3">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Nama</div>
                                            <div class="datagrid-content text-capitalize">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-xs me-2 rounded"
                                                        style="background-image: url({{ asset('assets/images/user.svg') }}"></span>
                                                        {{ $triage->name ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Umur</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ $triage->age ?? '-' }} <p class="text-secondary small lh-base d-inline">Tahun</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Jenis kelamin</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ $triage->gender == 'male' ? 'Laki-Laki' : 'Perempuan' ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Tekanan darah sistolik (SBP)</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ $triage->sbp ?? '' }} <p class="text-secondary small lh-base d-inline">mmHg</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Tekanan darah diastolik (DBP)</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ $triage->dbp ?? '' }} <p class="text-secondary small lh-base d-inline">mmHg</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Denyut jantung</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ (int) $triage->hr ?? '' }} <p class="text-secondary small lh-base d-inline">BPM</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Laju respirasi</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ (int) $triage->rr ?? '' }}
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Suhu tubuh</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ $triage->bt ?? '' }} <p class="text-secondary small lh-base d-inline">℃</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Saturasi Oksigen</div>
                                            <div class="datagrid-content text-capitalize">
                                                {{ (int) $triage->saturation ?? '' }} <p class="text-secondary small lh-base d-inline">%</p>
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Tersedia perangkat O2</div>
                                            <div class="datagrid-content">
                                                @if ($triage->triage_vital_o2_device == '1')
                                                    <span class="status status-primary"> Tersedia </span>
                                                @else
                                                    <span class="status status-secondary"> Tidak tersedia </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Hasil prediksi model artificial</div>
                                            <div class="datagrid-content">
                                                @if ($triage->prediction_level == '1')
                                                    <span class="status status-danger"> Level 1 - Resusitasi </span>
                                                @elseif($triage->prediction_level == '2')
                                                    <span class="status status-yellow"> Level 2 - Emergensi </span>
                                                @elseif($triage->prediction_level == '3')
                                                    <span class="status status-yellow"> Level 3 - Urgensi </span>
                                                @elseif($triage->prediction_level == '4')
                                                    <span class="status status-success"> Level 4 - Kurang urgensi
                                                    </span>
                                                @else
                                                    <span class="status status-primary">Level 5 - Tidak urgensi </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Hasil validasi tenaga medis</div>
                                            <div class="datagrid-content">
                                                @if ($triage->validation == '1')
                                                    <span class="status status-danger"> Level 1 - Resusitasi </span>
                                                @elseif($triage->validation == '2')
                                                    <span class="status status-yellow"> Level 2 - Emergensi </span>
                                                @elseif($triage->validation == '3')
                                                    <span class="status status-yellow"> Level 3 - Urgensi </span>
                                                @elseif($triage->validation == '4')
                                                    <span class="status status-success"> Level 4 - Kurang urgensi
                                                    </span>
                                                @else
                                                    <span class="status status-primary">Level 5 - Tidak urgensi </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="datagrid mb-3">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Keluhan</div>
                                            <div class="datagrid-content">
                                                {{ $triage->chief_complaint ?? '' }}.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="datagrid mb-3">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Catatan tambahan</div>
                                            <div class="datagrid-content">
                                                <textarea class="form-control" name="note" rows="6" disabled>{{ $triage->note ?? '-' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.triage.edit', $triage->id) }}"
                                        class="btn btn-primary w-100 mb-3">Ubah data</a>
                                    <div class="container d-flex align-items-center justify-content-center">
                                        <a href="{{ route('admin.dashboard') }}" class="">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
