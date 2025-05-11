<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{   public function index(Request $request) {
    $query = User::where('role', 'user'); // tanpa with('roles')
    

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    $users = $query->paginate(5)->withQueryString();
    return view('admin.member.index', compact('users'));
}

    
    public function create() {
     
            // Ambil semua nama role dari Spatie Permission
           
        return view('admin.member.create');
    }
// Menyimpan user baru
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'uid' => 'required|string|min:6',
        'saldo' => 'required|string'
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'uid' => $request->uid,
        'saldo' => $request->saldo
    ]);

    return redirect()->route('admin.member')->with('success', 'Pengguna berhasil ditambahkan.');  
   
}

public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.member.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'uid' => 'required|string|max:255',
        'saldo' => 'required|string|max:255',
        'password' => 'nullable|string|min:6',
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->uid = $request->uid;
    $user->saldo = $request->saldo;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('admin.member')->with('success', 'Data user berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.member')->with('success', 'User berhasil dihapus.');
}

}

