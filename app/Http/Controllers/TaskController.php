<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()

    {
        return view('task.index');
    }

    public function add()
    {
        return view('task/add');
    }
    public function postAdd(Request $request)
    {
        $request->validate([
            'title' => "required",
            'description' => "required"
        ]);
        // dd($request->only('title', 'description'));
        if ($request->isMethod('post')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);
            $modelTask = new Task();
            $res = $modelTask->saveNew($param);

            if ($res == null) {
                return redirect()->route('post.add.task');
            } elseif ($res > 0) {
                Session::flash('success', 'Thêm mới hành công');
                return redirect()->route('list.task');
            } else {
                Session::flash('error', 'Thêm mới thất bại');
                return redirect()->route('post.add.task');
            }
        }
    }
    public function list()
    {
        $this->v['title'] = "Admin";
        $task = new Task();
        $res = $task->loadListWithPager();
        $this->v['res'] = $res;
        return view('Task.index',  $this->v);
    }
    public function delete($id)
    {
        Task::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Done');
    }

    public function test()
    {
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.layout');
    }
    public function detail($id)
    {
        $item = new Task();
        $objI = $item->loadOne($id);
        $this->v['objI'] = $objI;
        // dd($objI);
        return view('task.edit', $this->v);
    }
    public function update(Request $request, $id)
    {
        $param = [];
        $param['cols'] = $request->only('title', 'description');
        $task = new Task();
        $item = $task->loadOne($id);
        $param['cols']['id'] = $id;
        $res  = $task->saveUpdate($param);
        if ($res == null) {
            return redirect()->back()->with('erros', 'không tồn tại bản ghi' . $item->id);
        } elseif ($res == 1) {
            Session::flash('success', 'Cập nhật bản ghi ' . $item->id . ' thành công');
            return redirect()->route('list.task');
        } else {
            Session::flash('error', 'Cập nhật bản ghi ' . $item->id . ' thất bại');
            return redirect()->back();
        }
    }
}