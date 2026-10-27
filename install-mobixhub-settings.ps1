$ErrorActionPreference = 'Stop'
$project = 'D:\mobixhub'
$patch = Split-Path -Parent $MyInvocation.MyCommand.Path
if (!(Test-Path "$project\artisan")) { throw 'پروژه در D:\mobixhub پیدا نشد.' }
$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$backup = "D:\mobixhub-settings-backup-$stamp"
New-Item -ItemType Directory -Path $backup | Out-Null

$files = @(
'app\Models\SiteSetting.php',
'app\Models\SitePage.php',
'app\Http\Controllers\Admin\SiteSettingsController.php',
'app\Http\Controllers\Admin\SitePageController.php',
'app\Http\Controllers\SitePageController.php',
'database\migrations\2026_10_19_120000_create_site_settings_and_pages_tables.php',
'resources\views\admin\settings\edit.blade.php',
'resources\views\admin\pages\index.blade.php',
'resources\views\admin\pages\edit.blade.php',
'resources\views\store\static.blade.php'
)
foreach ($relative in $files) {
    $source = Join-Path $patch $relative
    $target = Join-Path $project $relative
    $targetDir = Split-Path -Parent $target
    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
    if (Test-Path $target) {
        $backupTarget = Join-Path $backup $relative
        New-Item -ItemType Directory -Path (Split-Path -Parent $backupTarget) -Force | Out-Null
        Copy-Item $target $backupTarget -Force
    }
    Copy-Item $source $target -Force
}

$routesPath = "$project\routes\web.php"
$routes = Get-Content $routesPath -Raw
if ($routes -notmatch 'AdminSiteSettingsController') {
    $routes = $routes.Replace('use App\Http\Controllers\Admin\ProductController as AdminProductController;', "use App\Http\Controllers\Admin\ProductController as AdminProductController;`r`nuse App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController;`r`nuse App\Http\Controllers\Admin\SitePageController as AdminSitePageController;`r`nuse App\Http\Controllers\SitePageController;")
    $routes = $routes.Replace("Route::view('/contact', 'store.static', ['pageTitle' => 'تماس با ما', 'pageText' => 'برای پشتیبانی از راه‌های ارتباطی فروشگاه استفاده کنید.'])->name('contact');", "Route::get('/contact', [SitePageController::class, 'show'])->defaults('slug', 'contact')->name('contact');")
    $routes = $routes.Replace("Route::view('/about', 'store.static', ['pageTitle' => 'درباره ما', 'pageText' => 'موبیکس هاب، فروشگاه اینترنتی لوازم جانبی موبایل.'])->name('about');", "Route::get('/about', [SitePageController::class, 'show'])->defaults('slug', 'about')->name('about');")
    $routes = $routes.Replace("Route::view('/terms', 'store.static', ['pageTitle' => 'قوانین و مقررات', 'pageText' => 'ثبت سفارش به معنی پذیرش قوانین فروشگاه است.'])->name('terms');", "Route::get('/terms', [SitePageController::class, 'show'])->defaults('slug', 'terms')->name('terms');`r`nRoute::get('/privacy', [SitePageController::class, 'show'])->defaults('slug', 'privacy')->name('privacy');`r`nRoute::get('/shipping', [SitePageController::class, 'show'])->defaults('slug', 'shipping')->name('shipping');`r`nRoute::get('/returns', [SitePageController::class, 'show'])->defaults('slug', 'returns')->name('returns');`r`nRoute::get('/faq', [SitePageController::class, 'show'])->defaults('slug', 'faq')->name('faq');")
    $needle = "        Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');"
    $replacement = $needle + "`r`n        Route::get('/settings', [AdminSiteSettingsController::class, 'edit'])->name('settings.edit');`r`n        Route::put('/settings', [AdminSiteSettingsController::class, 'update'])->name('settings.update');`r`n        Route::get('/pages', [AdminSitePageController::class, 'index'])->name('pages.index');`r`n        Route::get('/pages/{page}/edit', [AdminSitePageController::class, 'edit'])->name('pages.edit');`r`n        Route::put('/pages/{page}', [AdminSitePageController::class, 'update'])->name('pages.update');"
    $routes = $routes.Replace($needle, $replacement)
    [System.IO.File]::WriteAllText($routesPath, $routes, (New-Object System.Text.UTF8Encoding($false)))
}

$layoutPath = "$project\resources\views\admin\layout.blade.php"
$layout = Get-Content $layoutPath -Raw
if ($layout -notmatch "admin.settings.edit") {
    $needle = @'
            <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">▣ &nbsp; سفارش‌ها</a>
'@
    $needle = $needle.TrimEnd()
    $replacement = @'
            <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">▣ &nbsp; سفارش‌ها</a>
            <a class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">▤ &nbsp; صفحات و قوانین</a>
            <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">⚙ &nbsp; تنظیمات فروشگاه</a>
'@
    $replacement = $replacement.TrimEnd()
    $layout = $layout.Replace($needle, $replacement)
    [System.IO.File]::WriteAllText($layoutPath, $layout, (New-Object System.Text.UTF8Encoding($false)))
}

$storeLayoutPath = "$project\resources\views\layouts\store.blade.php"
$storeLayout = Get-Content $storeLayoutPath -Raw
    $storeLayout = $storeLayout.Replace('<meta name="description" content="خرید آنلاین لوازم جانبی موبایل و محصولات کاربردی از موبیکس هاب">', "<meta name=`"description`" content=`"@yield('meta_description', 'خرید آنلاین لوازم جانبی موبایل و محصولات کاربردی از موبیکس هاب')`">")
[System.IO.File]::WriteAllText($storeLayoutPath, $storeLayout, (New-Object System.Text.UTF8Encoding($false)))

Write-Host ''
Write-Host 'فایل‌های تنظیمات و صفحات کپی شدند.' -ForegroundColor Green
Write-Host "نسخه پشتیبان فایل‌های جایگزین‌شده: $backup" -ForegroundColor Yellow
Write-Host 'حالا این دستورها را اجرا کن:' -ForegroundColor Cyan
Write-Host 'cd D:\mobixhub'
Write-Host 'php artisan optimize:clear'
Write-Host 'php artisan migrate'
Write-Host 'php artisan route:list'
