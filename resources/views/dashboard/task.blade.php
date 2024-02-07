@extends('index')
@section('title')
    TMS - Task
@endsection
@section('content')
    <h1 class="text-center mt-5">Task Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!</strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (auth()->user()->role == 1)
                    <div class="container d-flex justify-content-end mb-3">
                        <a href="{{ route('add_task') }}" class="btn btn-success">
                            Add Task
                        </a>
                    </div>
                @endif
                <table class="table m-3">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No</th>
                            <th scope="col">Project Name</th>
                            <th scope="col">Task Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($tasks))
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $task->project->name }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->starting_date)->isoFormat('MMM Do YYYY') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->ending_date)->isoFormat('MMM Do YYYY') }}</td>
                                    @php
                                        $task_status = '';
                                        if ($task->status == 0) {
                                            $task_status = 'To Do';
                                        } elseif ($task->status == 1) {
                                            $task_status = 'In Progress';
                                        } elseif ($task->status == 2) {
                                            $task_status = 'Completed';
                                        }
                                    @endphp
                                    <td class="fw-bold">{{ $task_status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#task_modal_{{ $task->id }}">
                                            View Task
                                        </button>&nbsp;
                                        @if ($task->status != 2 and auth()->user()->role == 1)
                                            <a href="{{ route('edit_task', $task->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>&nbsp;
                                            <a href="{{ route('delete_task', $task->id) }}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade modal-dialog-scrollable modal-xl"
                                    id="task_modal_{{ $task->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="exampleModalLabel">{{ $task->name }}
                                                </h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><b>Manager: </b> {{ $task->manager->name }}</p>
                                                <p><b>Developer: </b> {{ $task->developer->name }}</p>
                                                <p><b>Starting Date: </b>
                                                    {{ \Carbon\Carbon::parse($task->starting_date)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                                <p><b>Ending Date: </b>
                                                    {{ \Carbon\Carbon::parse($task->ending_date)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                                <p><b>Status: </b>
                                                    @php
                                                        $task_status = '';
                                                        if ($task->status == 0) {
                                                            $task_status = 'To Do';
                                                        } elseif ($task->status == 1) {
                                                            $task_status = 'In Progress';
                                                        } elseif ($task->status == 2) {
                                                            $task_status = 'Completed';
                                                        }
                                                    @endphp
                                                    {{ $task_status }}
                                                </p>
                                                <p><b>Description: </b> {{ $task->description }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <h3 style="width: 100%;text-align:start;"><b>Contributions: </b></h3>
                                                @foreach ($task->contribution as $contribution)
                                                    <div class="card" style="width: 100%;">
                                                        <div class="card-body">
                                                            <h5>{{ $contribution->title }}</h5>
                                                            <p>{{ $contribution->description }}</p>
                                                            <p class="text-end">
                                                                {{ \Carbon\Carbon::parse($contribution->created_at)->isoFormat('MMM Do YYYY') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-danger text-center">No Task Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if (!empty($tasks))
                    <div class="container d-flex flex-row justify-content-center">
                        {{ $tasks->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
