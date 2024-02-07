@extends('index')
@section('title')
    TMS - User
@endsection
@section('content')
    <h1 class="text-center mt-5">User Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!</strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('add_user') }}" class="btn btn-success">
                        Add User
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr. No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($users))
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @php
                                        $role_name = '';
                                        if ($user->role == 0) {
                                            $role_name = 'Developer';
                                        } elseif ($user->role == 1) {
                                            $role_name = 'Manager';
                                        } elseif ($user->role == 2) {
                                            $role_name = 'Admin';
                                        }
                                    @endphp
                                    <td>
                                        {{ $role_name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('edit_user', $user->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>&nbsp;
                                        <a href="{{ route('delete_user', $user->id) }}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>

                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-danger text-center">No User Found</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                @if (!empty($users))
                    <div class="container d-flex flex-row justify-content-center">
                        {{ $users->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
