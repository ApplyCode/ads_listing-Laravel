@php
    $locale = app()->getLocale();
    $selectedCountry = selected_country() ? strtolower(selected_country()->sortname) : null;
@endphp

<div class="header-bottom hidden lg:!block bg-primary-800 dark:bg-gray-800">
    <div class="container">
        <div class="flex gap-6 items-center">
            <div class="cat-menu text-white/80 overflow-visible">
                <button
                    class="inline-flex gap-2 items-center py-3 heading-07 transition-all duration-300 hover:text-white">
                    <x-svg.all-category-icon />
                    <span class="whitespace-nowrap">{{ __('all_category') }}</span>
                </button>
                <div class="cat-submenu flex flex-col gap-3">
                    <h3 class="heading-07 text-gray-900 dark:text-gray-100">
                        <a href="{{ $selectedCountry ? '/' . $selectedCountry . '/' : '/' }}">
                            {{ __('all_category') }}
                        </a>
                    </h3>
                    <ul class="flex flex-col gap-3">
                        @foreach (loadCategoriesSubcategories() as $category)
                            <li>
                                <a href="{{ $selectedCountry ? route('frontend.ads.fetch-by-country', ['country' => $selectedCountry, 'category' => $category['slug']]) : route('frontend.ads.category', $category['slug']) }}"
                                   class="cat-submenu-link block body-md-400 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-all duration-300"
                                   onclick="storeCountryAndCategory('{{ $selectedCountry }}', '{{ $category['slug'] }}')">
                                    <span class="relative">{{ $category['translations']['category'][$locale] ?? $category['name'] }}</span>
                                </a>
                                @if ($category['subcategories'] && count($category['subcategories']))
                                    <div class="cat-sub-submenu flex flex-col gap-3">
                                        <h3 class="heading-07 text-gray-900"></h3>
                                        <ul class="flex flex-col gap-3">
                                            @foreach ($category['subcategories'] as $subcategory)
                                                <li>
                                                    <a href="{{ $selectedCountry ? route('frontend.ads.fetch-by-country', ['country' => $selectedCountry, 'category' => $category['slug'], 'subcategory' => $subcategory['slug']]) : route('frontend.ads.sub.category', ['slug' => $category['slug'], 'subslug' => $subcategory['slug']]) }}"
                                                       class="body-md-400 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-all duration-300"
                                                       onclick="storeCountryAndCategory('{{ $selectedCountry }}', '{{ $subcategory['slug'] }}')">
                                                        {{ $subcategory['translations'][$locale] ?? $subcategory['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="swiper category-slider relative text-white/80">
                <div class="swiper-wrapper overflow-hidden flex items-center">
                    @foreach (loadCategoriesSubcategories() as $category)
                        <div class="swiper-slide whitespace-nowrap max-w-max inline-flex py-[13px]">
                            <a href="{{ $selectedCountry ? route('frontend.ads.fetch-by-country', ['country' => $selectedCountry, 'category' => $category['slug']]) : route('frontend.ads.category', $category['slug']) }}"
                               class="heading-07 transition-all duration-300 hover:text-white"
                               onclick="storeCountryAndCategory('{{ $selectedCountry }}', '{{ $category['slug'] }}')">
                                {{ $category['name'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="slider-navigation__wrap text-left">
                    <div class="category-slider_prev cursor-pointer inline-flex items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="#1768E0" class="rtl:rotate-180" />
                    </div>
                </div>
                <div class="slider-navigation__wrap text-left">
                    <div class="category-slider_next cursor-pointer inline-flex items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="#1768E0" class="rtl:rotate-180" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function storeCountryAndCategory(country, category) {
        if (country) {
            localStorage.setItem('selectedCountry', country);
        }
        if (category) {
            localStorage.setItem('selectedCategory', category);
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        let storedCountry = localStorage.getItem('selectedCountry');
        let storedCategory = localStorage.getItem('selectedCategory');
    });
</script>