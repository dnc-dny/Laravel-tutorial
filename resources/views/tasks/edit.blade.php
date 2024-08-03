
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todoアプリ-タスク編集</title>

    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-[100vh]">
    <header class="bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="py-6">
                <p class="text-white text-xl">Todoアプリ-編集画面</p>
            </div>
        </div>
    </header>

    <main class="grow grid place-items-center">
        <div class="w-full mx-auto px-4 sm:px-6">
            <div class="py-[100px]">
                <h1 class="text-2xl font-bold mb-6">タスク編集</h1>

                    <!-- Display Errors -->
                    @if ($errors->any())
                        <div class="mb-6 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <form action="{{ route('tasks.update', $task) }}" method="POST" class="mt-10">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center space-y-8">

                        <!-- タスク名 -->
                        <label for="name" class="w-full max-w-3xl mx-auto">
                            <p class="text-lg font-normal">～タスク名～</p>
                            <input
                                class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm"
                                type="text" name="task_name" id="name" value="{{ old('name', $task->name) }}" placeholder="タスク名" required />
                            @error('task_name')
                                <div class="mt-3">
                                    <p class="text-red-500">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                        </label>

                        <!-- 優先順位 -->
                        <label for="priority" class="w-full max-w-3xl mx-auto mt-8">
                            <p class="text-lg font-normal">～優先順位～</p>
                            <select
                                class="block bg-white w-full border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm"
                                name="priority" id="priority">
                                <option value="0" {{ $task->priority == 0 ? 'selected' : '' }}>★</option>
                                <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>★★</option>
                                <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>★★★</option>
                            </select>
                        </label>

                        <div class="mt-8 w-full flex items-center justify-center gap-10">
                            <a href="/tasks" class="block shrink-0 underline underline-offset-2">
                                戻る
                            </a>
                            <button type="submit"
                                class="p-4 bg-sky-800 text-white w-full max-w-xs hover:bg-sky-900 transition-colors">
                                編集する
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
    <footer class="bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="py-4 text-center">
                <p class="text-white text-sm">Todoアプリ</p>
            </div>
        </div>
    </footer>
</body>

</html>
