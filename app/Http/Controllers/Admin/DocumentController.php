<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Input;
use App\Services\CadastralNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use PDF;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('admin.documents.index')->with('documents', $documents);
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['title'])) {
            $data['title'] = Str::random(10) . '.docx';
        }
        if (empty($data['status'])) {
            $data['status'] = Str::random(10);
        }

        if (!empty($data['cadastral_number'])) {
            $cadastralNumberService = new CadastralNumberService();
            $cadastralNumberData = $cadastralNumberService->getData($data['cadastral_number']);
            if (!empty($cadastralNumberData)) $data['cadastral_number_data'] = json_encode($cadastralNumberData);
            else $data['cadastral_number_data'] = null;
        }

        $document = Document::create($data);
        $document->users()->attach(Auth::user(), ['user_role' => 1]);
        return redirect('/admin/documents');
    }

    public function edit(Document $document)
    {
        $document = Document::where('id', $document['id'])->with('users')->first();
        $users = User::all();
        return view('admin.documents.edit')->with('document', $document)->with('users', $users);
    }

    public function update(Document $document, Request $request)
    {
        $data = $request->all();
        if (empty($data['title'])) {
            $data['title'] = Str::random(10) . '.docx';
        }
        if (empty($data['status'])) {
            $data['status'] = Str::random(10);
        }

        if (!empty($data['cadastral_number'])) {

            $cadastralNumberService = new CadastralNumberService();
            $cadastralNumberData = $cadastralNumberService->getData($data['cadastral_number']);
            if (!empty($cadastralNumberData)) $data['cadastral_number_data'] = json_encode($cadastralNumberData);
            else $data['cadastral_number_data'] = null;
        }

        $document->update($data);
        return redirect('/admin/documents');
    }

    public function delete(Document $document)
    {
        $document->users()->detach();
        $document->delete();
        return redirect('/admin/documents');
    }

    public function user_create(Document $document, Request $request)
    {
        $data = $request->all();
        if (!$document->users()->where('user_id', $data['user_id'])->exists()) {
            $document->users()->attach(['user_id' => $data['user_id']], ['user_role' => $data['user_role']]);
        }
        return redirect('/admin/documents/' . $document['id'] . '/edit');
    }

    public function user_update(Document $document, Request $request)
    {
        $data = $request->all();
        $document->users()->updateExistingPivot($data['user_id'], ['user_role' => $data['user_role']]);
        return redirect('/admin/documents/' . $document['id'] . '/edit');
    }

    public function user_delete(Document $document, User $user)
    {
        $document->users()->detach($user['id']);
        return redirect('/admin/documents/' . $document['id'] . '/edit');
    }

    public function input_create(Document $document, Request $request){
        Input::create($request->all());
        return redirect('/admin/documents/'.$document['id'].'/edit');
    }

    public function generate_document(Document $document)
    {
        $first_block = $document->inputs()->latest()->where('position', 1)->first();
        $second_block = $document->inputs()->latest()->where('position', 2)->first();
        $pdf = PDF::loadView('pdf.document', compact('first_block', 'second_block'));
        return $pdf->download('document.pdf');
    }
}
