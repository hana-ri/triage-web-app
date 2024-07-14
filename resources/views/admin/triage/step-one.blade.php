<x-app-layout>
    <x-slot:title>Informasi pasien</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Informasi pasien" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="steps steps-green steps-counter my-4">
                                <li class="step-item active">Informasi pasien</li>
                                <li class="step-item">Triase</li>
                                <li class="step-item">Validasi</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.triage.step.one.process') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Nama pasien</label>
                                    <div class="col">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Jhon doe"
                                            value="{{ old('name', session()->get('triage')->name ?? '') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Umur</label>
                                    <div class="col">
                                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" placeholder="30"
                                            value="{{ old('age', session()->get('triage')->age ?? '') }}">
                                            @error('age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Jenis Kelamin</label>
                                    <div class="col">
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                            <option value="male" @selected(old('gender', session()->get('triage')->gender ?? '') == 'male')>Laki-Laki</option>
                                            <option value="female" @selected(old('gender', session()->get('triage')->gender ?? '') == 'female')>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Triase</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
