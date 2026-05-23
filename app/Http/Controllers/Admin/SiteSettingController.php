<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.branding');
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'site_favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp,svg', 'max:1024'],
        ]);

        foreach (['site_logo' => 'branding/logos', 'site_favicon' => 'branding/favicons'] as $field => $directory) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $oldPath = SiteSetting::getValue($field);
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

            SiteSetting::setValue($field, $request->file($field)->store($directory, 'public'));
        }

        return redirect()
            ->route('admin.settings.branding')
            ->with('success', 'Logo website dan favicon berhasil diperbarui.');
    }
}
