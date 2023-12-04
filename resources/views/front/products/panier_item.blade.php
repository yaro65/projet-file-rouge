<?php use App\Models\Product; ?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
    <table>
        <thead>
            <tr>
                <th>Produits</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Prix Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Boucle foreach pour les éléments du panier -->
            @php $total = 0 @endphp
            @foreach($getPanierItems as $item)
            <?php 
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            ?>
            <tr>
                <td>
                    <div class="cart-anchor-image">
                        <a href="{{url('product/'.$item['product_id'])}}">
                            <img src="{{asset('front/images/product_images/small/'.$item['product']['product_image'])}}" alt="Product">
                            <h6>{{$item['product']['product_name']}} <br> Size: {{$item['size']}}</h6>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                        @if($getDiscountAttributePrice['discount'] > 0)
                        <!-- Prix avec réduction -->
                        <div class="price-template">
                            <div class="item-new-price">Fr.{{ $getDiscountAttributePrice['final_price']}}</div>
                            <div class="item-old-price" style="margin-left: -60px; important!">Fr.{{ $getDiscountAttributePrice['product_price']}}</div>
                        </div>
                        @else
                        <!-- Prix sans réduction -->
                        <div class="price-template">
                            <div class="item-new-price">Fr.{{ $getDiscountAttributePrice['final_price']}}</div>
                        </div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="cart-quantity">
                        <!-- Champ de quantité avec boutons +/- -->
                        <div class="quantity">
                            <input type="text" class="quantity-text-field" value="{{$item['quantity']}}">
                            <a class="plus-a updatePanierItem" data-panierid="{{$item['id']}}" data-qty="{{$item['quantity']}}" data-max="1000">&#43;</a>
                            <a class="minus-a updatePanierItem"  data-panierid="{{$item['id']}}" data-qty="{{$item['quantity']}}" data-min="1">&#45;</a>
                        </div>
                    </div>
                </td>
                <td>
                    <!-- Sous-total pour chaque élément du panier -->
                    <div class="cart-price">Fr.{{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}</div>
                </td>
                <td>
                    <!-- Actions pour l'élément du panier -->
                    <div class="action-wrapper">
                        <button class="button button-outline-secondary fas fa-trash deletePanierItem"
                         data-panierid="{{$item['id']}}"
                        ></button> 
                    </div>
                </td>
            </tr>
            @php $total = $total + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
            @endforeach
        </tbody>
    </table>
</div>
<!-- Products-List-Wrapper /- -->



<!-- Billing -->
<div class="calculation u-s-m-b-60">
    <div class="table-wrapper-2">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Panier Totals</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lignes pour le sous-total, l'expédition, la taxe et le total -->
            <!-- @php $total_price = 0 @endphp -->

                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Total</h3>
                    </td>
                    <td>
                        <span class="calc-text">{{$total}} Fr cfa</span>
                    </td>
                </tr>
                <tr>
                    <td>
                      <h3 class="calc-h3 u-s-m-b-0">Coupon de  Réduction</h3>
                    </td>
                    <td>
                        <span class="calc-text couponAmount">
                        @if(Session::has('couponAmount'))
                       Fr.{{ Session::get('couponAmount')}}
                      @else
                     Fr.0
                     @endif
                            </span>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Total Prix</h3>
                    </td>
                    <td>
                        <span class="calc-text grand_total"> @if(Session::has('couponAmount'))
                                               {{$total - Session::get('couponAmount')}} .Fr
                                              @else
                                              {{$total}} Fr.0
                         @endif</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Billing /- -->
