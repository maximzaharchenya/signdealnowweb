@extends('layouts.app')

@section('content')
    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div>
            <h1 class="py-2">Testing jitsi</h1>

<!--            <a href="{{ url('jitsi/create') }}" class="btn btn-primary w-100">Create room</a>

            <div style="width: 700px; height: 700px; position: relative">
                <iframe allow="camera; microphone; fullscreen; display-capture; autoplay" src="https://jitsi.signdealnow.eu/some123" style="height: 100%; width: 100%; border: 0px;"></iframe>
            </div>-->

            <div id="meet">

            </div>

        </div>
    </div>



    <script src='https://jitsi.signdealnow.eu/external_api.js'></script>
    <script>
        const domain = 'jitsi.signdealnow.eu';
        const options = {
            roomName: 'Meeting1',
            width: 700,
            height: 700,
            parentNode: document.querySelector('#meet')
        };
        const api = new JitsiMeetExternalAPI(domain, options);
    </script>
@endsection
