<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="header-title">
            {{ __('Pending Appointments') }}
        </h2>
    </x-slot> --}}

    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(110, 110, 110, 0.7); 
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal-content {
            background: #ffffff; 
            border-radius: 0.5rem;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table-container th {
            background-color: #B2F5E1;
            font-weight: bold;
        }

        .table-container td.concern-cell {
            word-wrap: break-word;
            white-space: pre-wrap;
            width: 40%; 
        }

        .assign-button {
            background-color: #007BFF;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .assign-button:hover {
            background-color: #0056b3;
        }

        .assign-button2 {
            background-color: #007BFF;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .assign-button2:hover {
            background-color: #0056b3;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>

    <div style="padding: 30px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Pending Appointments</h3>

                    @if(is_null($appointments))
                        <p>No pending appointments found.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Patient Name</th>
                                    <th>Status</th>
                                    <th class="concern-cell">Concern</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id }}</td>
                                        <td>{{ $appointment->name }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                        <td class="concern-cell">{{ $appointment->concern }}</td>
                                        <td>{{ $appointment->created_at }}</td>
                                        <td>
                                            <button type="submit" class="assign-button" onclick="openConfirmationModal({{ $appointment->id }})">Assign</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
<div id="confirmation-modal" class="modal-overlay hidden">
    <div class="modal-content">
        <table class="table-container">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doctor)
                    @if ($doctor->status === 'available')
                        <tr>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->specialty }}</td>
                            <td>
                                <button type="submit" class="assign-button" onclick="closeConfirmationModal({{ $doctor->id }})">CHOOSE</button>
                                
                            </td>
                        </tr>
                    @endif
                    
                @endforeach   
            </tbody>
            <div class="mb-4">
                <label for="datetime" class="block font-semibold mb-2">Select Date and Time:</label>
                <input type="datetime-local" name="datetime" id="datetime" class="input-field" required>
            </div>
        </table>
        <button type="submit" class="assign-button2" onclick="CancelConfirmationModal()">CANCEL</button>
    </div>
</div>
<script>
    let appID = null;
    function openConfirmationModal(appointmentid) {
        appID = appointmentid;
        document.getElementById('confirmation-modal').classList.remove('hidden');
        document.getElementById('confirmation-modal').style.display = 'flex';
    }
    function CancelConfirmationModal() {
        document.getElementById('confirmation-modal').classList.add('hidden');
        document.getElementById('confirmation-modal').style.display = 'none';
    }
    function closeConfirmationModal(doctorid) {
        // Check if the datetime field is empty
        
        const datetimeInput = document.getElementById('datetime').value;
        if (!datetimeInput) {
            alert("Please select a date and time.");
            return;
        }

        document.getElementById('confirmation-modal').classList.add('hidden');
        document.getElementById('confirmation-modal').style.display = 'none';

        

        console.log("Appointment ID: " + appID);
        console.log("Doctor ID: " + doctorid);
        console.log("Selected DateTime: " + datetimeInput);
        fetch(`/assign-doctor`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                appointment_id: appID,
                doctor_id: doctorid,
                date: datetimeInput
            })
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>