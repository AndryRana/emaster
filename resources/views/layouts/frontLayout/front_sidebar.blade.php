<?php use App\Product; ?> 
<div class="left-sidebar">
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->
        <div class="panel panel-default">
            @foreach ($categories as $cat)
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordian" href="#{{ $cat->id }}">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        {{ $cat->name }}
                    </a>
                </h4>
            </div>
            <div id="{{ $cat->id }}" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        @foreach ($cat->categories as $subcat) 
                            <?php $productCount = Product::productCount($subcat->id) ?>
                            @if($subcat->status==1)
                                <li><a href="{{ asset('products/'.$subcat->url) }}">{{$subcat->name}} </a>   
                                    @if ($productCount >0) ({{ $productCount }}) @endif </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
            @endforeach
        </div>

    </div>
    <!--/category-products-->

</div>