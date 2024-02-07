@extends('index')
@section('title')
    TMS - Add Feedback
@endsection
@section('content')
    <h1 class="text-center mt-5">Add Feedback Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-10">
                <div class="container d-flex justify-content-end mb-3">
                    <a href="{{ route('feedback') }}" class="btn btn-success">
                        Go Back
                    </a>
                </div>
                <form action="{{ route('add_new_feedback', $project_id) }}" method="POST">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingTitle" placeholder="Your Title"
                            name="title" value="{{ old('title') }}">
                        <label for="floatingTitle">Title</label>
                        @error('title')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="form-floating col-md mb-3">
                        <select class="form-select" id="floatingRating" aria-label="Floating label select example"
                            name="stars">
                            @php
                                $stars = [1, 2, 3, 4, 5];
                            @endphp
                            @foreach ($stars as $star)
                                <option value="{{ $star }}">{{ $star }}</option>
                            @endforeach
                        </select>
                        <label for="floatingRating">Select Stars</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Your Description" id="floatingFeedback" style="height:150px;"
                            name="feedback">{{ old('feedback') }}</textarea>
                        <label for="floatingFeedback">Feedback</label>
                        @error('feedback')
                            <span class="text-danger"><small>{{ $message }}</small></span>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-success">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
