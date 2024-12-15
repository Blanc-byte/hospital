<x-app-layout>
    <x-slot name="header">
        <h2 class="header-title">
            {{ __('History') }}
        </h2>
    </x-slot>

    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(110, 110, 110, 0.7); /* Darker overlay */
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal-content {
            background: #ffffff; /* Dark modal content */
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
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table-container td.concern-cell {
            word-wrap: break-word;
            white-space: pre-wrap;
            width: 40%; /* Adjusted for more space */
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
                    {{-- <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">History</h3> --}}

                    @if(is_null($history))
                        <p>No History yet.</p>
                    @else
                        <table class="table-container">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Assigned Doctor</th>
                                    <th>Date of Appointment</th>
                                    <th class="concern-cell">Concern</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $hty)
                                    <tr>
                                        <td>{{ $hty->patientName }}</td>
                                        <td>{{ $hty->doctorsName }}</td>
                                        <td>{{ $hty->dop }}</td>
                                        <td class="concern-cell">{{ $hty->concern }}</td>
                                        <td>{{ $hty->created_at }}</td>
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