@extends('layouts.tasks')

@section('task')
    <div class="card-header">Todos</div>
        <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <a href="{{ route('tasks.create') }}" class="btn btn-success mb-2">Create a new task</a>
        @if (count($tasks) > 0)
        <table class="table table-striped task-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Due In</th>
                    <th>Assigned Users (total tasks)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td class="table-text">
                        <div>{{ $task->description }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ \Carbon\Carbon::createFromTimeString($task->due)->diffForHumans() }}</div>
                    </td>
                    <td class="table-text">
                        <div>
                            @foreach($task->assignedUsers as $user)
                                {{ $user->name }} ({{ $user->totalTasks() }})<br>
                            @endforeach
                        </div>
                    </td>
                    <td class="table-text">
                        <form action="{{ route('tasks.destroy', ['task' => $task ]) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete" />
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <p>Your all caught up, nothing to do!</p>
        @endif
    </div>
@endsection
