<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-pink-500 text-white text-left text-xs font-semibold uppercase tracking-wider">
                {{ $thead }}
            </tr>
        </thead>
        <tbody class="text-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>