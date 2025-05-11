<?php

namespace App\Http\Controllers;

use App\Models\ParkirMasuk;
use Illuminate\Http\Request;

class ParkirMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
          public function index(Request $request) {
    $query = ParkirMasuk::query(); // tanpa with('roles')
    

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('uid', 'like', "%$search%");
              
        });
    }

    $parkir_masuk = $query->paginate(5)->withQueryString();
    return view('admin.parkir_masuk.index', compact('parkir_masuk'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
