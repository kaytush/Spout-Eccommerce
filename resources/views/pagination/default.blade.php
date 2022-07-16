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
                                    <div class="paginating-container pagination-solid">

                                        <ul class="pagination">
                                            <li class="prev {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><a @if ($paginator->currentPage() == 1))
                                                href="javascript:void(0);"
                                            @else href="{{ $paginator->url(1) }}"@endif>First</a></li>
                                        @for ($i = $from; $i <= $to; $i++)
                                            <?php
                                                $isCurrentPage = $paginator->currentPage() == $i;
                                            ?>
                                            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                                        @endfor
                                            <li class="next {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"><a @if ($paginator->currentPage() == $paginator->lastPage()))
                                                href="javascript:void(0);"
                                            @else href="{{ $paginator->url($paginator->lastPage()) }}"@endif>Last</a></li>
                                        </ul>

                                    </div>
                                @endif
