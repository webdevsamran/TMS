@extends('index')
@section('title')
    TMS - Edit Task
@endsection
@section('content')
    <h1 class="text-center mt-5">Edit Task Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('task') }}" class="btn btn-success">
                        Go Back
                    </a>
                </div>
                <form action="{{ route('update_task', $task->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="manager_id" value="{{ auth()->id() }}">
                    <div class="row gap-2">
                        <div class="form-floating col-md mb-3">
                            <select class="form-select" id="floatingProject" aria-label="Floating label select example"
                                name="project_id" onchange="update_developer()">
                                <option value="{{ $task->project_id }}" data-developer-ids='{{ $project->developer }}'
                                    data-developer-names='{{ json_encode($project->developer_names) }}'
                                    data-starting-date='{{ $project->starting_date }}'
                                    data-ending-date='{{ $project->ending_date }}'>
                                    {{ $project->name }}
                                </option>
                            </select>
                            <label for="floatingProject">Select Project</label>
                            @error('project_id')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                        <div class="form-floating col-md mb-3">
                            <select class="form-select" id="floatingDeveloper" aria-label="Floating label select example"
                                name="developer_id">
                            </select>
                            <label for="floatingDeveloper">Select Developer</label>
                            @error('developer_id')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="John Peter..."
                            name="name" value="{{ $task->name }}">
                        <label for="floatingName">Task Name</label>
                        @error('name')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="row gap-2">
                        <div class="form-floating col-md mb-3">
                            <input type="date" class="form-control" id="floatingStartDate" name="starting_date"
                                value="{{ $task->starting_date }}">
                            <label for="floatingStartDate">Staring Date</label>
                            @error('starting_date')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                        <div class="form-floating col-md mb-3">
                            <input type="date" class="form-control" id="floatingEndDate" name="ending_date"
                                value="{{ $task->ending_date }}">
                            <label for="floatingEndDate">Ending Date</label>
                            @error('starting_date')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingStatus" aria-label="Floating label select example"
                            name="status">
                            @php
                                $status_array = ['To Do', 'In Progress', 'Completed'];
                            @endphp
                            @foreach ($status_array as $key => $status)
                                <option value="{{ $key }}" {{ $key == $task->status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <label for="floatingStatus">Select Manager</label>
                        @error('manager')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Your Description" id="floatingDescription" style="height:100px;"
                            name="description">{{ $task->description }}</textarea>
                        <label for="floatingDescription">Description</label>
                        @error('description')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-success">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function set_developer() {
            let project = document.getElementById("floatingProject");
            let starting_date = document.getElementById("floatingStartDate");
            let ending_date = document.getElementById("floatingEndDate");
            let developer = document.getElementById("floatingDeveloper");
            developer.innerHTML = '';
            let selected_option = project.options[project.selectedIndex];
            let start_date = selected_option.getAttribute("data-starting-date");
            let end_date = selected_option.getAttribute("data-ending-date");
            let developer_id = selected_option.getAttribute("data-developer-ids");
            developer_id = developer_id.split(',');
            let developer_name = JSON.parse(selected_option.getAttribute("data-developer-names"));
            developer_name = developer_name.split(',');
            for (let i = 0; i < developer_id.length; i++) {
                developer.innerHTML += "<option value='" + developer_id[i] + "'> " + developer_name[i] + " </option>";
            }
            starting_date.min = start_date;
            starting_date.max = end_date;
            ending_date.min = start_date;
            ending_date.max = end_date;
        }
        set_developer();
    </script>
@endsection
