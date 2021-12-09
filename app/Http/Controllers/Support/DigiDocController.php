<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DigiDocController extends Controller
{
    public function index()
    {
        return view('support.digi_doc');
    }

    public function test()
    {
        $document = Document::whereNotNull('document_file')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('skid_transactions')
                    ->whereColumn('skid_transactions.document_id', 'documents.id');
            })->first();

        if(empty($document)) return response()->json('Cant find suitable document');

        dump('Document:');
        dump($document);

        $transitions = DB::table('skid_transactions')->where('document_id', $document->id)->get();

        dump('Transitions: ');
        dump($transitions);

        dd('End');
    }
}
