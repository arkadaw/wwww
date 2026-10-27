@extends('layouts.store')
@section('title', $metaTitle ?? ($pageTitle.' | موبیکس هاب'))
@if(!empty($metaDescription))@section('meta_description', $metaDescription)@endif
@section('content')
<section class="wrap page-head"><span class="eyebrow">موبیکس هاب</span><h1>{{ $pageTitle }}</h1></section>
<section class="wrap static-page"><div style="white-space:pre-line;overflow-wrap:anywhere">{{ $pageText }}</div>
@if(($pageTitle ?? '') === 'تماس با ما')
<div class="contact-links">
@if(!empty($siteSettings['support_bale']))<a href="{{ $siteSettings['support_bale'] }}" target="_blank" rel="noopener noreferrer">پشتیبانی بله</a>@endif
@if(!empty($siteSettings['support_whatsapp']))<a href="{{ $siteSettings['support_whatsapp'] }}" target="_blank" rel="noopener noreferrer">واتساپ</a>@endif
@if(!empty($siteSettings['support_telegram']))<a href="{{ $siteSettings['support_telegram'] }}" target="_blank" rel="noopener noreferrer">تلگرام</a>@endif
@if(!empty($siteSettings['support_phone']))<p>تلفن پشتیبانی: {{ $siteSettings['support_phone'] }}</p>@endif
</div>@endif
</section>
@endsection
