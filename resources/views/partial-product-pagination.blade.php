<a href="#" class="prev-arrow" data-page="{{ $products->currentPage() - 1 }}" @if($products->onFirstPage()) style="pointer-events:none;opacity:0.5;" @endif>
    <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
</a>

@for ($i = 1; $i <= $products->lastPage(); $i++)
    <a href="#" class="{{ $products->currentPage() == $i ? 'active' : '' }}" data-page="{{ $i }}">{{ $i }}</a>
@endfor

<a href="#" class="next-arrow" data-page="{{ $products->currentPage() + 1 }}" @if(!$products->hasMorePages()) style="pointer-events:none;opacity:0.5;" @endif>
    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
</a>
