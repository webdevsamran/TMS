@extends('index')
@section('title')
    TMS - Dashboard
@endsection
@section('content')
    <style>
        .custom-height-col {
            height: 250px;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
    <h1 class="text-center mt-5">Dashboard Section</h1>
    <div class="container mb-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card custom-height-col">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <p>Total Projects </p>
                        <h2>{{ $totalProjects }}</h2>
                        <p>Completed Projects</p>
                        <h2>{{ $completedProjects }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-height-col">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <p>Total Tasks </p>
                        <h2>{{ $totalTasks }}</h2>
                        <p>Completed Tasks</p>
                        <h2>{{ $completedTasks }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-height-col">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <p>Total Contributions</p>
                        <h2>{{ $totalContributions }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
