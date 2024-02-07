@extends('index')
@section('title')
    TMS - Add User
@endsection
@section('content')
    <h1 class="text-center mt-5">Update Profile Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('profile') }}" class="btn btn-success">
                        Go Back
                    </a>
                </div>
                <form action="{{ route('update_profile', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="old_email" value="{{ $user->email }}">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="John Peter..."
                            name="name" value="{{ $user->name }}">
                        <label for="floatingName">Name</label>
                        @error('name')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" placeholder="john2000@example.com"
                            name="email" value="{{ $user->email }}">
                        <label for="floatingEmail">Email</label>
                        @error('email')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="password"
                            name="password" value="">
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Your Address" id="floatingAddress" style="height:100px;" name="address">{{ $user->address }}</textarea>
                        <label for="floatingAddress">Address</label>
                        @error('address')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
