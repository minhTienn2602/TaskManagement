<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckDueDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        // Lấy giá trị của 'due_date' từ request và chuyển đổi sang đối tượng Carbon
        $dueDate = Carbon::parse($request->input('due_date'));
        // Lấy ngày hiện tại
        $currentDate = Carbon::now();

        // Kiểm tra nếu 'due_date' nhỏ hơn ngày hiện tại
        if ($dueDate->lt($currentDate)) {
            // Trả về trang trước với thông báo lỗi và dữ liệu cũ, đồng thời gửi thông báo lỗi đến console
            session()->flash('middleware_message', 'Request blocked by CheckDueDate middleware.');
            return redirect()->back()->withErrors(['due_date' => 'Due Date must be greater than today.']);
        }
        // Nếu 'due_date' hợp lệ, cho phép yêu cầu tiếp tục tới controller
        return $next($request);
    }
}