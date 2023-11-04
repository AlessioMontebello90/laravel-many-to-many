@extends('layouts.app')

@section('content')
    <div class="container my-5 text-center">
        <a class="navbar-brand btn btn-primary " href="{{ route('admin.projects.index') }}">lista dei progetti</a>
    </div>

    <section class="container mt-5">
        <h1>{{ $title }}</h1>
    </section>
@endsection
