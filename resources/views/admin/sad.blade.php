<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
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
    </style>

    <div style="padding: 30px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Doctors Management</h3>

                    <!-- Add Doctor Button -->
                    <button onclick="openAddDoctorModal()" class="assign-button" style="margin-bottom: 20px;">Add Doctor</button>

                    @if(empty($doctors))
                        <p>No doctors found.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Specialty</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctors as $doctor)
                                    <tr>
                                        <td>{{ $doctor->id }}</td>
                                        <td>{{ $doctor->name }}</td>
                                        <td>{{ ucfirst($doctor->specialty) }}</td>
                                        <td>{{ ucfirst($doctor->status) }}</td>
                                        <td>
                                            <button class="assign-button" onclick="openEditDoctorModal('{{ $doctor->id }}', '{{ $doctor->name }}', '{{ $doctor->specialty }}', '{{ $doctor->status }}')">Edit</button>
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

    <!-- Add Doctor Modal -->
    <div id="add-doctor-modal" class="modal-overlay hidden">
        <div class="modal-content">
            <h3>Add Doctor</h3>
            <form action="{{ route('doctor.add') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="add-doctor-name" class="block">Doctor's Name</label>
                    <input type="text" id="add-doctor-name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label for="add-doctor-specialty" class="block">Specialty</label>
                    <input type="text" id="add-doctor-specialty" name="specialty" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                </div>
                <div class="mb-4">
                    <label for="add-doctor-status" class="block">Status</label>
                    <select id="add-doctor-status" name="status" class="w-full p-2 border border-gray-300 rounded mt-1" required>
                        <option value="available">available</option>
                        <option value="unavailable">unavailable</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="assign-button" onclick="closeAddDoctorModal()">Cancel</button>
                    <button type="submit" class="assign-button ml-2">Add Doctor</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function openAddDoctorModal() {
        document.getElementById('add-doctor-modal').classList.remove('hidden');
        document.getElementById('add-doctor-modal').style.display = 'flex';
    }

    function closeAddDoctorModal() {
        document.getElementById('add-doctor-modal').classList.add('hidden');
        document.getElementById('add-doctor-modal').style.display = 'none';
    }
    let appID = null;

    
    function openEditDoctorModal(doctorId, name, specialty, status) {
        appID = doctorId;
        
        document.getElementById('doctor-id').value = doctorId;
        document.getElementById('doctor-name').value = name;
        document.getElementById('doctor-specialty').value = specialty;
        document.getElementById('doctor-status').value = status;

        
        document.getElementById('edit-doctor-modal').classList.remove('hidden');
        document.getElementById('edit-doctor-modal').style.display = 'flex';
    }


    function closeEditDoctorModal() {
        document.getElementById('edit-doctor-modal').classList.add('hidden');
        document.getElementById('edit-doctor-modal').style.display = 'none';
    }

    function closeConfirmationModal() {
        const doctorName = document.getElementById('doctor-name').value;
        const doctorSpecialty = document.getElementById('doctor-specialty').value;
        const doctorStatus = document.getElementById('doctor-status').value;

        
        console.log('Doctor ID:', appID);
        console.log('Doctor Name:', doctorName);
        console.log('Specialty:', doctorSpecialty);
        console.log('Status:', doctorStatus);

        fetch(/update-doctor, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                doctor_id: appID,
                doctor_name: doctorName,
                doctor_specialty: doctorSpecialty,
                doctor_status: doctorStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
            console.log(data);
            closeEditDoctorModal();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

</script>
