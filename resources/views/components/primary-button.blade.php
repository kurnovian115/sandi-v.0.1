<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'w-full rounded-lg px-4 py-3 text-white font-medium
                     bg-blue-900 hover:bg-blue-800
                     focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800
                     transition ease-in-out duration-150 cursor-pointer
    ',
    ]) }}>
    {{ $slot }}
</button>
