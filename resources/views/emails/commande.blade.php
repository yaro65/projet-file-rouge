<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <table style="width:700px;">
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <img src="{{asset('front/images/main-logo/Logo.png')}}" alt="width:150; heigth:150;">
        </td></tr>
        <tr><td>Chère : {{$name}}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Merci de faire vos achats chez nous. Les détails de votre commande sont les suivants :</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Numéro de commande. {{$commande_id}}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <td><tr>
               <table style="width:700px;" cellpadding="5" bgcolor="#f7f4f4">
                 <tr bgcolor="#ccccc">
                    <th>Nom du produit</th>
                    <th>Code produit</th>
                    <th>Taille du produit</th>
                    <th>Couleur du produit</th>
                    <th>Prix du produit</th>
                    <th>Quantité du produit</th>
                 </tr>
                 @foreach($commandeDetails['commandes_products'] as $commande)
                 <tr  bgcolor="#f9f9f9">
                   <td>{{$commande['product_name']}}</td>
                   <td>{{$commande['product_code']}}</td>
                   <td>{{$commande['product_size']}}</td>
                   <td>{{$commande['product_color']}}</td>
                   <td>{{$commande['product_price']}}</td>
                   <td>{{$commande['product_qty']}}</td>
                 </tr>
                 @endforeach
                 <tr>
                    <td colspan="5" align="right">Frais de livraison</td>
                    <td>Fr.{{$commandeDetails['shipping_charge']}}</td>
                 </tr>
                 <tr>
                    <td colspan="5" align="right">Montant du coupon</td>
                    <td>Fr.
                        @if($commandeDetails['coupon_amount']>0)
                           {{$commandeDetails['coupon_amount']}}
                           @else
                           0
                           @endif
                    </td>
                 </tr>
                 <tr>
                    <td colspan="5" align="right">Total</td>
                    <td>Fr.{{$commandeDetails['grand_total']}}</td>
                 </tr>
               </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr>
                    <td><strong>Adresse de livraison</strong></td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['name']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['address']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['rue']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['ville']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['pays']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['codepostal']}}</td>
                </tr>
                <tr>
                    <td>{{$commandeDetails['telephone']}}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr><hr>
        <tr><td>Pour Télécharger la Facture de la Commande <a href="{{url('admin/commande/telechargerpdf/'.$commandeDetails['id'])}}">Cliquez ici</a>   </td></tr>
        <tr><td>&nbsp;</td></tr><p></p>
        <hr>
      <tr><td>Pour toute question, vous pouvez nous contacter à l'adresse suivante: <a href="mailto:kanomagid@gmail.com">kanomagid@gmail.com</a></td></tr>
      <tr><td>&nbsp;&nbsp;</td></tr><p></p>
      <hr>
      <tr><td>Équipe Fasocom</td></tr>
      <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>