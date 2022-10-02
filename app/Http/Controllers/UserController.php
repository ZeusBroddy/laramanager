<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUser;
use App\Models\User;
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

        // $user->factory()->count(15)->create();

        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->withTrashed()->with('profile')->get();

        return view('admin.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create');
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

        $user->profile->update([
            'cpf' => $request->cpf
        ]);

        return redirect()->route('users.index')->with([
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
        $user = $this->repository->findOrFail($id);

        return view('admin.pages.users.edit', compact('user'));
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
        $user = User::findOrFail($id);

        $user->update([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->profile->update([
            'cpf' => $request->cpf
        ]);

        return redirect()->route('users.index')->with([
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
        $user = User::findOrFail($id);

        // subscription
        $subscription = $user->subscription('default');
        if ($subscription && !$subscription->canceled()) {
            $subscription->cancelNow();
        }

        $user->delete();

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Usuário inativado com sucesso e assinatura cancelada!',
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

        // subscription
        $subscription = $user->subscription('default');
        if ($subscription && $subscription->canceled() && $subscription->onGracePeriod()) {
            $subscription->resume();
        }

        $user->restore();

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Usuário reativado com sucesso!',
        ]);
    }
}
