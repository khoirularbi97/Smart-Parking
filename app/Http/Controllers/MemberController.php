<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index() {
        $member = Member::orderBy('id','desc')->get();
        return view('admin.member.index', compact('member'));
    }

   
}

