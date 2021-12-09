<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function canManage($user): bool
    {
        return $user->type == User::ADMIN_TYPE;
    }

    public function userInDeal(User $user, int $document): bool
    {
        $document = Document::where('id', $document)->firstOrFail();
        if ($document->users()->where('user_id', $user->id)->exists()) return true;
        else return false;
    }
}
