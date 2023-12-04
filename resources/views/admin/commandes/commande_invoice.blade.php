<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Facture</h2><h3 class="pull-right">Commande # {{$commandeDetails['id']}}
                    <?php echo DNS1D::getBarcodeHTML($commandeDetails['id'], 'C39'); ?>
                </h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturé à :</strong><br>
    					{{$userDetails['name']}}<br>
                    @if(!empty($userDetails['address']))
    					{{$userDetails['address']}}<br>
                    @endif
                    @if(!empty($userDetails['ville']))
    					{{$userDetails['ville']}}<br>
                    @endif
                    @if(!empty($userDetails['pays']))
    					{{$userDetails['pays']}} <br>
                    @endif
                    @if(!empty($userDetails['region']))
                        {{$userDetails['region']}} <br>
                    @endif
                    @if(!empty($userDetails['telephone']))
                        {{$userDetails['telephone']}} <br>
                    @endif
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Expédié à :</strong><br>
                    {{$commandeDetails['name']}}<br>
                    {{$commandeDetails['address']}}<br>
                    {{$commandeDetails['rue']}}<br>
                    {{$commandeDetails['ville']}}<br>
                    {{$commandeDetails['pays']}}-{{$commandeDetails['codepostal']}}<br>
                    {{$commandeDetails['telephone']}}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Méthode de paiement:</strong><br>
                        {{$commandeDetails['payment_method']}} <br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Date de commande :</strong><br>
    					{{ date('Y-m-d h:i:s', strtotime($commandeDetails['created_at'])) }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Récapitulatif de la commande</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Code du Produit</strong></td>
        							<td class="text-center"><strong>Taille</strong></td>
        							<td class="text-center"><strong>Couleur</strong></td>
        							<td class="text-center"><strong>Quantité</strong></td>
        							<td class="text-center"><strong>Prix</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @php $subtotal = 0 @endphp
    							@foreach($commandeDetails['commandes_products'] as $product)
                                  <tr>
    							  	<td>{{$product['product_code']}}<?php echo DNS2D::getBarcodeHTML($product['product_code'], 'QRCODE'); ?></td>
    							  	<td class="text-center">{{$product['product_size']}}</td>
    							  	<td class="text-center">{{$product['product_color']}}</td>
    							  	<td class="text-center">{{$product['product_qty']}}</td>
    							  	<td class="text-center">{{$product['product_price']}} .Fr</td>
    							  	<td class="text-right">{{$product['product_price']*$product['product_qty']}} .Fr</td>
    							  </tr>
                                  @php $subtotal = $subtotal + ($product['product_price']*$product['product_qty']) @endphp
                                @endforeach

    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Total</strong></td>
    								<td class="thick-line text-right">{{$subtotal}}.Fr</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Frais de livraison</strong></td>
    								<td class="no-line text-right">0.Fr</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Total</strong></td>
    								<td class="no-line text-right"><strong>
                                    {{$commandeDetails['grand_total']}}
                                    </strong><br>
                                    @if($commandeDetails['payment_method']=="COD")
                                    <font color=red>(Déjà payé)</font> 
                                    @endif
                                </td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>