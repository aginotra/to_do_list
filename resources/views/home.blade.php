@extends('layouts.app')

@section('content')
<div class="container">
            <h3>Pending task of last 1 hour:</h3>

    <div class="row justify-content-center">
        <div style="width: 750px; height: 350px;">
        {!! $chart->container() !!}
        </div>
        <div class="col-md-8"> 
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <div class="card card-new-task">
                <div class="card-header">New Task</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('home.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                            @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    <table class="table table-striped">
                        @foreach ($tasks as $task)
                        <tr>
                            <td>
                                @if ($task->is_complete)
                                <s>{{ $task->title }}</s>
                                @else
                                {{ $task->title }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if (! $task->is_complete)
                                <form method="POST" action="{{ route('home.update',$task->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" value="{{$task->id}}" name="taskId"/>
                                    <button type="submit" class="btn btn-primary">Complete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {!! $chart->script() !!}

@endsection
