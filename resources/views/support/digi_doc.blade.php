@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <h1>Digi Doc</h1>

                <form id="smart-id-form" method="post" action="/digi-doc">

                @csrf

<!--                    <div class="form-group">
                        <label for="document">Document</label>
                        <input type="file" class="form-control" id="document" name="document" placeholder="document">
                    </div>

                    <div class="form-group">
                        <label for="signature">Signature</label>
                        <input type="text" class="form-control" id="signature" name="signature" placeholder="signature">
                    </div>-->

                    <button class="btn btn-primary" type="submit">Proceed</button>
                </form>
            </div>
        </div>

    </div>

@endsection
