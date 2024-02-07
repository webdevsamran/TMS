@extends('index')
@section('title')
    TMS - Contribution
@endsection
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <h1 class="text-center mt-5">Contribution Section</h1>
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
                            <th scope="col">Task Name</th>
                            <th scope="col">Total Contribution</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
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
                                    <td>{{ $task->name }}</td>
                                    <td>{{ count($task->contribution) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->starting_date)->isoFormat('MMM Do YYYY') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->ending_date)->isoFormat('MMM Do YYYY') }}</td>
                                    <td>
                                        @if ($task->status != 2 and auth()->user()->role == 0)
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#add_contribution_{{ $task->id }}">Add
                                                Contribution</button>
                                        @endif
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#see_contribution_{{ $task->id }}">See Contribution</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="add_contribution_{{ $task->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Contribution</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="add_contribution_form_{{ $task->id }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control"
                                                            id="floatingTitle_{{ $task->id }}"
                                                            placeholder="Title of Contribution" name="title"
                                                            value="{{ old('title') }}">
                                                        <label for="floatingTitle_{{ $task->id }}">Title</label>
                                                        @error('title')
                                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" placeholder="Your Description" id="floatingDescription_{{ $task->id }}"
                                                            style="height:100px;" name="description">{{ old('description') }}</textarea>
                                                        <label
                                                            for="floatingDescription_{{ $task->id }}">Description</label>
                                                        @error('description')
                                                            <span class="text-danger"><small>{{ $message }}</small></span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="d-grid gap-2 col-6 mx-auto">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="submit_contribution({{ $task->id }})">Add
                                                            Contribution</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade modal-dialog-scrollable modal-xl"
                                    id="see_contribution_{{ $task->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-danger text-center">No Task Found For Contribution</td>
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
    <script>
        function submit_contribution(id) {
            let formData = $(`#add_contribution_form_${id}`).serialize()
            $.ajax({
                url: `/add_contribution/${id}`,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    alert('Contribution Added');
                },
                error: function(error) {
                    console.log(error);
                    alert('Contribution Failed');
                }
            })
        }
    </script>
@endsection
