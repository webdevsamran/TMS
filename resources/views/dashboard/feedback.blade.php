@extends('index')
@section('title')
    TMS - Feedback
@endsection
@section('content')
    <h1 class="text-center mt-5">Feedback Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!</strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <table class="table m-3">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No</th>
                            <th scope="col">Project Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($projects))
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->starting_date)->isoFormat('MMM Do YYYY') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->ending_date)->isoFormat('MMM Do YYYY') }}</td>
                                    @php
                                        $project_status = '';
                                        if ($project->status == 0) {
                                            $project_status = 'To Do';
                                        } elseif ($project->status == 1) {
                                            $project_status = 'In Progress';
                                        } elseif ($project->status == 2) {
                                            $project_status = 'Completed';
                                        }
                                    @endphp
                                    <td class="fw-bold">{{ $project_status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#project_modal_{{ $project->id }}">
                                            View Project
                                        </button>&nbsp;
                                        <a href="{{ route('give_feedback', $project->id) }}"
                                            class="btn btn-sm btn-success">Give Feedback</a>
                                    </td>
                                </tr>
                                <div class="modal fade modal-dialog-scrollable modal-xl"
                                    id="project_modal_{{ $project->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ $project->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3 style="text-align:left!important;width:100%;">Details</h3>
                                                <p><b>Manager: </b> {{ $project->manager_name }}</p>
                                                <p><b>Developer: </b>
                                                    @php
                                                        $developers = explode(',', $project->developer_names);
                                                    @endphp
                                                <ol>
                                                    @foreach ($developers as $developer)
                                                        <li>{{ $developer }}</li>
                                                    @endforeach
                                                </ol>
                                                </p>
                                                <p><b>Starting Date: </b>
                                                    {{ \Carbon\Carbon::parse($project->starting_date)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                                <p><b>Ending Date: </b>
                                                    {{ \Carbon\Carbon::parse($project->ending_date)->isoFormat('MMM Do YYYY') }}
                                                </p>
                                                <p><b>Files: </b>
                                                    @php
                                                        $total_files = explode(',', $project->file);
                                                        $files_count = count($total_files);
                                                    @endphp
                                                    {{ $files_count }}
                                                <ol>
                                                    @foreach ($total_files as $each_file)
                                                        {{-- {{ $each_file }} --}}
                                                        <li><a download="/projects/{{ $each_file }}"
                                                                href="/projects/{{ $each_file }}"
                                                                title="{{ $each_file }}">{{ $each_file }}</a></li>
                                                    @endforeach
                                                </ol>
                                                </p>
                                                <p><b>Status: </b>
                                                    @php
                                                        $project_status = '';
                                                        if ($project->status == 0) {
                                                            $project_status = 'To Do';
                                                        } elseif ($project->status == 1) {
                                                            $project_status = 'In Progress';
                                                        } elseif ($project->status == 2) {
                                                            $project_status = 'Completed';
                                                        }
                                                    @endphp
                                                    {{ $project_status }}
                                                </p>
                                                <p><b>Description: </b>{{ $project->description }}</p>
                                                <h3 style="width: 100%;text-align:start;"><b>Tasks:
                                                        {{ count($project->task) }}</b></h3>
                                                @foreach ($project->task as $task)
                                                    <div class="card" style="width: 100%;">
                                                        <div class="card-body">
                                                            <p><b>Name: </b>{{ $task->name }}</p>
                                                            <p><b>Starting Date:
                                                                </b>{{ \Carbon\Carbon::parse($task->starting_date)->isoFormat('MMM Do YYYY') }}
                                                            </p>
                                                            <p><b>Ending Date:
                                                                </b>{{ \Carbon\Carbon::parse($task->ending_date)->isoFormat('MMM Do YYYY') }}
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
                                                            <p>{{ $task->description }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <h3 style="width: 100%;text-align:start;">Feedbacks:
                                                    {{ count($project->feedback) }}</h3>
                                                @foreach ($project->feedback as $feedback)
                                                    <div class="card" style="width: 100%;">
                                                        <div class="card-body">
                                                            <p>
                                                                {{ $feedback->user_name }}
                                                            </p>
                                                            <p>
                                                                @for ($i = 0; $i < $feedback->stars; $i++)
                                                                    &#9733;&nbsp;
                                                                @endfor
                                                            </p>
                                                            <p><b>Posted On:
                                                                </b>{{ \Carbon\Carbon::parse($feedback->created_at)->isoFormat('MMM Do YYYY') }}
                                                            </p>
                                                            <p><b>Title: </b>{{ $feedback->title }}</p>
                                                            <p>{{ $feedback->feedback }}</p>
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
                                <td colspan="6" class="text-danger text-center">No Project Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if (!empty($projects))
                    <div class="container d-flex flex-row justify-content-center">
                        {{ $projects->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
