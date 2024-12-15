<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        $appointment = collect(DB::select("SELECT u.name, a.id, a.status, a.concern, a.created_at
        FROM appointment a
        JOIN users u ON a.patientid=u.id
        WHERE status = 'pending'"));

        $doctors = collect(DB::select("SELECT * FROM doctors
        "));
        // $doctors = collect(DB::select("SELECT d.name, d.specialty ,COUNT(a.dop) as 'total'
        // FROM appointment a
        // JOIN doctors d ON a.doctorsid=d.id
        // WHERE a.status = 'asigned'
        // GROUP BY d.name, d.specialty
        // "));
        return view('admin.appointments', [
            'appointments' => $appointment,
            'doctors' => $doctors
        ]);
    }
    public function assignDoctor(Request $request)
    {
        $appointmentId = $request->appointment_id;
        $doctorId = $request->doctor_id;

        DB::table('appointment')
            ->where('id', $appointmentId)
            ->update(['doctorsid' => $doctorId,
                        'status' => 'assigned',
                        'dop' => now()
                    ]);

        return redirect()->back()->with(['message' => 'Appointment not found.'], 404);
    }
    public function updateDoctor(Request $request)
    {

        DB::table('doctors')
            ->where('id', $request->doctor_id)
            ->update(['name' => $request->doctor_name,
                        'specialty' => $request->doctor_specialty,
                        'status' => $request->doctor_status
                    ]);

        return redirect()->back()->with(['message' => 'Appointment not found.'], 404);
    }
    public function doctors()
    {
        $doctors = collect(DB::select("SELECT * FROM doctors"));
        return view('admin.doctors', [
            'doctors' => $doctors
        ]);
    }

    public function update(Request $request)
    {
        Log::debug('Received request data:', $request->all());

        // Validate the incoming request
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Log the validated data
        Log::debug('Validated data:', $validated);

        // Perform the update using DB facade
        $updated = DB::table('doctors')
            ->where('id', $validated['doctor_id'])
            ->update([
                'name' => $validated['name'],
                'specialty' => $validated['specialty'],
                'status' => $validated['status'],
            ]);

        // Log the result of the update
        Log::debug('Update result:', ['updated' => $updated]);

        // Return a JSON response
        if ($updated) {
            return response()->json(['message' => 'Doctor updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update doctor'], 400);
        }
    }
    public function history()
    {
        $history = collect(DB::select("SELECT u.name as patientName, d.name as doctorsName, a.dop, a.concern, a.created_at 
        FROM appointment a
        JOIN users u ON a.patientid = u.id
        JOIN doctors d ON a.doctorsid = d.id
        WHERE a.status = 'assigned'"));

        return view('admin.history', [
            'history' => $history
        ]);
    }
    public function users()
    {
        $users = collect(DB::select("SELECT * FROM users"));

        return view('admin.users', [
            'users' => $users
        ]);
    }
}
