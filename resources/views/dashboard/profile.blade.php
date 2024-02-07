@extends('index')
@section('title')
    TMS - Profile
@endsection
@section('content')
    <h1 class="text-center mt-5">User Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!</strong> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('edit_profile') }}" class="btn btn-success">
                        Update Profile
                    </a>
                </div>
                <table class="table table-success table-striped table-hover table-border">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
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
                            <td>{{ $role_name }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <th>Email Verified</th>
                            @if (!empty($user->email_verified_at))
                                <td class="text-success"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-file-check-fill"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2m-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>&nbsp;Verified</td>
                            @else
                                <td class="text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708" />
                                    </svg>&nbsp;Unverified</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
