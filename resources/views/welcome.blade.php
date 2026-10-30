<x-guest-layout>
    <div class="flex flex-col">

        <h2 class="text-2xl">Inventory management</h2>

        <div class="">
            <form action="" method="get" class="flex">
                @csrf
                <x-text-input name="search-input" class="w-4/5">

                </x-text-input>

                <x-primary-button type="submit" class="ml-2">Search</x-primary-button>
            </form>

        </div>
    </div>


</x-guest-layout>
