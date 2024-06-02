<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        $settings = Setting::all();
        return view('admin.settings', compact('settings'));
    }

    public function updateOrCreateSetting(Request $request) {
        $validatedData = $request->validate([
            'hospital_type' => 'required',
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return redirect()->route('admin.settings.index');
    }
}
