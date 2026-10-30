<x-guest-layout>

    <div class="flex flex-col">
            @if (session('success'))
                <div class="">
                    Something
                    {{ session('success') }}
                </div>
            @endif

        <div class="flex mb-5">
            <h2 class="text-2xl w-full">Inventory management</h2>

            <div class="w-12">
                <x-product-add-modal></x-product-add-modal>
            </div>
        </div>


        <div class="">
            <form action="{{ route('api.index') }}" method="get" class="flex">

                <x-text-input name="search" class="w-4/5">

                </x-text-input>

                <x-primary-button type="submit" class="ml-2">Search</x-primary-button>

                <a href="/">
                    <x-secondary-button class="ml-2 !py-4">Clear</x-secondary-button>
                </a>
            </form>

            @if(empty($products))
                <div class="py-5 text-center">
                    No results
                </div>
            @else

            <table class="table-fixed my-10 w-full">
                <thead>
                <tr class="text-left">
                    <th class="border !text-left p-2">STOCK CODE</th>
                    <th class="border !text-left p-2">DESCRIPTION</th>
                    <th class="border !text-left p-2">ACTIONS</th>
                </tr>
                </thead>

                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="border p-2">{{ $product['STOCK_CODE'] }}</td>
                        <td class="border p-2">{{ $product['DESCRIPTION'] }}</td>
                        <td class="border p-2">



                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            @endif

        </div>
    </div>


</x-guest-layout>
