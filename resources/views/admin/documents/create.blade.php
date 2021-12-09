@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Добавление документа</h3>
            </div>
            <hr>
            <div class="block-body">
                <form action="/admin/documents/store" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-4 d-flex flex-column">
                            <label for="title">Навание</label>
                            <input type="text" id="title" name="title">
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <label for="status">Статус</label>
                            <input type="text" id="status" name="status">
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <label for="cadastral_number">Кадастровый номер</label>
                            <input type="text" id="cadastral_number" name="cadastral_number">
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
