@extends('layouts.tasks')

@section('task')
    <div class="card-header">Create A New Task</div>
    <div class="card-body">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description"
                          class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                          name="description"
                          rows="3" required autofocus
                ></textarea>
                @if ($errors->has('description'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <label for="due">Due</label>
                <input id="due" type="datetime-local" class="form-control{{ $errors->has('due') ? ' is-invalid' : '' }}" name="due" value="{{ old('due')  }}" required>
                @if ($errors->has('due'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('due') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="assignedUsers">Assign Users</label>
                <select multiple class="form-control{{ $errors->has('assignedUsers') ? ' is-invalid' : '' }}" id="assignedUsers" name="assignedUsers[]" required>
                    @foreach(\App\User::all() as $user)
                       {{ $user->id }}
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->totalTasks() }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
            </div>
            <a href="{{ route('tasks.index') }}">Back to todos list</a>
        </form>
    </div>
@endsection
