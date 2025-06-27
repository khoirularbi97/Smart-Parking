<?php

namespace App\Http\Controllers;

use App\Models\ParkirKeluar;
use Illuminate\Http\Request;

class ParkirKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = ParkirKeluar::query(); // tanpa with('roles')
    

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('uid', 'like', "%$search%");
              
        });
    }

    $parkir_keluar = $query->latest()->paginate(10)->withQueryString();
    return view('admin.parkir_keluar.index', compact('parkir_keluar'));
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
