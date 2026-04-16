<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RatingScale;
use App\Models\CSubElement;

class RatingController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index()
    {
        $ratings = RatingScale::with('subElement')
                    ->orderBy('sub_element_id')
                    ->get();

        return view('admin.ratings.index', compact('ratings'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        $subs = CSubElement::all();
        return view('admin.ratings.form', compact('subs'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'sub_element_id' => 'required',
            'label' => 'required',
            'score' => 'required|numeric'
        ]);

        RatingScale::create([
            'sub_element_id' => $request->sub_element_id,
            'label' => $request->label,
            'score' => $request->score,
            'description' => $request->description
        ]);

        return redirect()->route('ratings.index')
            ->with('success','Rating berjaya ditambah');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit($id)
    {
        $rating = RatingScale::findOrFail($id);
        $subs = CSubElement::all();

        return view('admin.ratings.form', compact('rating','subs'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_element_id' => 'required',
            'label' => 'required',
            'score' => 'required|numeric'
        ]);

        $rating = RatingScale::findOrFail($id);

        $rating->update([
            'sub_element_id' => $request->sub_element_id,
            'label' => $request->label,
            'score' => $request->score,
            'description' => $request->description
        ]);

        return redirect()->route('ratings.index')
            ->with('success','Rating berjaya dikemaskini');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        RatingScale::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success','Rating berjaya dipadam');
    }

    // =========================
    // INLINE UPDATE
    // =========================
    public function updateInline(Request $req)
    {
        $rating = RatingScale::findOrFail($req->id);

        $rating->update([
            'label' => $req->label,
            'score' => $req->score
        ]);

        return response()->json(['status'=>'ok']);
    }

    // =========================
    // ADD INLINE
    // =========================
    public function addInline(Request $req)
    {
        RatingScale::create([
            'sub_element_id' => $req->sub_element_id,
            'label' => 'New Rating',
            'score' => 0
        ]);

        return response()->json(['status'=>'ok']);
    }
}

