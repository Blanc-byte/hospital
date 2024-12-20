<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approved') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- <h3 class="text-lg font-bold mb-4">Appointment Details</h3> --}}

                    @if(is_null($appointments))
                        <p>No appointment found.</p>
                    @else
                        @php
                            $today = now()->startOfDay(); // Current date at the start of the day
                        @endphp
                        
                        <!-- Current Appointments Section -->
                        <div class="mb-6 HAHA">
                            <h2 class="text-lg font-bold mb-4">Current Appointment</h2>
                            @foreach($appointments as $appointment)
                                @php
                                    $dopDate = !is_null($appointment->dop) ? \Carbon\Carbon::parse($appointment->dop)->startOfDay() : null;
                                @endphp
                                @if(is_null($dopDate) || $dopDate->greaterThanOrEqualTo($today)) <!-- Current -->
                                    <div class="bg-gray-100 p-4 rounded-lg shadow mb-2 HAHAHA">
                                        <p><strong>Concern:</strong> {{ $appointment->concern }}</p>
                                        <p><strong>Doctor:</strong> {{ $appointment->doctor_name }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                                        <p><strong>Date of Appointment:</strong> {{ $appointment->dop ?? 'Not Available' }}</p>
                                        <button class="cancel-button" onclick="handleCancel({{ $appointment->id }})">CANCEL</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- History Appointments Section -->
                        <div class="HAHA">
                            <h2 class="text-lg font-bold mb-4">History Appointments</h2>
                            @foreach($appointments as $appointment)
                                @php
                                    $dopDate = !is_null($appointment->dop) ? \Carbon\Carbon::parse($appointment->dop)->startOfDay() : null;
                                @endphp
                                @if(!is_null($dopDate) && $dopDate->lessThan($today)) <!-- History -->
                                    <div class="bg-gray-100 p-4 rounded-lg shadow mb-2 HAHAHA">
                                        <p><strong>Concern:</strong> {{ $appointment->concern }}</p>
                                        <p><strong>Doctor:</strong> {{ $appointment->doctor_name }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                                        <p><strong>Date of Appointment:</strong> {{ $appointment->dop }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .HAHAHA{
        margin-bottom: 20px;
    }
    .HAHA{
        font-size: large;
        background-color: #7b8185;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        margin-top: 30px;
    }
    .HAHA h2{
        color: white;
        font-weight: bold;
        padding: 20px;
        background-color: #589ac7;
    }
    .cancel-button {
        padding: 5px 20px;
        background-color: #dc3545;
        color: white;
        border-radius: 10px;
    }

    .cancel-button:hover {
        background-color: #c82333;
    }
</style>
<script>
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