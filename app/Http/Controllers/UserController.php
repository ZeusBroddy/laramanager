<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUser;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->repository = $user;
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->withTrashed()->with('profile.university')
            ->withCount(['invoices' => function (Builder $query) {
                $query->whereNull('paid_at');
            }])->get();

        return view('admin.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::get();

        return view('admin.pages.users.create', compact('universities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateUser $request)
    {
        $user = User::create([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->profile()->create([
            'university_id' => $request->university_id,
            'cpf' => $request->cpf
        ]);

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro criado com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->with('profile.university', 'invoices')->findOrFail($id);

        return view('admin.pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository->findOrFail($id);
        $universities = University::get();

        return view('admin.pages.users.edit', compact('user', 'universities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateUser $request, $id)
    {
        $user = $this->repository->findOrFail($id);

        $user->update([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->profile()->update([
            'university_id' => $request->university_id,
            'cpf' => $request->cpf
        ]);

        return redirect()->route('users.index')->with([
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
        $user = $this->repository->findOrFail($id);

        return view('admin.pages.users._partials.delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->repository->withCount(['invoices' => function (Builder $query) {
            $query->whereNull('paid_at');
        }])->findOrFail($id);

        if ($user->invoices_count > 0) {
            return redirect()->route('users.index')->with([
                'alert-type' => 'warning',
                'message' => 'Usu??rio possui fatura(s) em aberto.',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Usu??rio inativado com sucesso!',
        ]);
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Usu??rio reativado com sucesso!',
        ]);
    }
}
