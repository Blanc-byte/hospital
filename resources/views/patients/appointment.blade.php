<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Notification Modal --}}
                    @if (session('success') || session('error'))
                        <div id="notification-modal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-90">
                            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
                                <div class="text-right">
                                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold mb-4">
                                        @if (session('success'))
                                            <span class="text-green-500">Success</span>
                                        @else
                                            <span class="text-red-500">Error</span>
                                        @endif
                                    </h3>
                                    <p>
                                        {{ session('success') ?? session('error') }}
                                    </p>
                                </div>
                                <div class="text-center mt-4">
                                    <button onclick="closeModal()" class="btn">
                                        OK
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Patient's concern input form --}}
                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf
                        <div class="mt-4">
                            <label for="concern" class="label">Concern</label>
                            <textarea id="concern" name="concern" rows="4" class="textarea" placeholder="Enter your concern or reason for appointment here..."></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn">
                                Submit Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        function closeModal() {
            const modal = document.getElementById('notification-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <style>
        
        .fixed {
            position: fixed;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .bg-black {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .bg-opacity-50 {
            opacity: 0.5;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-lg {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.25);
        }

        .p-6 {
            padding: 1.5rem;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .w-full {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .text-green-500 {
            color: #38a169;
        }

        .text-red-500 {
            color: #e53e3e;
        }

        .hover\:text-gray-700:hover {
            color: #4a5568;
        }
        
        .label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        
        .textarea {
            display: block;
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #4a5568;
            background-color: #f7fafc;
            resize: vertical;
            min-height: 100px;
        }

        
        .textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #3182ce;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.375rem;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        
        .btn:hover {
            background-color: #2b6cb0;
        }

        
        .py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        
        .bg-white {
            background-color: #ffffff;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .sm\:rounded-lg {
            border-radius: 0.5rem;
        }

        
        .p-6 {
            padding: 1.5rem;
        }

        .text-gray-900 {
            color: #1a202c;
        }

        
        h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
        }
    </style>
</x-app-layout>
