@extends('admin.layout')
@section('title', 'تنظیمات فروشگاه')
@section('content')
<div class="page-head"><div><h1>تنظیمات فروشگاه</h1><p class="muted">اطلاعات عمومی و راه‌های ارتباطی فروشگاه را از اینجا تغییر بده.</p></div></div>
<form class="panel" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="form-grid">
<div class="field"><label>نام فروشگاه</label><input name="store_name" value="{{ old('store_name', $settings['store_name'] ?? 'موبیکس هاب') }}" required></div>
<div class="field"><label>شعار فروشگاه</label><input name="store_tagline" value="{{ old('store_tagline', $settings['store_tagline'] ?? '') }}"></div>
<div class="field"><label>شماره تماس پشتیبانی</label><input name="support_phone" value="{{ old('support_phone', $settings['support_phone'] ?? '') }}"></div>
<div class="field"><label>ایمیل پشتیبانی</label><input type="email" name="support_email" value="{{ old('support_email', $settings['support_email'] ?? '') }}"></div>
<div class="field"><label>لینک پشتیبانی بله</label><input type="url" name="support_bale" value="{{ old('support_bale', $settings['support_bale'] ?? '') }}"></div>
<div class="field"><label>لینک واتساپ</label><input type="url" name="support_whatsapp" value="{{ old('support_whatsapp', $settings['support_whatsapp'] ?? '') }}"></div>
<div class="field"><label>لینک تلگرام</label><input type="url" name="support_telegram" value="{{ old('support_telegram', $settings['support_telegram'] ?? '') }}"></div>
<div class="field"><label>هزینه ارسال (تومان)</label><input type="number" min="0" name="shipping_cost" value="{{ old('shipping_cost', $settings['shipping_cost'] ?? 0) }}" required></div>
<div class="field full"><label>عنوان اصلی صفحه اول</label><input name="home_title" value="{{ old('home_title', $settings['home_title'] ?? '') }}"></div>
<div class="field full"><label>توضیح کوتاه صفحه اول</label><textarea name="home_description">{{ old('home_description', $settings['home_description'] ?? '') }}</textarea></div>
<div class="field"><label>لوگوی فروشگاه (حداکثر ۲ مگابایت)</label><input type="file" name="logo" accept="image/*">@if(!empty($settings['logo_path']))<small>فایل فعلی: {{ basename($settings['logo_path']) }}</small>@endif</div>
<div class="field"><label>بنر صفحه اول (حداکثر ۵ مگابایت)</label><input type="file" name="home_banner" accept="image/*">@if(!empty($settings['home_banner_path']))<small>فایل فعلی: {{ basename($settings['home_banner_path']) }}</small>@endif</div>
</div><div class="form-actions"><button class="btn" type="submit">ذخیره تنظیمات</button></div>
</form>
@endsection
