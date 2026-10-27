<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->timestamps();
        });

        $now = now();
        DB::table('site_settings')->insert(array_map(fn ($item) => [
            'key' => $item[0], 'value' => $item[1], 'created_at' => $now, 'updated_at' => $now,
        ], [
            ['store_name', 'موبیکس هاب'],
            ['store_tagline', 'فروشگاه جانبی موبیکس هاب'],
            ['support_phone', ''],
            ['support_email', ''],
            ['support_bale', 'https://ble.ir/supportmobixhub'],
            ['support_whatsapp', 'https://wa.me/989353055697'],
            ['support_telegram', 'https://t.me/mobixhubsupport'],
            ['shipping_cost', '0'],
            ['home_title', 'خرید لوازم جانبی موبایل'],
            ['home_description', ''],
            ['logo_path', ''],
            ['home_banner_path', ''],
        ]));

        DB::table('site_pages')->insert(array_map(fn ($p) => [
            'slug' => $p[0], 'title' => $p[1], 'content' => $p[2], 'is_published' => true,
            'meta_title' => $p[1] . ' | موبیکس هاب', 'meta_description' => null,
            'created_at' => $now, 'updated_at' => $now,
        ], [
            ['about', 'درباره ما', 'موبیکس هاب، فروشگاه اینترنتی لوازم جانبی موبایل.'],
            ['contact', 'تماس با ما', 'برای ارتباط با پشتیبانی می‌توانید از راه‌های ارتباطی فروشگاه استفاده کنید.'],
            ['terms', 'قوانین و مقررات', 'لطفاً پیش از ثبت سفارش، قوانین فروشگاه را مطالعه کنید.'],
            ['privacy', 'حریم خصوصی', 'اطلاعات مشتریان صرفاً برای ارائه خدمات فروشگاه استفاده می‌شود.'],
            ['shipping', 'روش‌های ارسال', 'روش و هزینه ارسال سفارش در این صفحه توضیح داده می‌شود.'],
            ['returns', 'شرایط مرجوعی', 'شرایط بررسی و مرجوعی کالا در این صفحه درج می‌شود.'],
            ['faq', 'پرسش‌های متداول', 'پاسخ پرسش‌های رایج مشتریان را در این صفحه وارد کنید.'],
        ]));
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pages');
        Schema::dropIfExists('site_settings');
    }
};
