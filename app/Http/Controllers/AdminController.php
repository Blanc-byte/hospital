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
        
        return view('admin.appointments', [
            'appointments' => $appointment,
            'doctors' => $doctors
        ]);
    }
    public function assignDoctor(Request $request)
    {
        $appointmentId = $request->appointment_id;
        $doctorId = $request->doctor_id;
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $datetime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validated['date'])->format('Y-m-d H:i:s');

        $updated = DB::table('appointment')
            ->where('id', $appointmentId)
            ->update([
                'doctorsid' => $doctorId,
                'status' => 'assigned',
                'dop' => $datetime
            ]);

        if ($updated) {
            return response()->json(['message' => 'Doctor assigned successfully.']);
        } else {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }
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
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $updated = DB::table('doctors')
            ->where('id', $validated['doctor_id'])
            ->update([
                'name' => $validated['name'],
                'specialty' => $validated['specialty'],
                'status' => $validated['status'],
            ]);
        
        if ($updated) {
            return response()->json(['message' => 'Doctor updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update doctor'], 400);
        }
    }
    public function history()
    {
        $history = collect(DB::select("SELECT a.id, u.name as patientName, d.name as doctorsName, a.dop, a.concern, a.created_at, a.status 
        FROM appointment a
        JOIN users u ON a.patientid = u.id
        JOIN doctors d ON a.doctorsid = d.id
        WHERE a.status = 'done' OR a.status = 'canceled'
        ORDER BY a.dop DESC"));

        return view('admin.history', [
            'history' => $history
        ]);
    }
    public function users()
    {
        $users = collect(DB::select("SELECT * FROM users WHERE role = 'Patient'"));

        return view('admin.users', [
            'users' => $users
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'status' => 'required|string|in:available,unavailable',
        ]);

        // Insert a new doctor record using Query Builder
        DB::table('doctors')->insert([
            'name' => $request->input('name'),
            'specialty' => $request->input('specialty'),
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with(['success' => true, 'message' => 'Doctor added successfully']);
    }
    public function destroy($doctor)
    {
        $result = DB::table('doctors')->where('id', $doctor)->delete();

        return redirect()->back()->with('success', 'Student deleted successfully');
    }
    public function assigned()
    {
        $history = collect(DB::select("SELECT a.id, u.name as patientName, d.name as doctorsName, a.dop, a.concern, a.created_at 
        FROM appointment a
        JOIN users u ON a.patientid = u.id
        JOIN doctors d ON a.doctorsid = d.id
        WHERE a.status = 'assigned' ORDER BY a.dop DESC"));

        return view('admin.assigned', [
            'history' => $history
        ]);
    }
    public function toDone(Request $request){
        $appointmentId = $request->appointment_id;

        $updated = DB::table('appointment')
            ->where('id', $appointmentId)
            ->update(['status' => 'done']);

        if ($updated) {
            return response()->json(['message' => 'Appointment status updated to canceled']);
        } else {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }
    }
    public function toCanceled(Request $request){
        $appointmentId = $request->appointment_id;

        $updated = DB::table('appointment')
            ->where('id', $appointmentId)
            ->update(['status' => 'canceled']);

        if ($updated) {
            return response()->json(['message' => 'Appointment status updated to canceled']);
        } else {
            return response()->json(['message' => 'Appointment not found.'], 404);
        }
    }
}
