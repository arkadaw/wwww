<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    private const FIELDS = [
        'store_name', 'store_tagline', 'support_phone', 'support_email',
        'support_bale', 'support_whatsapp', 'support_telegram', 'shipping_cost',
        'home_title', 'home_description',
    ];

    public function edit(): View
    {
        $settings = SiteSetting::query()->pluck('value', 'key')->all();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:120'],
            'store_tagline' => ['nullable', 'string', 'max:180'],
            'support_phone' => ['nullable', 'string', 'max:40'],
            'support_email' => ['nullable', 'email', 'max:190'],
            'support_bale' => ['nullable', 'url', 'max:500'],
            'support_whatsapp' => ['nullable', 'url', 'max:500'],
            'support_telegram' => ['nullable', 'url', 'max:500'],
            'shipping_cost' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'home_title' => ['nullable', 'string', 'max:180'],
            'home_description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'home_banner' => ['nullable', 'image', 'max:5120'],
        ]);

        foreach (self::FIELDS as $key) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $data[$key] ?? '']);
        }
        foreach (['logo' => 'logo_path', 'home_banner' => 'home_banner_path'] as $input => $key) {
            if ($request->hasFile($input)) {
                $old = SiteSetting::valueFor($key);
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($input)->store('site', 'public');
                SiteSetting::updateOrCreate(['key' => $key], ['value' => $path]);
            }
        }

        return back()->with('success', 'تنظیمات فروشگاه ذخیره شد.');
    }
}
