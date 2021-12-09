@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <h1>Mobil ID</h1>

                <form method="post" action="/mobile-id/signing" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="id_code">ID-code</label>
                        <input type="text" class="form-control" id="id_code" name="id_code" placeholder="ID-code" required>
                    </div>

                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" id="file" name="file" placeholder="File" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Sign</button>
                </form>
            </div>
        </div>

    </div>

@endsection
