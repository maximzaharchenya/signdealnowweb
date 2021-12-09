@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <h1>Mobil ID</h1>

                <form id="smart-id-form" method="post" action="/mobile-id">

                @csrf

                <!--                    <div class="form-group">
                        <label for="country_code">Country code</label>
                        <input type="text" class="form-control" placeholder="Country code" id="country_code" value="EE" required>
                    </div>-->

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="id_code">ID-code</label>
                        <input type="text" class="form-control" id="id_code" name="id_code" placeholder="ID-code" required>
                    </div>

                    <button class="btn btn-primary" type="submit">Authenticate</button>

                    <h2 id="verification_code_element" class="pt-3"></h2>
                    <small id="loading_element"></small>

                    <div class="text-danger" id="error_message_element"></div>

                </form>
            </div>
        </div>

    </div>

@endsection
