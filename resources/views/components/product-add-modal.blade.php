<!-- Trigger Button -->
<button onclick="document.getElementById('add-product-modal').classList.remove('hidden')" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600">
    +
</button>

<!-- Modal Background Overlay -->
<div id="add-product-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

    <!-- Modal Dialog Box -->
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 relative">

        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-bold text-gray-900">Add new product</h3>
            <button onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <!-- Modal Body -->
        <form method="post" action="{{ route('api.store') }}" class="py-4 text-gray-600 text-sm">
            @csrf

            <div class="flex flex-col mb-5">
                <x-input-label>STOCK_CODE</x-input-label>
                <x-text-input name="stockCode" required></x-text-input>
            </div>

            <div class="flex flex-col mb-5">
                <x-input-label>DESCRIPTION</x-input-label>
                <x-text-input name="description" required></x-text-input>
            </div>

            <div class="flex">
                <x-primary-button type="submit">Save</x-primary-button>

                <button onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="ml-3 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
            </div>

        </form>

    </div>
</div>
