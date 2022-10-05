<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUniversity;
use App\Models\Path;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniversityController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\University $university
     * @return void
     */
    public function __construct(University $university)
    {
        $this->repository = $university;
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = $this->repository->with('path')->get();

        return view('admin.pages.universities.index', compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paths = Path::get();

        return view('admin.pages.universities.create', compact('paths'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateUniversity $request)
    {
        if ($request->avatar) {
            $avatarPath = $request->avatar->store('universities', 'public');
            $avatarArray = ['avatar' => $avatarPath];
        }

        $this->repository->create(array_merge([
            'path_id' => $request->path_id,
            'name' => $request->name,
            'address' => $request->address,
            'district' => $request->district,
            'city' => $request->city
        ], $avatarArray ?? []));

        return redirect()->route('universities.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro criado com sucesso!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $university = $this->repository->findOrFail($id);
        $paths = Path::get();

        return view('admin.pages.universities.edit', compact('university', 'paths'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateUniversity $request, $id)
    {
        $university = $this->repository->findOrFail($id);

        if ($request->avatar) {
            $avatarPath = $request->avatar->store('universities', 'public');
            $avatarArray = ['avatar' => $avatarPath];

            // EXCLUI O LOGO CASO TENHA
            if ($university->avatar) {
                Storage::delete("public/{$university->avatar}");
            }
        }

        $university->update(array_merge([
            'path_id' => $request->path_id,
            'name' => $request->name,
            'address' => $request->address,
            'district' => $request->district,
            'city' => $request->city
        ], $avatarArray ?? []));

        return redirect()->route('universities.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro atualizado com sucesso!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $university = $this->repository->findOrFail($id);

        // EXCLUI O LOGO CASO TENHA
        if ($university->avatar) {
            Storage::delete("public/{$university->avatar}");
        }

        $university->delete();

        return redirect()->route('universities.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro deletado com sucesso!'
        ]);
    }
}
