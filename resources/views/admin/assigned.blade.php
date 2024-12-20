<x-app-layout>
    <div style="padding: 30px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @php
                        $today = now()->startOfDay(); // Start of today
                        $yesterday = now()->subDay()->startOfDay(); // Start of yesterday
                    @endphp

                    {{-- Currently --}}
                    <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Currently</h3>
                    @if($history->where('dop', '>=', $today)->isEmpty())
                        <p>No current appointments.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Assigned Doctor</th>
                                    <th>Date of Appointment</th>
                                    <th class="concern-cell">Concern</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $hty)
                                    @if(!is_null($hty->dop) && \Carbon\Carbon::parse($hty->dop)->startOfDay()->equalTo($today))
                                        <tr>
                                            <td>{{ $hty->patientName }}</td>
                                            <td>{{ $hty->doctorsName }}</td>
                                            <td>{{ $hty->dop }}</td>
                                            <td class="concern-cell">{{ $hty->concern }}</td>
                                            <td>{{ $hty->created_at }}</td>
                                            <td>
                                                <button class="check-button" onclick="handleCheck({{ $hty->id }})">✔</button>
                                                <button class="cancel-button" onclick="handleCancel({{ $hty->id }})">✖</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- Future --}}
                    <h3 style="font-size: 20px; font-weight: bold; margin-top: 20px; margin-bottom: 10px;">Future</h3>
                    @if($history->where('dop', '>', $today)->isEmpty())
                        <p>No future appointments.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Assigned Doctor</th>
                                    <th>Date of Appointment</th>
                                    <th class="concern-cell">Concern</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $hty)
                                    @if(!is_null($hty->dop) && \Carbon\Carbon::parse($hty->dop)->startOfDay()->greaterThan($today))
                                        <tr>
                                            <td>{{ $hty->patientName }}</td>
                                            <td>{{ $hty->doctorsName }}</td>
                                            <td>{{ $hty->dop }}</td>
                                            <td class="concern-cell">{{ $hty->concern }}</td>
                                            <td>{{ $hty->created_at }}</td>
                                            <td>
                                                <button class="check-button" onclick="handleCheck({{ $hty->id }})">✔</button>
                                                <button class="cancel-button" onclick="handleCancel({{ $hty->id }})">✖</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- Yesterday --}}
                    <h3 style="font-size: 20px; font-weight: bold; margin-top: 20px; margin-bottom: 10px;">Yesterday</h3>
                    @if($history->where('dop', $yesterday->toDateString())->isEmpty())
                        <p>No appointments yesterday.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Assigned Doctor</th>
                                    <th>Date of Appointment</th>
                                    <th class="concern-cell">Concern</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $hty)
                                    @if(!is_null($hty->dop) && \Carbon\Carbon::parse($hty->dop)->startOfDay()->equalTo($yesterday))
                                        <tr>
                                            <td>{{ $hty->patientName }}</td>
                                            <td>{{ $hty->doctorsName }}</td>
                                            <td>{{ $hty->dop }}</td>
                                            <td class="concern-cell">{{ $hty->concern }}</td>
                                            <td>{{ $hty->created_at }}</td>
                                            <td>
                                                <button class="check-button" onclick="handleCheck({{ $hty->id }})">✔</button>
                                                <button class="cancel-button" onclick="handleCancel({{ $hty->id }})">✖</button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
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
    .check-button,
    .cancel-button {
        display: inline-block;
        padding: 6px 12px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 5px;
    }

    .check-button {
        background-color: #28a745; /* Green */
        color: white;
    }

    .check-button:hover {
        background-color: #218838;
    }

    .cancel-button {
        background-color: #dc3545; /* Red */
        color: white;
    }

    .cancel-button:hover {
        background-color: #c82333;
    }
</style>

<script>
    function handleCheck(id) {
        fetch(`/update-appointment-toDone`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                appointment_id: id,
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

    function handleCancel(id) {
        fetch(`/update-appointment-toCanceled`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                appointment_id: id,
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

