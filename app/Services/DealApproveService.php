<?php

namespace App\Services;


use App\Models\Document;

class DealApproveService
{
    public function unapproved(int $deal_id): bool
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $users = $deal->users()->get();
        foreach ($users as $user) {
            $deal->users($user)->update(['approved' => 0]);
        }
        return true;
    }

    public function sign_unapproved(int $deal_id): bool
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $users = $deal->users()->get();
        foreach ($users as $user) {
            $deal->users($user)->update(['sign_approved' => 0]);
        }
        return true;
    }
}
