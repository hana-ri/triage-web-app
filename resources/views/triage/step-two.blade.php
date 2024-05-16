<x-guest-layout>
    <div class="page-body">
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
                            <form action="{{ route('triage.step.two') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">SBP</label>
                                    <div class="col">
                                        <input type="number" name="sbp" class="form-control" placeholder="30">
                                        <small class="form-hint">Systolid blood pressure.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">DBP</label>
                                    <div class="col">
                                        <input type="number" name="dbp" class="form-control" placeholder="30">
                                        <small class="form-hint">Diastolic blood pressure.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">HR</label>
                                    <div class="col">
                                        <input type="number" name="hr" class="form-control" placeholder="30">
                                        <small class="form-hint">Heart rate.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">RR</label>
                                    <div class="col">
                                        <input type="number" name="rr" class="form-control" placeholder="30">
                                        <small class="form-hint">Respiration rate.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">BT</label>
                                    <div class="col">
                                        <input type="number" name="bt" class="form-control" placeholder="30">
                                        <small class="form-hint">Body temperature.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Saturation</label>
                                    <div class="col">
                                        <input type="number" name="saturation" class="form-control" placeholder="30">
                                        <small class="form-hint">Saturation bisa didapat dari pulse oxmeter.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Tiba dengan</label>
                                    <div class="col">
                                        <select name="arrival_mode" class="form-select">
                                            <option value="1">Ambulan umum</option>
                                            <option value="2">Ambulan pribadi</option>
                                            <option value="3">Kendaraan pribadi</option>
                                            <option value="4">Jalan kaki</option>
                                        </select>
                                        <small class="form-hint">Kedatanngan.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Pasien cedera</label>
                                    <div class="col">
                                        <select name="injury" class="form-select">
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                        <small class="form-hint">Mental.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Mental</label>
                                    <div class="col">
                                        <select name="mental" class="form-select">
                                            <option value="1">Alert</option>
                                            <option value="2">Verbal response</option>
                                            <option value="3">Pain response</option>
                                            <option value="4">Unconciousness</option>
                                        </select>
                                        <small class="form-hint">Mental.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Pasien merasakan nyeri</label>
                                    <div class="col">
                                        <select name="pain" class="form-select">
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                        <small class="form-hint">Mental.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Skala rasa sakit</label>
                                    <div class="col">
                                        <select name="nrs_pain" class="form-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                        <small class="form-hint">Mental.</small>
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
