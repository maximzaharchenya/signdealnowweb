@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section id="users" class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Все документы</h3>
            </div>
            <hr>
            <div class="block-body">
                <div class="row">
                    @foreach($documents as $document)
                        <div class="col-3 d-flex mb-3">
                            <a class="w-100" href="/admin/documents/{{ $document->id }}/edit">
                                <div style="background: #F3F3F3;" class="p-3 d-flex align-items-center h-100 w-100">
                                    <p class="mb-0">{{ $document->title }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
