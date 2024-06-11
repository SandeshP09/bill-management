<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\UserDocumentUpload;

class SendReminderEmailToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email to user on reminder date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $today = Carbon::today()->format('d/m/Y');
       $userData = UserDocumentUpload::where('reminder_email_date', $today)->get();
       //dd($userData);
       foreach($userData as $user){
        $userId = $user->user_id;
        $description = $user->description;
        $image = $user->image_path;
        $actualDate = $user->actual_date;
       }
    }
}
