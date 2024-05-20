<x-guest-layout>
    <x-slot:title>Step 1</x-slot:title>
    <div class="page-body triage-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="steps steps-green steps-counter my-4">
                                <li class="step-item active">Informasi pasien</li>
                                <li class="step-item">Triase</li>
                                <li class="step-item">Hasil prediksi</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('triage.step.one.process') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Nama pasien</label>
                                    <div class="col">
                                        <input type="text" name="name" class="form-control" placeholder="Jhon doe">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Umur</label>
                                    <div class="col">
                                        <input type="number" name="age" class="form-control" placeholder="30">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Jenis Kelamin</label>
                                    <div class="col">
                                        <select name="gender" class="form-select">
                                            <option value="male">Laki-Laki</option>
                                            <option value="female">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Triase</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
