<x-app-layout>
    <x-slot:title>Settings</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Settings" />
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.updateOrCreate') }}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Hospital type</label>
                                    <div class="col">
                                        <div class="mb-3">
                                            <select name="hospital_type" class="form-select">
                                                <option>None</option>
                                                <option value="local" @selected(old('hospital_type', $settings->where('key', 'hospital_type')->pluck('value')->first() ?? null) == 'local')>Local</option>
                                                <option value="regional" @selected(old('hospital_type', $settings->where('key', 'hospital_type')->pluck('value')->first() ?? null) == 'regional')>Regional</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100" type="submit">Saves</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
</x-app-layout>
