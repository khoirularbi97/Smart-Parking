<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



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
        'uid' => 'nullable|string|max:255|unique:users,uid',
        'saldo' => 'required|numeric',
        'telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
   ]);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'uid' => $request->uid,
        'saldo' => $request->saldo,
        'telepon' => $request->telepon,
        'alamat' => $request->alamat,
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
        'uid' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'uid')->ignore($id),
            ],
        'telepon' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
        'saldo' => 'required|numeric',
        'password' => 'nullable|string|min:6',
    ]);

    $user = User::findOrFail($id);
    $oldName = $user->name;

    // Update fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->uid = $request->uid;
    $user->saldo = $request->saldo;
    $user->telepon = $request->telepon;
    $user->alamat = $request->alamat;
    $user->status = 1;
    $user->LastUpdateDate = now();

    // Last updated by (check if user is logged in)
    if (Auth::check()) {
        $user->LastUpdateBy = Auth::user()->name;
    } else {
        $user->LastUpdateBy = 'system';
    }

    // Update password only if filled
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()
        ->route('admin.member')
        ->with('success', 'Data user (' . $oldName . ') berhasil diperbarui!');
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

