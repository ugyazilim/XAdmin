<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $fileFields = ['site_logo', 'about_video'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $ext = $file->getClientOriginalExtension();
                $filename = $field.'_'.time().'.'.$ext;
                $uploadPath = 'upload/settings/';

                if (! File::exists(public_path($uploadPath))) {
                    File::makeDirectory(public_path($uploadPath), 0755, true);
                }

                $oldValue = Setting::where('key', $field)->first()?->value;
                if ($oldValue && File::exists(public_path($oldValue))) {
                    File::delete(public_path($oldValue));
                }

                $file->move(public_path($uploadPath), $filename);

                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $uploadPath.$filename, 'group' => $group]
                );
            }
        }

        $validated = $request->validate([
            'settings' => 'nullable|array',
        ]);

        if (isset($validated['settings'])) {
            foreach ($validated['settings'] as $key => $value) {
                if (in_array($key, $fileFields)) {
                    continue;
                }
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => is_array($value) ? json_encode($value) : $value,
                        'group' => $group,
                    ]
                );
            }
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
