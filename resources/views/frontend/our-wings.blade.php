<x-frontend.layouts.master>
    <x-frontend.layouts.partials.page-banner :pageTitle="'Our Wings'" />

    <x-frontend.sections.wings />

    @push('css')
        <style>
            .choose-us-img .icon {
                color: #89c4e6;
                /* soft blue */
                font-size: 40px;
                flex-shrink: 0;
                margin-top: 4px;
            }

            .choose-us-link {
                text-decoration: none;
                color: inherit;
                display: block;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .choose-us-link:hover .choose-us-item-02 {
                transform: translateY(-6px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                background-color: #fdfdfd;
            }
        </style>
    @endpush
</x-frontend.layouts.master>
