<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use PDF;

class DocumentController extends Controller
{
    public function generate(int $deal_id)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal = json_decode($deal);
        return PDF::loadView('pdf.deal_document', compact('deal'))->download('document.pdf');
    }
}
