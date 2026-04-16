<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CElement;

class ElementController extends Controller
{
    // =========================
    // LIST
    // =========================
 public function index()
{
    $elements = CElement::with('subElements.ratings')->get();

    return view('admin.5c-setting', compact('elements'));
}

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        return view('admin.elements.form');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:c_elements,code',
            'weight' => 'required|numeric|min:0|max:100'
        ]);

        CElement::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'weight' => $request->weight,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('elements.index')
            ->with('success','Element berjaya ditambah');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit($id)
    {
        $element = CElement::findOrFail($id);
        return view('admin.elements.form', compact('element'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:c_elements,code,'.$id,
            'weight' => 'required|numeric|min:0|max:100'
        ]);

        $element = CElement::findOrFail($id);

        $element->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'weight' => $request->weight,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('elements.index')
            ->with('success','Element berjaya dikemaskini');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        CElement::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success','Element berjaya dipadam');
    }

    // =========================
    // INLINE UPDATE (OPTIONAL)
    // =========================
    public function updateInline(Request $req)
    {
        $element = CElement::findOrFail($req->id);

        $element->update([
            'name' => $req->name,
            'weight' => $req->weight
        ]);

        return response()->json(['status'=>'ok']);
    }
}
