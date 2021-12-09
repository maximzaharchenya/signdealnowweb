<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

Broadcast::channel('room.{document_id}', function ($user, $document_id) {
    if(DB::table('documents_users')->where('document_id', $document_id)->where('user_id', $user->id)->exists()) return [
        'name' => $user->name,
        'id' => $user->id,
    ];
    return false;
});
