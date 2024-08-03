<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('status', false)->get();

        return view('tasks.index', compact('tasks')); //return view('tasks.index', ['tasks' => $tasks]);でもOK
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'task_name' => 'required|max:100',
            'priority' => 'required|integer|min:0|max:2',
        ];

        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];

        Validator::make($request->all(), $rules, $messages)->validate();

          //モデルをインスタンス化
        $task = new Task;

          //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');
        $task->priority = $request->input('priority');

          //データベースに保存
        $task->save();

          //リダイレクト
        return redirect()->route('tasks.index')->with('success', 'タスクが作成されました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
    /**
     * タスクの詳細を表示
     */
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    /**
     * タスクの編集フォームを表示
     */
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ステータスが存在するかどうかで処理を分岐
        if ($request->has('status')) {
            // 「完了」ボタンを押したときの処理
            $task = Task::findOrFail($id);

            // ステータスを完了に更新
            $task->status = true; //true:完了、false:未完了

            // データベースに保存
            $task->save();
        } else {
            // 「編集する」ボタンを押したときの処理

            // バリデーションルールとメッセージ
            $rules = [
                'task_name' => 'required|max:100',
                'priority' => 'required|integer|min:0|max:2',
            ];

            $messages = [
                'required' => '必須項目です',
                'max' => '最大 :max 文字までです',
                'min' => '最小 :min の値が必要です',
                'integer' => '整数値を入力してください',
            ];

            // バリデーションの実行
            $validatedData = $request->validate($rules, $messages);

            // 該当のタスクを検索
            $task = Task::findOrFail($id);

            // データの更新
            $task->update([
                'name' => $request->input('task_name'),
                'priority' => $request->input('priority'),
            ]);
        }

        //リダイレクト
        return redirect()->route('tasks.index')->with('success', 'タスクが更新されました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();

        return redirect('/tasks');
    }
}
