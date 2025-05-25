<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;

class TopupAdminController extends Controller
{
    public function index(Request $request) {
    $query = Topup::query(); // tanpa with('roles')
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('name', 'like', "%$search%")
              ->orWhere('order_id', 'like', "%$search%")
              ->orWhere('method', 'like', "%$search%")
              ->orWhere('amount', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('created_at', 'like', "%$search%");
        });
    }

    $topup= $query->paginate(5)->withQueryString();

    
    
    return view('admin.topup.index', compact('topup'));

}
}
