<?php use App\Product;
// $url = url()->current(); 
// // $url = parse_url('http://emaster.test/products/');
// $url = str_replace('http://emaster.test/products/', '', $url);
// $url = str_replace('//localhost:3000/products/', '', $url);

?>
<form action="{{ url('/products-filter') }}" method="post">
    @csrf
    @if(!empty($url))
    <input name="url" value="{{ $url }}" type="hidden">
    @endif
    <div class="left-sidebar">
        <h2>Categories</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            @foreach ($categories as $cat)
            <div class="panel panel-default">
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
            </div>
            @endforeach

        </div>
        <!--/category-products-->
        @if(!empty($url))
        <h2>Couleurs</h2>
        <div class="panel-group " id="color_accordian">
            <div class="panel panel-default">
                <div
                    class=" appearance-none border border-gray-100 border-opacity-0 text-xs text-opacity-75 py-6 px-6 font-normal font-sans text-gray-900 uppercase">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#color_accordian" href="#color">
                            <span class="pull-right"><i class="fa fa-plus text-gray-600 text-xl "></i></span>
                            Couleurs
                        </a>
                    </h4>
                </div>
                <div id="color" class="panel-collapse collapse">
                    @foreach ($colorArray as $color)
                    @if (!empty($_GET['color']))
                    <?php $colorArr = explode('-', $_GET['color']) ?>
                    @if (in_array($color,$colorArr))
                    <?php $colorcheck="checked"; ?>
                    @else
                    <?php $colorcheck=""; ?>
                    @endif
                    @else
                    <?php $colorcheck=""; ?>
                    @endif
                    <div class="panel-heading">
                        <h4 class="panel-title ">
                            <input type="checkbox" name="colorFilter[]" onchange="javascript:this.form.submit();"
                                value="{{ $color }}" id="{{ $color }}" {{ $colorcheck }}>
                            <span class="ml-3 products-colors">{{ $color }}</span>
                        </h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class=" mt-10">
            <h2>Manches</h2>
            <div class="panel-group " id="sleeve_accordian">
                <div class="panel panel-default">
                    <div
                        class=" appearance-none border border-gray-100 border-opacity-0 text-xs text-opacity-75 py-6 px-6 font-normal font-sans text-gray-900 uppercase">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#sleeve_accordian" href="#sleeve">
                                <span class="pull-right"><i class="fa fa-plus text-gray-600 text-xl "></i></span>
                                Manches
                            </a>
                        </h4>
                    </div>
                    <div id="sleeve" class="panel-collapse collapse">
                        @foreach ($sleeveArray as $sleeve)
                        @if (!empty($_GET['sleeve']))
                        <?php $sleeveArr = explode('-', $_GET['sleeve']) ?>
                        @if (in_array($sleeve,$sleeveArr))
                        <?php $sleevecheck="checked"; ?>
                        @else
                        <?php $sleevecheck=""; ?>
                        @endif
                        @else
                        <?php $sleevecheck=""; ?>
                        @endif
                        <div class="panel-heading">
                            <h4 class="panel-title ">
                                <input type="checkbox" name="sleeveFilter[]" onchange="javascript:this.form.submit();"
                                    value="{{ $sleeve }}" id="{{ $sleeve }}" {{ $sleevecheck }}>
                                <span class="ml-3 products-sleeves">{{ $sleeve }}</span>
                            </h4>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h2>Modèles</h2>
            <div class="panel-group " id="pattern_accordian">
                <div class="panel panel-default">
                    <div
                        class=" appearance-none border border-gray-100 border-opacity-0 text-xs text-opacity-75 py-6 px-6 font-normal font-sans text-gray-900 uppercase">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#pattern_accordian" href="#pattern">
                                <span class="pull-right"><i class="fa fa-plus text-gray-600 text-xl "></i></span>
                                Modèles
                            </a>
                        </h4>
                    </div>
                    <div id="pattern" class="panel-collapse collapse">
                        @foreach ($patternArray as $pattern)
                        @if (!empty($_GET['pattern']))
                        <?php $patternArr = explode('-', $_GET['pattern']) ?>
                        @if (in_array($pattern,$patternArr))
                        <?php $patterncheck="checked"; ?>
                        @else
                        <?php $patterncheck=""; ?>
                        @endif
                        @else
                        <?php $patterncheck=""; ?>
                        @endif
                        <div class="panel-heading">
                            <h4 class="panel-title ">
                                <input type="checkbox" name="patternFilter[]" onchange="javascript:this.form.submit();"
                                    value="{{ $pattern }}" id="{{ $pattern }}" {{ $patterncheck }}>
                                <span class="ml-3 products-patterns">{{ $pattern }}</span>
                            </h4>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h2>Tailles</h2>
            <div class="panel-group " id="size_accordian">
                <div class="panel panel-default">
                    <div
                        class=" appearance-none border border-gray-100 border-opacity-0 text-xs text-opacity-75 py-6 px-6 font-normal font-sans text-gray-900 uppercase">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#size_accordian" href="#size">
                                <span class="pull-right"><i class="fa fa-plus text-gray-600 text-xl "></i></span>
                                Tailles
                            </a>
                        </h4>
                    </div>
                    <div id="size" class="panel-collapse collapse">
                        @foreach ($sizesArray as $size)
                        @if (!empty($_GET['size']))
                        <?php $sizeArr = explode('-', $_GET['size']) ?>
                        @if (in_array($size,$sizeArr))
                        <?php $sizecheck="checked"; ?>
                        @else
                        <?php $sizecheck=""; ?>
                        @endif
                        @else
                        <?php $sizecheck=""; ?>
                        @endif
                        <div class="panel-heading">
                            <h4 class="panel-title ">
                                <input type="checkbox" name="sizeFilter[]" onchange="javascript:this.form.submit();"
                                    value="{{ $size }}" id="{{ $size }}" {{ $sizecheck }}>
                                <span class="ml-3 ">{{ $size }}</span>
                            </h4>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</form>