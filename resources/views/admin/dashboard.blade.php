@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section id="dashboard" class="d-flex">
        @include('admin.partial.left-nav')
    </section>
@endsection
