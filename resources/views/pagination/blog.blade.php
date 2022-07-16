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
                        <div class="blog_pagination_wrapper">
							<ul>
								<li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : 'blog_page_prev' }}"><a href="{{ $paginator->url(1) }}"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
                                @for ($i = $from; $i <= $to; $i++)
                                    <?php
                                        $isCurrentPage = $paginator->currentPage() == $i;
                                    ?>
                                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                                @endfor
								<li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : 'blog_page_next' }}"><a href="{{ $paginator->url($paginator->lastPage()) }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
							</ul>
						</div>
                    @endif
