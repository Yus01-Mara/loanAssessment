<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CSubElement;
use App\Models\CElement;

class SubElementController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index()
    {
        $subs = CSubElement::with('element')
                ->orderBy('element_id')
                ->get();

        return view('admin.sub-elements.index', compact('subs'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        $elements = CElement::all();
        return view('admin.sub-elements.form', compact('elements'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'element_id' => 'required',
            'name' => 'required',
            'weight' => 'required|numeric|min:0|max:100'
        ]);

        CSubElement::create([
            'element_id' => $request->element_id,
            'name' => $request->name,
            'weight' => $request->weight,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('sub-elements.index')
            ->with('success','Sub Element berjaya ditambah');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit($id)
    {
        $sub = CSubElement::findOrFail($id);
        $elements = CElement::all();

        return view('admin.sub-elements.form', compact('sub','elements'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'element_id' => 'required',
            'name' => 'required',
            'weight' => 'required|numeric|min:0|max:100'
        ]);

        $sub = CSubElement::findOrFail($id);

        $sub->update([
            'element_id' => $request->element_id,
            'name' => $request->name,
            'weight' => $request->weight,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('sub-elements.index')
            ->with('success','Sub Element berjaya dikemaskini');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        CSubElement::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success','Sub Element berjaya dipadam');
    }

    // =========================
    // INLINE UPDATE
    // =========================
    public function updateInline(Request $req)
    {
        $sub = CSubElement::findOrFail($req->id);

        $sub->update([
            'name' => $req->name,
            'weight' => $req->weight
        ]);

        return response()->json(['status'=>'ok']);
    }

    // =========================
    // ADD INLINE
    // =========================
    public function addInline(Request $req)
    {
        CSubElement::create([
            'element_id' => $req->element_id,
            'name' => 'New Sub Element',
            'weight' => 0
        ]);

        return response()->json(['status'=>'ok']);
    }
}
