@extends('admin.layout')
@section('title', 'صفحات سایت')
@section('content')
<div class="page-head"><div><h1>صفحات سایت</h1><p class="muted">قوانین و متن صفحات را بدون تغییر کد ویرایش کن.</p></div></div>
<div class="panel table-wrap"><table><thead><tr><th>عنوان صفحه</th><th>آدرس</th><th>وضعیت</th><th>تنظیمات</th></tr></thead><tbody>
@forelse($pages as $page)<tr><td>{{ $page->title }}</td><td dir="ltr">/{{ $page->slug }}</td><td><span class="status">{{ $page->is_published ? 'منتشر شده' : 'پیش‌نویس' }}</span></td><td><div class="inline-actions"><a class="btn btn-light btn-small" href="{{ route('admin.pages.edit', $page) }}">ویرایش</a>@if($page->is_published)<a class="btn btn-light btn-small" target="_blank" href="{{ url('/'.$page->slug) }}">مشاهده</a>@endif</div></td></tr>@empty<tr><td colspan="4" class="empty">صفحه‌ای وجود ندارد.</td></tr>@endforelse
</tbody></table></div>
@endsection
