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
        $request->validate([
            'concern' => 'required|string|max:255',
        ]);

        $patientId = auth()->id();

        $today = date('Y-m-d');

        $pendingCount = DB::table('appointment')
            ->where('patientid', $patientId)
            ->where('status', 'pending')
            ->count();

        $pendingCount2 = DB::table('appointment')
            ->where('patientid', $patientId)
            ->where('status', 'assigned')
            ->whereDate('created_at', $today) 
            ->count();

        if ($pendingCount < 1) {
            if ($pendingCount2 < 1) {
                DB::table('appointment')->insert([
                    'patientid' => $patientId, 
                    'concern' => $request->concern,
                    'created_at' => now(),    
                ]);
                return redirect()->back()->with('success', 'Appointment added successfully!');
            }else{
                return redirect()->back()->with('error', 'You can only request one appointment per day.');
            }
        } else {
            return redirect()->back()->with('error', 'You can only request one appointment.');
        }
    }


    public function viewAppointment()
    {
        $userId = auth()->id(); 
        $today = date('Y-m-d'); 

        $appointment = collect(DB::select("
            SELECT * 
            FROM appointment 
            WHERE status = 'pending'
            AND patientid = ? 
        ", [$userId]));
        
        return view('patients.viewAppointment', ['appointments' => $appointment]);
    }
    public function viewAppointmentApproved()
    {
        $userId = auth()->id(); 
        
        $appointment = collect(DB::select("
            SELECT d.id AS doctor_id, d.name AS doctor_name, a.doctorsid, a.dop, a.status, a.concern
            FROM appointment a
            JOIN doctors d ON a.doctorsid = d.id
            WHERE a.status != 'pending' ORDER BY dop DESC"));

        return view('patients.approved', ['appointments' => $appointment]);
    }
}
