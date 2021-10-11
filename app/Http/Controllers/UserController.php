<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create', [
            'countries' => Country::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|unique:Users|email',
            'username' => 'required|unique:Users|min:2',
            'password' => 'required|min:2',
            'house_number' => 'required',
            'street_name' => 'required',
            'unit_or_apt' => '',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required'

        ]);

        $residence = request('house_number') . ' ' . request('unit_or_apt') . ' ' . request('street_name') . ' ' . request('city') . ' ' . request('postal_code') . ' ' . request('country'); 

        $user = new User();
        $user->email = request('email');
        $user->username = request('username');
        $user->password = bcrypt(request('password'));
        $user->residence = $residence;
        $user->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
