<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
        ]);

        foreach ($validated['settings'] as $setting) {
            Setting::where('key', $setting['key'])->update([
                'value' => $setting['value'],
            ]);
        }

        return back()->with('success', 'Ayarlar güncellendi.');
    }

    public function updateGroup(Request $request, string $group)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'group' => $group,
                ]
            );
        }

        return back()->with('success', ucfirst($group).' ayarları güncellendi.');
    }

    public function toggleMaintenance()
    {
        $setting = Setting::where('key', 'maintenance_mode')->first();

        if ($setting) {
            $newValue = $setting->value === '1' ? '0' : '1';
            $setting->update(['value' => $newValue]);
            $message = $newValue === '1' ? 'Bakım modu açıldı.' : 'Bakım modu kapatıldı.';
        } else {
            Setting::create([
                'key' => 'maintenance_mode',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'general',
            ]);
            $message = 'Bakım modu açıldı.';
        }

        return back()->with('success', $message);
    }
}
