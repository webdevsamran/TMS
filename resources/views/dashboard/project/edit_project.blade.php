@extends('index')
@section('title')
    TMS - Edit Project
@endsection
@section('content')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <h1 class="text-center mt-5">Edit Project Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('project') }}" class="btn btn-success">
                        Go Back
                    </a>
                </div>
                <form action="{{ route('edit_new_project', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="John Peter..."
                            name="name" value="{{ $project->name }}">
                        <label for="floatingName">Project Name</label>
                        @error('name')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingManager" aria-label="Floating label select example"
                            name="manager">
                            @foreach ($users as $user)
                                @if ($user->role == 1)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $project->manager ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="floatingManager">Select Manager</label>
                        @error('manager')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingDeveloper" aria-label="Floating label select example"
                            name="developer[]" multiple>
                            @php
                                $developers = explode(',', $project->developer);
                            @endphp
                            @foreach ($users as $user)
                                @if ($user->role == 0)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, $developers) ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('developer')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="documents[]" multiple>
                        @error('documents')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                        <p><small class="text-warning">If you Upload Files Here, All your previous Files will be
                                gone</small></p>
                    </div>
                    <div class="row gap-2">
                        <div class="form-floating col-md mb-3">
                            <input type="date" class="form-control" id="floatingStartDate" name="starting_date"
                                value="{{ $project->starting_date }}">
                            <label for="floatingStartDate">Staring Date</label>
                            @error('starting_date')
                                <span class="text-danger"><small>{{ $message }}</small></span>
                            @enderror
                        </div>
                        <div class="form-floating col-md mb-3">
                            <input type="date" class="form-control" id="floatingEndDate" name="ending_date"
                                value="{{ $project->ending_date }}">
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
                                <option value="{{ $key }}" {{ $key == $project->status ? 'selected' : '' }}>
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
                            name="description">{{ $project->description }}</textarea>
                        <label for="floatingDescription">Description</label>
                        @error('description')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-success">Edit Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        new MultiSelectTag('floatingDeveloper', {
            rounded: true,
            shadow: false,
            placeholder: 'Select Developer',
            tagColor: {
                textColor: '#327b2c',
                borderColor: '#92e681',
                bgColor: '#eaffe6',
            },
            onChange: function(values) {
                console.log(values)
            }
        });
    </script>
@endsection
