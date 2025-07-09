<x-sb-admin-master> 
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h2 class="text-2xl font-semibold">{{ __('Visitor Log Details') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <div class="min-w-[300px] max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 dark:bg-gray-900">
                            <!-- Header -->
                            <div class="px-4 py-3 bg-gray-100 dark:bg-gray-700 border-t text-sm text-gray-500 dark:text-gray-300 flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $visitorlog->ip_address ?? 'Data Not Found!' }}</h3>
                                </div>
                                <p class="text-sm">
                                    <strong>Visit Date:</strong>
                                    {{ $visitorlog->visit_date }}
                                </p>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line font-bold">{{__('Browser: ')}}</p>
                                    <p class="whitespace-pre-line">{{ $visitorlog->browser ?? 'Data Not Found!' }}</p>
                                </div>
                                
                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line font-bold">{{__('Visit From: ')}}</p>
                                    <p class="whitespace-pre-line">{{ $visitorlog->visit_from ?? 'Data Not Found!' }}</p>
                                </div>
                                
                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line font-bold">{{__('Device: ')}}</p>
                                    <p class="whitespace-pre-line">{{ $visitorlog->device ?? 'Data Not Found!' }}</p>
                                </div>

                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line font-bold">{{__('Location: ')}}</p>
                                    <div class="aspect-w-16 aspect-h-9">
                                        <iframe
                                            width="100%"
                                            height="450"
                                            frameborder="0"
                                            style="border:0"
                                            allowfullscreen
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            src="https://www.google.com/maps?q={{ $visitorlog->latitude ?? 'Data Not Found!' }},{{ $visitorlog->longitude ?? 'Data Not Found!' }}&hl=es;z=14&output=embed">
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 border-t text-sm text-gray-500 dark:text-gray-300 flex justify-between items-center">
                                <div>
                                    <span>Created: {{ $visitorlog->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="ml-4">Updated: {{ $visitorlog->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('admin.visitorlogs.index') }}"
                                        class="text-blue-600 hover:underline">← Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script></script>
    @endpush
</x-sb-admin-master> 
