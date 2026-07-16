@extends('admin.layout')
@section('title', 'Dashboard — QuickCredit Admin')

@section('content')

{!! '<style>
    .dashboard-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        text-align: center;
    }
    .dashboard-illustration {
        max-width: 250px;
        width: 100%;
        margin-bottom: 2rem;
        opacity: 0.9;
    }
</style>' !!}

<div class="dashboard-empty-state">
    <img src="{{ asset('images/illustration.png') }}" alt="Dashboard Illustration" class="dashboard-illustration">
</div>

@endsection
