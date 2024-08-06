<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    /**
     * 一覧を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('status', false)->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * 新しいリソースの作成フォームを表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * 新しいリソースをストレージに保存する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーションルール
        $rules = [
            'task_name' => 'required|max:100',
            'priority' => 'required|integer|between:0,2',
            'username' => 'required|string|max:100',
        ];

        // エラーメッセージ
        $messages = [
            'required' => '必須項目です',
            'max' => '100文字以下にしてください。',
            'priority.between' => '優先順位は★から★★★の間で選択してください。',
        ];

        // バリデーション実行
        $request->validate($rules, $messages);

        // モデルをインスタンス化
        $task = new Task;

        // モデルに値を設定
        $task->name = $request->input('task_name');
        $task->priority = $request->input('priority');
        $task->username = $request->input('username');

        // データベースに保存
        $task->save();

        // トップ画面にリダイレクト
        return redirect('/tasks');
    }

    /**
     * 指定されたリソースを表示する
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {

    }

    /**
     * 指定されたリソースの編集フォームを表示する
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * 指定されたリソースをストレージで更新する
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 編集する場合と完了にする場合で処理を分ける
        if ($request->input('status') === null) {
            // 編集する場合
            $rules = [
                'task_name' => 'required|max:100',
                'priority' => 'required|integer|between:0,2',
                'username' => 'required|string|max:100',
            ];

            $messages = [
                'required' => '必須項目です',
                'max' => '100文字以下にしてください。',
                'priority.between' => '優先順位は★から★★★の間で選択してください。',
            ];

            $request->validate($rules, $messages);

            // 該当のタスクを検索
            $task = Task::findOrFail($id);

            // モデルに値を設定
            $task->name = $request->input('task_name');
            $task->priority = $request->input('priority');
            $task->username = $request->input('username');

            // データベースに保存
            $task->save();
        } else {
            // 完了ボタンが押された場合
            // 該当のタスクを検索
            $task = Task::findOrFail($id);

            // モデルに値を設定
            $task->status = true; // true:完了、false:未完了

            // データベースに保存
            $task->save();
        }

        // リダイレクト
        return redirect('/tasks');
    }

    /**
     * 指定されたリソースをストレージから削除する
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();

        return redirect('/tasks');
    }

    /**
     * ユーザー名でフィルタリングしたタスクを表示する
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function filterByUsername($username)
    {
        $tasks = Task::where('username', $username)->get();

        return view('tasks.filterByUsername', ['tasks' => $tasks, 'username' => $username]);
    }
}
