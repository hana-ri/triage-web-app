<x-app-layout>
    <x-slot:title>Validasi hasil klasifikasi</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Validasi hasil" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="steps steps-green steps-counter my-4">
                                <li class="step-item">Informasi pasien</li>
                                <li class="step-item">Triase</li>
                                <li class="step-item active">Validasi</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('admin.triage.validation.process') }}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <div class="mb-3 col-12">
                                        <div class="datagrid">
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Nama</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Umur</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->age ?? '' }} Tahun
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Jenis kelamin</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->gender == 1 ? 'Laki-Laki' : 'Perempuan' }}
                                                </div>
                                            </div>
                                            {{-- </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <div class="datagrid"> --}}
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Tekanan darah sistolik (SBP)</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->sbp ?? '' }} mmHg
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Tekanan darah diastolik (DBP)</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->dbp ?? '' }} mmHg
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Denyut jantung</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->hr ?? '' }} BPM
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Laju respirasi</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->rr ?? '' }}
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Suhu tubuh</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->bt ?? '' }} ℃
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Saturasi Oksigen</div>
                                                <div class="datagrid-content text-capitalize">
                                                    {{ session()->get('triage')->saturation ?? '' }}%
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Membutuhkan perangkat O2</div>
                                                <div class="datagrid-content">
                                                    @if (session()->get('triage')->triage_vital_o2_device == '1')
                                                        <span class="status status-primary"> Ya </span>
                                                    @else
                                                        <span class="status status-secondary"> Tidak </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <div class="datagrid">
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Keluhan</div>
                                                <div class="datagrid-content">
                                                    {{ session()->get('triage')->chief_complaint ?? '' }}.
                                                    {{-- <textarea class="form-control" name="example-textarea-input" rows="6" disabled>{{ session()->get('triage')->chief_complaint ?? '' }}</textarea> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <div class="datagrid">
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Hasil prediksi model artificial</div>
                                                <div class="datagrid-content">
                                                    @if (session()->get('triage')->prediction_level == 1)
                                                        <div class="alert alert-important alert-danger m-0" role="alert">
                                                            <div class="d-flex">
                                                                    Level
                                                                    {{ session()->get('triage')->prediction_level }}
                                                            </div>
                                                        </div>
                                                    @elseif (session()->get('triage')->prediction_level == 2)
                                                    <div class="alert alert-important alert-orange" role="alert">
                                                        <div class="d-flex">
                                                                Level
                                                                {{ session()->get('triage')->prediction_level }}
                                                        </div>
                                                    </div>
                                                    @elseif (session()->get('triage')->prediction_level == 3)
                                                    <div class="alert alert-important alert-yellow" role="alert">
                                                        <div class="d-flex">
                                                                Level
                                                                {{ session()->get('triage')->prediction_level }}
                                                        </div>
                                                    </div>
                                                    @elseif (session()->get('triage')->prediction_level == 4)
                                                    <div class="alert alert-important alert-green" role="alert">
                                                        <div class="d-flex">
                                                                Level
                                                                {{ session()->get('triage')->prediction_level }}
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="alert alert-important alert-blue" role="alert">
                                                        <div class="d-flex">
                                                                Level
                                                                {{ session()->get('triage')->prediction_level }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title form-label required">Konfirmasi level triase</div>
                                                <div class="datagrid-content">
                                                    <select name="validation"
                                                        class="form-select @error('validation') is-invalid @enderror">
                                                        <option>Silakan pilih level</option>
                                                        <option value="1">Level 1</option>
                                                        <option value="2">Level 2</option>
                                                        <option value="3">Level 3</option>
                                                        <option value="4">Level 4</option>
                                                        <option value="5">Levle 5</option>
                                                    </select>
                                                    @error('validation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <div class="datagrid">
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Catatan tambahan (Opsional)</div>
                                                <div class="datagrid-content">
                                                    <textarea class="form-control" name="note" rows="6" placeholder="Catatan..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-3">Simpan</button>
                                <div class="container d-flex align-items-center justify-content-center">
                                    <a href="{{ route('admin.triage.step.two') }}" class="">Kembali ke triase</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
