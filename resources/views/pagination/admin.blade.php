                                    <?php
                                        $interval = isset($interval) ? abs(intval($interval)) : 3 ;
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
                                        <div class="card-inner">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><a class="page-link" href="{{ $paginator->url(1) }}">First</a></li>
                                            @for ($i = $from; $i <= $to; $i++)
                                                <?php
                                                    $isCurrentPage = $paginator->currentPage() == $i;
                                                ?>
                                                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                                            @endfor
                                                <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a></li>
                                            </ul>
                                        </div><!-- .card-inner -->
                                    @endif
