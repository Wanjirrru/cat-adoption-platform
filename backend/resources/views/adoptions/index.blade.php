<x-app-layout>
    <div class="container mx-auto max-w-4xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Adoption Requests</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @foreach($adoptions as $adoption)
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h5 class="text-lg font-semibold text-gray-900">Cat: {{ $adoption->cat->name }}</h5>
                <p class="text-gray-700">Requested by: {{ $adoption->user->name }}</p>

                @if(!empty($adoption->message))
                    <p class="text-gray-600 mt-2">Message: {{ $adoption->message }}</p>
                @else
                    <p class="text-gray-600 mt-2">Message: No message provided.</p>
                @endif

                @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin'))
                    @if($adoption->status === 'pending')
                        <form action="{{ route('adoptions.update', $adoption->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <label for="status" class="block text-gray-700 mb-2">Update Status</label>
                            <select name="status" id="status" class="form-select border-gray-300 rounded-lg p-2 mb-4 w-full">
                                <option value="pending" {{ $adoption->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $adoption->status === 'accepted' ? 'selected' : '' }}>Approve</option>
                                <option value="declined" {{ $adoption->status === 'declined' ? 'selected' : '' }}>Decline</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update Status</button>
                        </form>
                    @else
                        <p class="mt-4 text-gray-800">Status: {{ ucfirst($adoption->status) }}</p>
                    @endif
                @else
                    @if($adoption->status === 'accepted')
                        <p class="mt-4 text-green-700 font-medium">Status: Accepted! Please proceed to payment.</p>
                        <a href="{{ route('adoptions.payment', ['adoption' => $adoption->id]) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 mt-2 inline-block">Proceed to Payment</a>
                    @else
                        <p class="mt-4 text-gray-800">Status: {{ ucfirst($adoption->status) }}</p>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>