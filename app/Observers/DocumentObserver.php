<?php

namespace App\Observers;

use App\Events\DocumentUpdatedEvent;
use App\Models\Document;
use Illuminate\Support\Facades\Log;

class DocumentObserver
{

    public function created(Document $document)
    {
        //
    }


    public function updated(Document $document)
    {
        DocumentUpdatedEvent::dispatch($document);
    }


    public function deleted(Document $document)
    {
        //
    }


    public function restored(Document $document)
    {
        //
    }


    public function forceDeleted(Document $document)
    {
        //
    }
}
