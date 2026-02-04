<x-app-layout>
    <div class="container mx-auto max-w-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Payment for Adoption</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h5 class="text-lg font-semibold text-gray-900 mb-2">Cat: {{ $adoption->cat->name }}</h5>
            <p class="text-gray-700 mb-4">Status: {{ ucfirst($adoption->status) }}</p>

            <form action="{{ route('adoptions.processPayment', $adoption->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="payment_amount" class="block text-gray-700 font-medium mb-2">Payment Amount</label>
                    <input type="text" name="payment_amount" id="payment_amount" class="form-input w-full border-gray-300 rounded-lg p-2" value="{{ $adoption->cat->price }}" readonly>
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Proceed with Payment
                </button>
            </form>
        </div>
    </div>
</x-app-layout>