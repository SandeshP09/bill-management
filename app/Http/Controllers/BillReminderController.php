<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserDocumentUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class BillReminderController extends Controller
{
    //Homepage 
    public function addReminder(Request $request)
    {
        //Add validation
        $validateInput = $request->validate([
            //'user_id' => 'required|numeric|min:1',
            'description' => 'required|max:500',
            'image_path' => 'required|mimes:jpeg,jpg,png',
            'reminder_email_date' => 'required|numeric|min:1|max:10',
            'actual_date' => 'required|date_format:d/m/Y',
        ], [
            // 'user_id.required' => "User ID is required",
            // 'user_id.numeric' => "User ID can be digits only",
            'description.max' => "500 characters allowed",
            'image_path.required' => "Select image",
            'image_path.mimes' => "Only jpeg, jpg and png files allowed",
            'reminder_email_date.min' => "Enter number greater than equal to 1",
            'reminder_email_date.max' => "Enter number less than equal to 5",
            'actual_date.required' => "Actual date is required",
            'actual_date.date_format' => "Invalid date format, Enter in the format DD/MM/YYYY."
        ]);

        //Calculate the reminder date by subtracting days from the actual date and update the $reminderDate
        $actualDate = Carbon::createFromFormat('d/m/Y', $request->actual_date);
        if ($actualDate->isToday()) {
            return "Error, Actual date cannot be today's date";
        }
        $reminderDate = $actualDate->subDays($request->reminder_email_date);
        if ($reminderDate->isPast()) {
            return "Reminder date cannot be set in the past";
        }
        $reminderDate = $reminderDate->format('d/m/Y');

        if ($validateInput) {
            try {
                $storeReminder = new UserDocumentUpload();
                $storeReminder->user_id = $request->user_id;
                $storeReminder->description = $request->description;
                $name = "Invoice-" . '.' . $request->file('image_path')->getClientOriginalName();
                $storeReminder->image_path = $name;
                $storeReminder->reminder_email_date = $reminderDate;
                $storeReminder->actual_date = $request->actual_date;
                $storeReminder->status = "Active";
                $storeReminder->is_deleted = "False";
                $storeReminder->save();
                $request->image_path->move(storage_path('app/public/uploads/bills/'), $name);
                return response()->with('Success', 'Reminder set successfully');
            } catch (Exception $e) {
                return back()->with('Error', 'Setting reminder failed' . $e->getMessage());
            }

        }
    }

}
