<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Subscription;

class PlanController extends Controller
{
    private $repository;
    private $stripeBaseUrl;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\Plan $plan
     * @return void
     */
    public function __construct(Plan $plan)
    {
        $this->repository = $plan;
        $this->stripeBaseUrl = config('services.stripe.base_url');
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = $this->repository->get();

        return view('admin.pages.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePlan $request)
    {
        // CRIANDO O PLANO NO STRIPE
        $response = Http::withToken(config('services.stripe.secret'))
            ->asForm()
            ->post(
                "{$this->stripeBaseUrl}/plans",
                [
                    'amount' => $request->amount * 100,
                    'currency' => 'brl',
                    'interval' => $request->interval,
                    'product' => [
                        'name' => $request->name,
                    ],
                ]
            )
            ->json();

        // SE OCORRER ERRO NO STRIPE
        if (Arr::exists($response, 'error')) {
            return redirect()->route('plans.index')->with([
                'alert-type' => 'error',
                'message' => $response['error']['message']
            ]);
        }

        // CRIANDO O PLANO NO BD
        $this->repository->create([
            'name' => $request->name,
            'stripe_plan_id' => $response['id'],
            'stripe_product_id' => $response['product'],
            'description' => $request->description,
            'amount' => $response['amount'],
            'currency' => $response['currency'],
            'interval' => $response['interval'],
        ]);

        return redirect()->route('plans.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro criado com sucesso!'
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
        return redirect()->route('plans.index')->with([
            'alert-type' => 'info',
            'message' => 'Ainda não é possível deletar um plano'
        ]);
    }
}
