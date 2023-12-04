<?php use App\Models\Product; 
$getPanierItems= getPanierItems();
?>
 <!-- Mini Cart -->
 <div class="mini-cart-wrapper">
            <div class="mini-cart">
                <div class="mini-cart-header">
                    VOTRE PANIER
                    <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
                </div>
                <ul class="mini-cart-list">
                      <!-- Boucle foreach pour les éléments du panier -->
                @php $total = 0 @endphp
                 @foreach($getPanierItems as $item)
                 <?php 
                 $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                 ?>
                    <li class="clearfix">
                        <a href="{{url('product/'.$item['product_id'])}}">
                            <img src="{{asset('front/images/product_images/small/'.$item['product']['product_image'])}}" alt="Product">
                            <span class="mini-item-name">{{$item['product']['product_name']}}</span>
                            <span class="mini-item-price">Fr.{{ $getDiscountAttributePrice['final_price']}}</span>
                            <span class="mini-item-quantity"> x {{$item['quantity']}}</span>
                        </a>
                    </li>
                    @php $total = $total + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                @endforeach
                      
                </ul>
                <div class="mini-shop-total clearfix">
                    <span class="mini-total-heading float-left">Total:</span>
                    <span class="mini-total-price float-right">{{$total}} Fr cfa</span>
                </div>
                <div class="mini-action-anchors">
                    <a href="{{url('panier')}}" class="cart-anchor">Voir le panier</a>
                    <a href="{{url('acherter')}}" class="checkout-anchor">Confirmer l'achat</a>
                </div>
            </div>
 </div>
 <script>
   $('#mini-cart-close').on('click', function() {
     $('.mini-cart-wrapper').removeClass('mini-cart-open');
 });
 </script>
  <!-- Mini Cart /- -->