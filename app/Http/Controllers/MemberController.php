<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    $user = Auth::user();
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'uid' => 'required|string',
        'saldo' => 'required|numeric',
   ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'uid' => $request->uid,
        'saldo' => $request->saldo,
        'CreatedBy' => $user ? $user->name : 'system',
        'CompanyCode' => 'MB01',
        'Status' => 0 , 
        'IsDeleted' => 1,
        
        
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
        'saldo' => 'required|numeric',
        'password' => 'nullable|string|min:6',
    ]);
    $userUpdated = Auth::user();
    $user = User::findOrFail($id);
    $user1 =$user->name;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->uid = $request->uid;
    $user->saldo = $request->saldo;
    $user->LastUpdateBy = $userUpdated ? $userUpdated->name : 'system';
    $user->status = 1 ;
    $user->LastUpdateDate = now() ;
    $user->saldo = $request->saldo;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('admin.member')->with('success', 'Data user (' . $user1 . ' ) berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user1 =$user->name;
    $user->delete();

    return redirect()->route('admin.member')->with('success', 'User (' . $user1 . ' )berhasil dihapus.');
}

}

