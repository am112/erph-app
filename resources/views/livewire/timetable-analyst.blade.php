<div class="mt-6">
    <x-ui.page-title>{{ __('Analisa Peruntukan Waktu') }}</x-ui.page-title>
    <div
        class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <div
            class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10 !border-t-0">
            <table class="fi-ta-table w-full text-sm table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Bidang Pembelajaran
                        </th>
                        <th scope="col" colspan="3" class="px-6 py-3 text-center">
                            Bahasa Instructional (Minit)
                        </th>
                    </tr>
                    <tr>
                        <th width="70%"></th>
                        <th width="10%" class="text-center">BM</th>
                        <th width="10%" class="text-center">BI</th>
                        <th width="10%" class="text-center">Jumlah</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

                    @forelse ($data->sortBy('name') as $item)
                        <tr class="bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900 text-center">
                            <td class="px-6 py-4 text-left">{{ $item['name'] }}</td>
                            <td>{{ $item['sum_bm'] }}</td>
                            <td>{{ $item['sum_bi'] }}</td>
                            <td>{{ $item['total'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-sm">
                                {{ __('filament-tables::table.empty.heading') }}</td>
                        </tr>
                    @endforelse
                    @if (!$data->isEmpty())
                        <tr class="bg-white font-bold text-center dark:bg-gray-900">
                            <td class="px-6 py-4 text-left">Jumlah</td>
                            <td>{{ $total['bm'] }}</td>
                            <td>{{ $total['bi'] }}</td>
                            <td>{{ $total['bm'] + $total['bi'] }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
