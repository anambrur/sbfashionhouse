
@forelse ($subcategories as $subCategory)
    <div class="list-item">
        <a href="/category/{{ $subCategory->slug }}" class="category_menu_text">
            <img src="{{ SM::sm_get_the_src($subCategory->fav_icon) }}" alt="">
            <span>{{ $subCategory->title }}</span>
        </a>
        <ul>
            {{-- Check if the subcategory has sub-subcategories --}}
            @if (!$subCategory->subcategories->isEmpty())
            <div class="sub-menu mega-menu mega-menu-column-4">
                @include('frontend.common.partial_nav', [
                    'subcategories' => $subCategory->subcategories,
                ])
            </div>
            @endif
        </ul>
    </div>
@empty
    
@endforelse

