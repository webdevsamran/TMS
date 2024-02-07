@extends('index')
@section('title')
    TMS - Add User
@endsection
@section('content')
    <h1 class="text-center mt-5">Add User Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('user') }}" class="btn btn-success">
                        Go Back
                    </a>
                </div>
                <form action="{{ route('add_new_user') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingName" placeholder="John Peter..."
                            name="name" value="{{ old('name') }}">
                        <label for="floatingName">Name</label>
                        @error('name')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingEmail" placeholder="john2000@example.com"
                            name="email" value="{{ old('email') }}">
                        <label for="floatingEmail">Email</label>
                        @error('email')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="password"
                            name="password" value="{{ old('password') }}">
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingRole" aria-label="Floating label select example"
                            name="role">
                            <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Developer</option>
                            <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Manager</option>
                            <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Admin</option>
                        </select>
                        <label for="floatingRole">Select Role</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Your Address" id="floatingAddress" style="height:100px;" name="address">{{ old('address') }}</textarea>
                        <label for="floatingAddress">Address</label>
                        @error('address')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-success">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
