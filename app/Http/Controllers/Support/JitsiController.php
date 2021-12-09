<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use \Firebase\JWT\JWT;

class JitsiController extends Controller
{
    public function index()
    {
        return view('support.jitsi');
    }

    public function create()
    {
        $LINK = "https://jitsi.signdealnow.eu";
        $ROOM = "somedata";

        $key = "vCbpKKCkx5lG40mH";
        $payload = array(
            "aud" => "myapp",
            "iss" => "myapp",
            "sub" => "jitsi.signdealnow.eu",
            "exp" => time() + (60*60),
            "room" => "$ROOM",
            "moderator" => false,
            "context" => array(
                "user" => array(
                    "name" => "Artsem",
                    "email" => "2660117@gmail.com",
                    "avatar" => "https://gravatar.com/avatar/abc123.png"
                )
            )
        );

        $jwt = JWT::encode($payload, $key);

        dump($jwt);
        dd($LINK . '/' . $ROOM . '?jwt=' . $jwt);
    }
}
