<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (!$user = auth()->user()) {
            return redirect()->back();
        }

        return view('admin.pages.profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProfile $request)
    {
        if (!$user = auth()->user()) {
            return redirect()->back();
        }

        $user->profile->update($request->all());

        return redirect()->route('profile.edit')->with([
            'alert-type' => 'success',
            'message' => 'Registro atualizado com sucesso!'
        ]);
    }
}
