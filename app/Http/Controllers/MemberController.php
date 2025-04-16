<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::orderBy('id', 'desc')->get();
        $total = Member::count();

        return view('dashboard', compact('member', 'total'));
}
}
