@extends('layout.front.index')
@section('title')
   Compare
@endsection
@section('extra_css')
@endsection
@section('content')
   <h1 class="block-title large">Compare Products</h1>
   <!-- compare -->
   <div class="compare-table">
      <table>
         <!-- row-img -->
         <tr>
            <td>
               Product
            </td>
            @if ($p_1)
               <td>
                  <a href="{{ route('front.removeCompare','P_compare_1') }}" class="link-close icon icon-delete"></a>
                  <div class="product">
                     <div class="image-box">
                        <a href="{{ route('front.show',$p_1->product_slug) }}">
                           <img src="{{ $p_1->cover }}" alt="product image" class="img-thumbnail">
                        </a>
                        @if($p_1->is_off)
                           <div class="label-sale">Sale<br>{{ $p_1->off }}% Off</div>
                        @endif
                     </div>


                     <div class="title">
                        <a href="{{  route('product.show',$p_1->product_slug)  }}">{{ $p_1->product_name  }}</a>
                     </div>
                     <div class="price">
                        @if($p_1->is_off == 1)
                           <span class="new-price">{{ number_format($p_1->sale_price) }}</span>
                           <span class="old-price">{{ $p_1->price }}</span>
                        @else
                           <span class="price view">{{ $p_1->price }}</span>
                        @endif
                     </div>
                     <!-- visible-xs -->
                     <div class="visible-mobil-block visible-xs visible-sm">
                        <p>
                           <strong>BRAND</strong>
                        </p>
                        <p>
                           <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $p_1->brands->brand_slug ]) }}">
                              <img src="{{ $p_1->brands->src }}" alt="brand logo" class="img-thumbnail">
                           </a>
                        </p>
                        <p>
                           <strong>Description</strong>
                        </p>
                        <p>
                           {{ $p_1->description }}
                        </p>
                        <p>
                           Activity
                        </p>
                        <p>
                           N/A
                        </p>
                     </div>
                     <!-- /visible-xs -->
                  </div>
               </td>
            @else
               <td></td>
            @endif
            @if ($p_2)
               <td>
                  <a href="{{ route('front.removeCompare','P_compare_2') }}" class="link-close icon icon-delete"></a>
                  <div class="product">
                     <div class="image-box">
                        <a href="{{ route('front.show',$p_2->product_slug) }}">
                           <img src="{{ $p_2->cover }}" alt="product image" class="img-thumbnail">
                        </a>
                        @if($p_2->is_off)
                           <div class="label-sale">Sale<br>{{ $p_2->off }}% Off</div>
                        @endif
                     </div>

                     <div class="title">
                        <a href="{{  route('product.show',$p_2->product_slug)  }}">{{ $p_2->product_name  }}</a>
                     </div>
                     <div class="price">
                        @if($p_2->is_off == 1)
                           <span class="new-price">{{ number_format($p_2->sale_price) }}</span>
                           <span class="old-price">{{ $p_2->price }}</span>
                        @else
                           <span class="price view">{{ $p_2->price }}</span>
                        @endif
                     </div>
                     <!-- visible-xs -->
                     <div class="visible-mobil-block visible-xs visible-sm">
                        <p>
                           <strong>BRAND</strong>
                        </p>
                        <p>
                           <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $p_2->brands->brand_slug ]) }}">
                              <img src="{{ $p_2->brands->src }}" alt="brand logo" class="img-thumbnail">
                           </a>
                        </p>
                        <p>
                           <strong>Description</strong>
                        </p>
                        <p>
                           {{ $p_2->description }}
                        </p>
                        <p>
                           Activity
                        </p>
                        <p>
                           N/A
                        </p>
                     </div>
                     <!-- /visible-xs -->
                  </div>
               </td>
            @else
               <td></td>
            @endif


         </tr>
         <tr>
            <td>
               BRAND
            </td>
            <td>
               @if ($p_1)
                  <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $p_1->brands->brand_slug ]) }}">
                     <img src="{{ $p_1->brands->src }}" alt="brand logo" class="img-thumbnail">
                  </a>
               @endif
            </td>
            <td>
               @if ($p_2)
                  <a href="{{ route('front.lists', ['list' => 'brands' , 'slug' => $p_2->brands->brand_slug ]) }}">
                     <img src="{{ $p_2->brands->src }}" alt="brand logo" class="img-thumbnail">
                  </a>
               @endif
            </td>
         </tr>
         <tr>
            <td>
               Description
            </td>
            <td>
               @if ($p_1)
                  {{ $p_1->description }}
               @endif
            </td>
            <td>
               @if ($p_2)
                  {{ $p_2->description }}
               @endif
            </td>
         </tr>
         <tr>
            <td>
               Availability
            </td>
            <td>
               @if ($p_1)
                  @if($p_1->status == 1)
                     <span class="color-base">In stock</span>
                  @else
                     <span class="color-red">Out stock</span>
                     <span class="btn-info">Coming On :{{ $p_1->data_available }}</span>
                  @endif
               @endif
            </td>
            <td>
               @if ($p_2)
                  @if($p_2->status == 1)
                     <span class="color-base">In stock</span>
                  @else
                     <span class="color-red">Out stock</span>
                     <span class="btn-info">Coming On :{{ $p_2->data_available }}</span>
                  @endif
               @endif
            </td>
         </tr>
      </table>
   </div>
   <!-- /compare -->





@endsection
@section('extra_js')
   <!-- to load uploadAjax function -->
   <script src="{{ asset('front-assets/js/checkOut.js') }}"></script>
   <script type="text/javascript">
       //delete from Compare
       jQuery('.icon-delete').click(function (e) {
           e.preventDefault();
           var data = {
               _method : 'delete'
           };
           url = $(this).attr('href');
           upload_ajax( url, data,null,null,true);
           location.reload();
       });
   </script>
@endsection