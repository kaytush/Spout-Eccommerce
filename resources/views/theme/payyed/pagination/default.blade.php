<?php
    $interval = isset($interval) ? abs(intval($interval)) : 2 ;
    $from = $paginator->currentPage() - $interval;
    if($from < 1){
        $from = 1;
    }

    $to = $paginator->currentPage() + $interval;
    if($to > $paginator->lastPage()){
        $to = $paginator->lastPage();
    }
?>
@if ($paginator->lastPage() > 1)
    <!-- Pagination -->
    <ul class="pagination justify-content-center mt-4 mb-0">
        <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a class="page-link" @if ($paginator->currentPage() == 1)) href="javascript:void(0);" @else href="{{ $paginator->url(1) }}"@endif tabindex="-1"><i class="fas fa-angle-left"></i></a>
        </li>
        @for ($i = $from; $i <= $to; $i++)
            <?php
                $isCurrentPage = $paginator->currentPage() == $i;
            ?>
        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
        @endfor
        <li class="page-item" {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}>
            <a class="page-link" @if ($paginator->currentPage() == $paginator->lastPage())) href="javascript:void(0);" @else href="{{ $paginator->url($paginator->lastPage()) }}"@endif><i class="fas fa-angle-right"></i></a>
        </li>
    </ul>
    <!-- Paginations end -->
@endif
