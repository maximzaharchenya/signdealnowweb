@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <h1>Smart ID</h1>

                <form id="smart-id-form" method="post" action="/smart-id">

                @csrf

                    <div class="form-group">
                        <label for="identity_type">Identity Type</label>
                        <select class="form-control" id="identity_type" name="identity_type">
                            <option value="PNO">Personal number</option>
                            <option value="PAS">Passport number</option>
                            <option value="IDC">National identity card number</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="country_code">Country code</label>
                        <input type="text" class="form-control" placeholder="Country code" id="country_code" name="country_code" value="EE" required>
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
