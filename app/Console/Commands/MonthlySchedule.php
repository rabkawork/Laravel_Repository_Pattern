<?php

namespace App\Console\Commands;

use App\Helpers\UsecreditHelper;
use App\Models\Credit;
use App\Models\Creditlog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonthlySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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

        try {
            $offset = 0;
            $limit = 30;
            $flag = false;
            while ($flag === false) {
                $users = User::whereIn('permission', [User::REGULAR_USER, User::PREMIUM_USER])
                    ->orderBy('id', 'ASC')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();
                if (count($users) === 0) {
                    $flag = true;
                }

                foreach ($users as $user) {
                    $defaultCredit = UsecreditHelper::getDefaultCredit($user->permission);
                    $credit = Credit::where('user_id',$user->id)->first();
                    $currentCredit = $credit->credit_total + $defaultCredit;
                    $updateCredit = Credit::find($credit->id);
                    $updateCredit->credit_total = $currentCredit;
                    $updateCredit->update();

                    $creditlog = new Creditlog;
                    $creditlog->user_id = $user->id;
                    $creditlog->credit_id = $credit->id;
                    $creditlog->amount = $currentCredit;
                    $creditlog->description = 'Monthly Recharge - '.$currentCredit;
                    $creditlog->save();


                }
                $offset += $limit;
            }

            Log::info('Recharge credit success.');
            return "success";
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return "failed";
        }

    }
}
