<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Query;
use App\Models\Sign;
use App\Models\Attendance;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Request $request)
    {
    $searchnum = $request->input('search');
    $username = null;
    $usernum = null;
    $queries = collect();
    $sign_off = collect();
    $atten = collect();
    $error = null;
        $userdata = User::where('u_num', $searchnum)->first();
        if ($userdata) {
            $userid = $userdata->id;
            $username = $userdata->name;
            $usernum = $userdata->u_num;
            $queries = Query::where('users_id',$userid)->get();
            $sign_off = Sign::where('users_id',$userid)->get();
            $atten = Attendance::where('name',$username)->get();
            $teachrole = auth()->user()->role;
            $layout = $teachrole === 'ADMIN' ? 'layouts.admin' : 'layouts.ta';
        } else {
            $error = 'No user found with that university number';
        }
            return view('search', compact('username','usernum','queries','sign_off','atten','error','layout'));    
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
