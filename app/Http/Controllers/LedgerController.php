<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateLedger;
use App\Models\Category;
use App\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\Ledger $ledger
     * @return void
     */
    public function __construct(Ledger $ledger)
    {
        $this->repository = $ledger;
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $ledgers = $this->repository
        //     ->with('categories')
        //     ->join('categories', 'categories.id', '=', 'ledgers.category_id')
        //     ->orderBy('date', 'desc')
        //     ->get();

        $ledgers = $this->repository->with('category')->get();

        return view('admin.pages.ledger.index', compact('ledgers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();

        return view('admin.pages.ledger.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateLedger $request)
    {
        // if (!Category::find($request->category_id)) {
        //     return redirect()->back()->with([
        //         'alert-type' => 'error',
        //         'message' => 'Categoria informada não existe!'
        //     ]);
        // }

        $this->repository->create($request->all());

        return redirect()->route('ledger.index')->with([
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
        $entry = $this->repository->with('category')->findOrFail($id);
        $categories = Category::all();

        return view('admin.pages.ledger.edit', compact('entry', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateLedger $request, $id)
    {
        $entry = $this->repository->findOrFail($id);

        $entryMonth = date("m", strtotime($entry->date));
        if($entryMonth != Carbon::now()->month) {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Não é possível editar registros de meses anteriores.'
            ]);
        }

        $entry->update($request->all());

        return redirect()->route('ledger.index')->with([
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
        $entry = $this->repository->findOrFail($id);

        return view('admin.pages.ledger._partials.delete', compact('entry'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = $this->repository->findOrFail($id);
        $entryMonth = date("m", strtotime($entry->date));

        if($entryMonth != Carbon::now()->month) {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Só é possível excluir registros do mês atual.'
            ]);
        }

        $entry->delete();

        return redirect()->route('ledger.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro deletado com sucesso!'
        ]);
    }
}
