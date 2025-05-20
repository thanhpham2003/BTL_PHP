<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Services\Contact\ContactAdminService;
use App\Http\Services\Review\ReviewAdminService;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ContactAdminService $contactAdminService, ReviewAdminService $reviewAdminService): void
    {
        // Nếu đang chạy artisan (ví dụ: migrate), không chạy truy vấn tránh lỗi bảng chưa có
        if (App::runningInConsole()) {
            return;
        }

        // Kiểm tra bảng tồn tại trước khi gọi truy vấn
        if (Schema::hasTable('reviews') && Schema::hasTable('contacts') && Schema::hasTable('orders')) {
            $reviewAdminCount = $reviewAdminService->getReviewAdminCount();
            $messageCount = $contactAdminService->getMessageCount();
            $orderCount = Order::where('status', 'pending')->count();
        } else {
            // Bảng chưa tồn tại, gán mặc định 0 tránh lỗi
            $reviewAdminCount = 0;
            $messageCount = 0;
            $orderCount = 0;
        }

        View::composer('*', function ($view) use ($messageCount, $reviewAdminCount, $orderCount) {
            $view->with('messageCount', $messageCount);
            $view->with('reviewAdminCount', $reviewAdminCount);
            $view->with('orderCount', $orderCount);
        });
    }
}
