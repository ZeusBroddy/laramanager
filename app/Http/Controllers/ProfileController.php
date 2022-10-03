<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
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

        if ($request->avatar) {
            try {
                $avatarPath = $request->avatar->store('profile', 'public');
                $avatar = Image::make(public_path("storage/{$avatarPath}"))->fit(800, 800);
                $avatar->save();
                $avatarArray = ['avatar' => $avatarPath];
            } catch (\Intervention\Image\Exception\ImageException $th) {
                return redirect()->back()->with([
                    'alert-type' => 'error',
                    'message' => $th
                ]);
            }


            // VERIFICAR SE O USUÁRIO JÁ POSSUI IMAGEM E EXCLUI
            if ($user->profile->avatar) {
                Storage::delete("public/{$user->profile->avatar}");
            }
        }

        $user->profile->update(array_merge([
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number
        ], $avatarArray ?? []));

        return redirect()->route('profile.edit')->with([
            'alert-type' => 'success',
            'message' => 'Registro atualizado com sucesso!'
        ]);
    }
}
