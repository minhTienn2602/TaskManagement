<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

class TaskController extends Controller
{
    public function index()
    {
        // Lấy danh sách công việc từ cơ sở dữ liệu
        $tasks = Task::all();
        $categories = Category::all();

        // Trả về view index với dữ liệu các công việc và categories
        return view('tasks.index', [
            'tasks' => $tasks,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        // Lấy danh sách categories từ cơ sở dữ liệu
        $categories = Category::all();

        // Trả về view create với dữ liệu categories
        return view('tasks.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Chỉ xử lý lưu trữ dữ liệu mà không cần validate
        Task::create($request->all());

        // Chuyển hướng về trang index sau khi tạo công việc thành công
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function detail($id)
    {
        // Lấy thông tin của công việc cần hiển thị chi tiết
        $task = Task::findOrFail($id);
    
        // Trả về view detail với dữ liệu của công việc
        return view('tasks.detail', ['task' => $task]);
    }
    
    public function edit($id)
    {
        // Lấy thông tin của công việc cần chỉnh sửa
        $task = Task::findOrFail($id);

        // Lấy danh sách categories từ cơ sở dữ liệu
        $categories = Category::all();

        // Trả về view edit với dữ liệu của công việc và categories
        return view('tasks.edit', ['task' => $task, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Nếu trạng thái không phải FINISHED, đặt finished_date thành null
         if ($request->status !== 'FINISHED') {
            $request->merge(['finished_date' => null]);
        }

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
   

    public function destroy($id)
    {
        // Tìm và xóa công việc theo ID
        $task = Task::findOrFail($id);
        $task->delete();

        // Chuyển hướng về trang index sau khi xóa công việc thành công
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}