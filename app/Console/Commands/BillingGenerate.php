<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BillingGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create invoice to active users';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = DB::table('users')->whereNull('deleted_at')->get();
        $plan = DB::table('plans')->where('status', 'active')->orderBy('created_at', 'desc')->first();

        foreach ($users as $user) {
            Invoice::create([
                'user_id' => $user->id,
                'description' => "{$user->name} - Mensalidade",
                'total' => $plan->amount,
                'paid_at' => null,
                'due_date' => Carbon::now()->addRealDays(10)
            ]);
        }

        return 0;
    }
}
