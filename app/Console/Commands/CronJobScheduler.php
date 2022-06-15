<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\MailController;
use App\Models\PatientInsurance; 
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;


class CronJobScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';


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
        $this->applySubscritionToOldUsers();
        $this->checkIsPremiumDueDate();
        return 0;
    }

    private function applySubscritionToOldUsers(){
        $users = User::with('subscriptionPayments')->get();
        foreach ($users as $user) {
           if(isset($user->subscriptionPayments) && $user->subscriptionPayments->count() > 0){

           }else{
               sleep(1);
               $d = new UserController();
               $d->createFreePackage($user->id);
           }

       }         
    }

    private function checkIsPremiumDueDate(){
        $oneDayBeforeDate = Carbon::now()->subDays(1);
        $inssurances = PatientInsurance::orderBy('created_at', 'asc')->with('user')->get();
        foreach ($inssurances as $inssurance) {            
            if(isset($inssurance->premiumDate)){
                $diff = $inssurance->premiumDate->diffInDays($oneDayBeforeDate);
                if($diff == 15  || $diff == 1)
                {
                    // $inssurance is having matching row content. $inssurance->user use for user details.
                    // trigger mail from here
                    MailController::inssurancePremiumReminder($inssurance);
                    dump('found matching record ',json_decode($inssurance, true));
                }
            }
       }         
    }
}

