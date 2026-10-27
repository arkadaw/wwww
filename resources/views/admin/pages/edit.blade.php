@extends('admin.layout')
@section('title', 'ویرایش صفحه')
@section('content')
<div class="page-head"><div><h1>ویرایش: {{ $page->title }}</h1><p class="muted">متن این صفحه در سایت نمایش داده می‌شود.</p></div><a class="btn btn-light" href="{{ route('admin.pages.index') }}">بازگشت</a></div>
<form class="panel" method="POST" action="{{ route('admin.pages.update', $page) }}">@csrf @method('PUT')
<div class="form-grid">
<div class="field full"><label>عنوان صفحه</label><input name="title" value="{{ old('title', $page->title) }}" required></div>
<div class="field full"><label>متن صفحه</label><textarea name="content" rows="12">{{ old('content', $page->content) }}</textarea><small class="muted">فعلاً متن ساده وارد کن؛ HTML خام پذیرفته نمی‌شود.</small></div>
<div class="field"><label>عنوان سئو (Meta Title)</label><input name="meta_title" maxlength="180" value="{{ old('meta_title', $page->meta_title) }}"></div>
<div class="field full"><label>توضیحات متا (Meta Description)</label><textarea name="meta_description" maxlength="320">{{ old('meta_description', $page->meta_description) }}</textarea></div>
<div class="field full"><label class="checkrow"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published))> انتشار این صفحه در سایت فعال باشد</label></div>
</div><div class="form-actions"><button class="btn" type="submit">ذخیره صفحه</button></div></form>
@endsection
