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
                    <h3 class="text-lg font-bold mb-4">Appointment Details</h3>

                    @if(is_null($appointments))
                        <p>No appointment found.</p>
                    @else
                        @foreach($appointments as $appointment)
                            <div class="bg-gray-100 p-4 rounded-lg shadow mb-2 mb-4">
                                <p><strong>Concern:</strong> {{ $appointment->concern }}</p>
                                <p><strong>Doctor:</strong> {{ $appointment->doctor_name }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                                @if(is_null($appointment->dop))
                                    <p><strong>Date of Appointment:</strong> Not Available</p>
                                @else
                                    <p><strong>Date of Appointment:</strong> {{ $appointment->dop }}</p>
                                @endif
                                
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
