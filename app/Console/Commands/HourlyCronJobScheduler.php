<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Models\PatientEvents;
use App\Models\TestBokking;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;

class HourlyCronJobScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Event email to all users with a word and its meaning';

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
        // $this->checkPatientEventDueTime();
        $this->checkTestBookingEventDueTime();
        return 0;
    }

    private function checkPatientEventDueTime(){
        $records = PatientEvents::orderBy('created_at', 'desc')->where('start', '>=', Carbon::today())->with('patient')->get();
        // $testBookings = TestBokking::orderBy('created_at', 'desc')->where('appointment_at', '>=', Carbon::today())->with('testpanel')->get();

        // dump('$diff ',Carbon::now()->timezone(Config::get('app.timezone')));
        // $to = Cookie::get('timezone_user');
        // $sourceTimezone = new DateTimeZone('UTC');
        // $destinationTimezone = new DateTimeZone(Config::get('app.timezone')); 


        dump('$diff ',Carbon::now());

                foreach ($records as $record) {    
                    if(isset($record->start)){
                        $d = Carbon::parse($record->start);
                        $hours_diff = $d->diffInHours(Carbon::now());
                         dump('$diff ',$hours_diff);


                        //  dump('$diff ',Carbon::now()->timezone(Config::get('app.timezone')));
                        //  dump('$record ',$record);

                        if($hours_diff == 3 || $hours_diff == -3)
                        {
                            // $record is having matching row content. $record->user use for user details.
                            // trigger mail from here
                            MailController::patientEventReminder($record);
                            dump('found matching record ',json_decode($record, true));
                        }
                    }
                }
            }
    private function checkTestBookingEventDueTime(){
        $records = TestBokking::orderBy('created_at', 'desc')->where('appointment_at', '>=', Carbon::today())->with('testpanel')->with('patient')->get();

        // dump('$diff ',Carbon::now()->timezone(Config::get('app.timezone')));
        // $to = Cookie::get('timezone_user');
        // $sourceTimezone = new DateTimeZone('UTC');
        // $destinationTimezone = new DateTimeZone(Config::get('app.timezone')); 
        // dump('$diff ',Carbon::now());

                foreach ($records as $record) {    
                    if(isset($record->appointment_at)){
                        $d = Carbon::parse($record->appointment_at);
                        $hours_diff = $d->diffInHours(Carbon::now());
                        dump('$diff ',$hours_diff);

                        if($hours_diff == 3 || $hours_diff == -3)
                        {
                            // $record is having matching row content. $record->user use for user details.
                            // trigger mail from here
                            MailController::patientEventReminder($record);
                            dump('found matching record ',json_decode($record, true));
                        }
                    }
                }
            }
   
    
}
