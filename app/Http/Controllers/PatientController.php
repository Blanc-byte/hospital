<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class PatientController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        return view('patients.appointment');
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'concern' => 'required|string|max:255',
        ]);

        // Get the authenticated user's ID
        $patientId = auth()->id();

        // Get today's date in the format yyyy-mm-dd
        $today = date('Y-m-d');

        // Check if the patient already has a pending appointment for today
        $pendingCount = DB::table('appointment')
            ->where('patientid', $patientId)
            ->where('status', 'pending')
            ->whereDate('created_at', $today) // Use whereDate to match only the date part of created_at
            ->count();

        $pendingCount2 = DB::table('appointment')
            ->where('patientid', $patientId)
            ->where('status', 'assigned')
            ->whereDate('created_at', $today) // Use whereDate to match only the date part of created_at
            ->count();

        // Proceed only if no pending appointments exist for today
        if ($pendingCount < 1) {
            if ($pendingCount2 < 1) {
                // Insert the data using raw query
                DB::table('appointment')->insert([
                    'patientid' => $patientId,  // Assuming the user is a patient
                    'concern' => $request->concern,
                    'created_at' => now(),     // Automatically set the created_at timestamp
                ]);
                return redirect()->back()->with('success', 'Appointment added successfully!');
            }else{
                return redirect()->back()->with('error', 'You can only request one appointment per day.');
            }
            

            // Redirect to appointment index with a success message
            //return redirect()->back()->with('success', 'Appointment added successfully!');
        } else {
            // Redirect back with an error message if a pending appointment exists for today
            return redirect()->back()->with('error', 'You can only request one appointment per day.');
        }
    }


    public function viewAppointment()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $today = date('Y-m-d'); // Get today's date in the format yyyy-mm-dd

        // Retrieve appointments for the logged-in user where 'status' is 'pending' and 'dop' matches today's date
        $appointment = collect(DB::select("
            SELECT * 
            FROM appointment 
            WHERE status = 'pending'
            AND patientid = ?
        ", [$userId]));
    // Raw SQL Query
    // $appointment = collect(DB::select("
    //     SELECT d.id AS doctor_id, d.name AS doctor_name, a.doctorsid, a.dop, a.status, a.concern
    //     FROM appointment a
    //     JOIN doctors d ON a.doctorsid = d.id
    //     WHERE a.patientid = ?
    // ", [$userId]));

        return view('patients.viewAppointment', ['appointments' => $appointment]);
    }
    public function viewAppointmentApproved()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        
        //$appointment = collect(DB::select("SELECT * FROM appointment where status != 'pending'"));
        // Raw SQL Query
        $appointment = collect(DB::select("
            SELECT d.id AS doctor_id, d.name AS doctor_name, a.doctorsid, a.dop, a.status, a.concern
            FROM appointment a
            JOIN doctors d ON a.doctorsid = d.id
            WHERE a.status != 'pending'"));

        return view('patients.approved', ['appointments' => $appointment]);
    }
}
