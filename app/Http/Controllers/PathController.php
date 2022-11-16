<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePath;
use App\Models\Path;
use Illuminate\Http\Request;

class PathController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\Path $path
     * @return void
     */
    public function __construct(Path $path)
    {
        $this->repository = $path;
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paths = $this->repository->all();

        return view('admin.pages.paths.index', compact('paths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.paths.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePath $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('paths.index')->with([
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
        $path = $this->repository->findOrFail($id);

        return view('admin.pages.paths.edit', compact('path'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePath $request, $id)
    {
        $path = $this->repository->findOrFail($id);
        $path->update($request->all());

        return redirect()->route('paths.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro atualizado com sucesso!'
        ]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $path = $this->repository->findOrFail($id);

        return view('admin.pages.paths._partials.delete', compact('path'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $path = $this->repository->findOrFail($id);
        $path->delete();

        return redirect()->route('paths.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro deletado com sucesso!'
        ]);
    }
}
