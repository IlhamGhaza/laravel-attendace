<?php

namespace App\Observers;

use App\Models\Attendace;
use App\Models\Company;
use Carbon\Carbon;

class AttendaceObserver
{
    /**
     * Handle the Attendace "created" event.
     */
    // public function creating(Attendace $attendace)
    // {
    //     // Fetch the company details based on user or any relevant relation
    //     $company = Company::find(1);

    //     // Check if the employee is late
    //     $companyTimeIn = Carbon::parse($company->time_in);
    //     $attendaceTimeIn = Carbon::parse($attendace->time_in);

    //     $attendace->is_late = $attendaceTimeIn->gt($companyTimeIn);

    //     // Check if the employee worked overtime (only if 'time_out' is available)
    //     if ($attendace->time_out) {
    //         $companyTimeOut = Carbon::parse($company->time_out);
    //         $attendaceTimeOut = Carbon::parse($attendace->time_out);

    //         $attendace->is_overtime = $attendaceTimeOut->gt($companyTimeOut);
    //     } else {
    //         $attendace->is_overtime = false;
    //     }
    // }
    public function creating(Attendace $attendace)
    {
        $company = Company::find(1); // Adjust as needed

        $companyTimeIn = Carbon::parse($company->time_in);
        $companyTimeOut = Carbon::parse($company->time_out);
        $attendaceTimeIn = Carbon::parse($attendace->time_in);

        // Check if the employee is late
        \Illuminate\Support\Facades\Log::info('Company Time In: '.$companyTimeIn);
        \Illuminate\Support\Facades\Log::info('Attendance Time In: '.$attendaceTimeIn);

        $attendace->is_late = $attendaceTimeIn->gt($companyTimeIn);

        \Illuminate\Support\Facades\Log::info('Is Late: '.($attendace->is_late ? 'true' : 'false'));

        // Check for overtime only if time_out is available
        if ($attendace->time_out) {
            $attendaceTimeOut = Carbon::parse($attendace->time_out);
            $attendace->is_overtime = $attendaceTimeOut->gt($companyTimeOut);
        } else {
            $attendace->is_overtime = false;
        }
    }
}
