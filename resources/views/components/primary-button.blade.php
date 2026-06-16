<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-teal-900/10 transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 active:bg-teal-900']) }}>
    {{ $slot }}
</button>
