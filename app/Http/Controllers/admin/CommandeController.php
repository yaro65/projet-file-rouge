<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\CommandesProduct;
use App\Models\User;
use App\Models\CommandesStatus;
use App\Models\CommandeItemStatus;
use App\Models\CommandesLog;
use Session;
use Auth;
use Dompdf\Dompdf;
class CommandeController extends Controller
{
    public function Commandes()
    {
        Session::put('page','commandes');
        $adminType = Auth::guard('admin')->user()->type;
        $vendeur_id = Auth::guard('admin')->user()->vendeur_id;
        if($adminType=="vendeur"){
              $vendeurStatus = Auth::guard('admin')->user()->status;
              if($vendeurStatus==0){
                return redirect("mdifier_fournisseur/profile")->with('error_message','Votre compte vendeur n"est pas approuver. Assurer vous que les information de votre boutique, et de votre bank sont bien corecte!');
              }
        }
        if($adminType=="vendeur"){
            $commandes = Commande::with(['commandes_products'=>function($query)use($vendeur_id){
                $query->where('vendeur_id',$vendeur_id);
            }])->orderby('id','Desc')->get()->toArray();
        }else{
            $commandes = Commande::with(['commandes_products'])->orderby('id','Desc')->get()->toArray();
        }
        // dd($commandes);
        return view('admin.commandes.commandes')->with(compact('commandes'));
    }

    public function DetailsCommandes($id)
    {
        Session::put('page','commandes');
        $adminType = Auth::guard('admin')->user()->type;
        $vendeur_id = Auth::guard('admin')->user()->vendeur_id;
        if($adminType=="vendeur"){
              $vendeurStatus = Auth::guard('admin')->user()->status;
              if($vendeurStatus==0){
                return redirect("mdifier_fournisseur/profile")->with('error_message','Votre compte vendeur n"est pas approuver. Assurer vous que les information de votre boutique, et de votre bank sont bien corecte!');
              }
        }
        if($adminType=="vendeur"){
         $commandeDetails = Commande::with(['commandes_products'=>function($query)use($vendeur_id){
            $query->where('vendeur_id',$vendeur_id);
        }])->where('id',$id)->first()->toArray();
        // dd($commandeDetails);
        }else{
         $commandeDetails = Commande::with('commandes_products')->where('id',$id)->first()->toArray();
        }
         $userDetails = User::where('id',$commandeDetails['user_id'])->first()->toArray();
         $commandesStatus = CommandesStatus::where('status',1)->get()->toArray();
         $commandeItemStatus = CommandeItemStatus::where('status',1)->get()->toArray();
         $commandeLog = CommandesLog::with('commandes_products')->where('commande_id',$id)->get()->toArray();
        //   dd($commandeLog);
         return view('admin.commandes.commande_details')->with(compact('commandeDetails','userDetails','commandesStatus','commandeItemStatus','commandeLog'));    
       
    }

    public function updateCommandeStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Commande::where('id',$data['commande_id'])->update(['commande_status'=>$data['commande_status']]);

            // update courier name 
            if(!empty($data['courier_name'])&&!empty($data['tracking_number'])){
                Commande::where('id',$data['commande_id'])->update(['courier_name'=>$data['courier_name'],'tracking_number'=>$data['tracking_number']]);
                 
            }
            $log = New CommandesLog;
            $log->commande_id = $data['commande_id'];
            $log->commande_status = $data['commande_status'];
            $log->save();


            $deliveryDetails = Commande::select('telephone','email','name')->where('id',$data['commande_id'])->first()->toArray();

            $commandeDetails = Commande::with('commandes_products')->where('id',$data['commande_id'])->first()->toArray();
            // envoi d'email 
            if(!empty($data['courier_name'])&&!empty($data['tracking_number'])){
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'commande_id' => $data['commande_id'],
                    'commandeDetails' => $commandeDetails,
                    'commande_status'=>$data['commande_status'],
                    'courier_name'=>$data['courier_name'],
                    'tracking_number'=>$data['tracking_number']
                ];
                Mail::send('emails.commande_status',$messageData , function($message)use($email){
                    $message->to($email)->subject('Mise à jour du statut de la commande - Fasocom.com');
                 });
            }else{
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'commande_id' => $data['commande_id'],
                    'commandeDetails' => $commandeDetails,
                    'commande_status'=>$data['commande_status']
                ];
                Mail::send('emails.commande_status',$messageData , function($message)use($email){
                    $message->to($email)->subject('Mise à jour du statut de la commande - Fasocom.com');
                 });
            }
           

            $message = "L'état de la commande a été mis à jour avec succès !";
            return redirect()->back()->with('success_message',$message);
        }
    }
    public function updateCommandeItemStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            CommandesProduct::where('id',$data['commande_item_id'])->update(['item_status'=>$data['commande_item_status']]);
           
            // update courier name 
            if(!empty($data['item_courier_name'])&&!empty($data['item_tracking_number'])){
                CommandesProduct::where('id',$data['commande_item_id'])->update(['item_courier_name'=>$data['item_courier_name'],'item_tracking_number'=>$data['item_tracking_number']]);   
            }

            $getCommandeId = CommandesProduct::select('commande_id')->where('id',$data['commande_item_id'])->first()->toArray();

            $log = New CommandesLog;
            $log->commande_id = $getCommandeId['commande_id'];
            $log->commande_item_id = $data['commande_item_id'];
            $log->commande_status = $data['commande_item_status'];
            $log->save();
           
            $deliveryDetails = Commande::select('telephone','email','name')->where('id',$getCommandeId['commande_id'])->first()->toArray();

            $commandeDetails = Commande::with('commandes_products')->where('id',$getCommandeId['commande_id'])->first()->toArray();
            // envoi d'email 
            // $email = $deliveryDetails['email'];
            // $messageData = [
            //     'email' => $email,
            //     'name' => $deliveryDetails['name'],
            //     'commande_id' => $getCommandeId['commande_id'],
            //     'commandeDetails' => $commandeDetails,
            //     'commande_status'=>$data['commande_item_status']
            // ];
            // Mail::send('emails.commande_status',$messageData , function($message)use($email){
            //     $message->to($email)->subject('Mise à jour du statut de la commande - Fasocom.com');
            //  });

            $message = "L'état de la commande a été mis à jour avec succès !";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function Viewcommandepdf($commande_id)
    {
        $commandeDetails = Commande::with('commandes_products')->where('id',$commande_id)->first()->toArray();
        $user_id = $commandeDetails['user_id'];
        $userDetails = User::where('id',$commandeDetails['user_id'])->first()->toArray();

        return view('admin.commandes.commande_invoice')->with(compact('commandeDetails','userDetails'));    
    }

    public function commandepdf($commande_id)
    {
        $commandeDetails = Commande::with('commandes_products')->where('id',$commande_id)->first()->toArray();
        $user_id = $commandeDetails['user_id'];
        $userDetails = User::where('id',$commandeDetails['user_id'])->first()->toArray();
        
        $invoiceHTML ='<!DOCTYPE html>
        <html>
        <head>
            <title>HTML to API - Invoice</title>
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta http-equiv="content-type" content="text-html; charset=utf-8">
            <style type="text/css">
                html, body, div, span, applet, object, iframe,
                h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                a, abbr, acronym, address, big, cite, code,
                del, dfn, em, img, ins, kbd, q, s, samp,
                small, strike, strong, sub, sup, tt, var,
                b, u, i, center,
                dl, dt, dd, ol, ul, li,
                fieldset, form, label, legend,
                table, caption, tbody, tfoot, thead, tr, th, td,
                article, aside, canvas, details, embed,
                figure, figcaption, footer, header, hgroup,
                menu, nav, output, ruby, section, summary,
                time, mark, audio, video {
                    margin: 0;
                    padding: 0;
                    border: 0;
                    font: inherit;
                    font-size: 100%;
                    vertical-align: baseline;
                }
        
                html {
                    line-height: 1;
                }
        
                ol, ul {
                    list-style: none;
                }
        
                table {
                    border-collapse: collapse;
                    border-spacing: 0;
                }
        
                caption, th, td {
                    text-align: left;
                    font-weight: normal;
                    vertical-align: middle;
                }
        
                q, blockquote {
                    quotes: none;
                }
                q:before, q:after, blockquote:before, blockquote:after {
                    content: "";
                    content: none;
                }
        
                a img {
                    border: none;
                }
        
                article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                    display: block;
                }
        
                body {
                    font-family: "Source Sans Pro", sans-serif;
                    font-weight: 300;
                    font-size: 12px;
                    margin: 0;
                    padding: 0;
                }
                body a {
                    text-decoration: none;
                    color: inherit;
                }
                body a:hover {
                    color: inherit;
                    opacity: 0.7;
                }
                body .container {
                    min-width: 500px;
                    margin: 0 auto;
                    padding: 0 20px;
                }
                body .clearfix:after {
                    content: "";
                    display: table;
                    clear: both;
                }
                body .left {
                    float: left;
                }
                body .right {
                    float: right;
                }
                body .helper {
                    display: inline-block;
                    height: 100%;
                    vertical-align: middle;
                }
                body .no-break {
                    page-break-inside: avoid;
                }
        
                header {
                    margin-top: 20px;
                    margin-bottom: 50px;
                }
                header figure {
                    float: left;
                    width: 60px;
                    height: 60px;
                    margin-right: 10px;
                    background-color: #8BC34A;
                    border-radius: 50%;
                    text-align: center;
                }
                header figure img {
                    margin-top: 13px;
                }
                header .company-address {
                    float: left;
                    max-width: 150px;
                    line-height: 1.7em;
                }
                header .company-address .title {
                    color: #8BC34A;
                    font-weight: 400;
                    font-size: 1.5em;
                    text-transform: uppercase;
                }
                header .company-contact {
                    float: right;
                    height: 60px;
                    padding: 0 10px;
                    background-color: #8BC34A;
                    color: white;
                }
                header .company-contact span {
                    display: inline-block;
                    vertical-align: middle;
                }
                header .company-contact .circle {
                    width: 20px;
                    height: 20px;
                    background-color: white;
                    border-radius: 50%;
                    text-align: center;
                }
                header .company-contact .circle img {
                    vertical-align: middle;
                }
                header .company-contact .phone {
                    height: 100%;
                    margin-right: 20px;
                }
                header .company-contact .email {
                    height: 100%;
                    min-width: 100px;
                    text-align: right;
                }
        
                section .details {
                    margin-bottom: 55px;
                }
                section .details .client {
                    width: 50%;
                    line-height: 20px;
                }
                section .details .client .name {
                    color: #8BC34A;
                }
                section .details .data {
                    width: 50%;
                    text-align: right;
                }
                section .details .title {
                    margin-bottom: 15px;
                    color: #8BC34A;
                    font-size: 3em;
                    font-weight: 400;
                    text-transform: uppercase;
                }
                section table {
                    width: 100%;
                    border-collapse: collapse;
                    border-spacing: 0;
                    font-size: 0.9166em;
                }
                section table .qty, section table .unit, section table .total {
                    width: 15%;
                }
                section table .desc {
                    width: 55%;
                }
                section table thead {
                    display: table-header-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                section table thead th {
                    padding: 5px 10px;
                    background: #8BC34A;
                    border-bottom: 5px solid #FFFFFF;
                    border-right: 4px solid #FFFFFF;
                    text-align: right;
                    color: white;
                    font-weight: 400;
                    text-transform: uppercase;
                }
                section table thead th:last-child {
                    border-right: none;
                }
                section table thead .desc {
                    text-align: left;
                }
                section table thead .qty {
                    text-align: center;
                }
                section table tbody td {
                    padding: 10px;
                    background: #E8F3DB;
                    color: #777777;
                    text-align: right;
                    border-bottom: 5px solid #FFFFFF;
                    border-right: 4px solid #E8F3DB;
                }
                section table tbody td:last-child {
                    border-right: none;
                }
                section table tbody h3 {
                    margin-bottom: 5px;
                    color: #8BC34A;
                    font-weight: 600;
                }
                section table tbody .desc {
                    text-align: left;
                }
                section table tbody .qty {
                    text-align: center;
                }
                section table.grand-total {
                    margin-bottom: 45px;
                }
                section table.grand-total td {
                    padding: 5px 10px;
                    border: none;
                    color: #777777;
                    text-align: right;
                }
                section table.grand-total .desc {
                    background-color: transparent;
                }
                section table.grand-total tr:last-child td {
                    font-weight: 600;
                    color: #8BC34A;
                    font-size: 1.18181818181818em;
                }
        
                footer {
                    margin-bottom: 20px;
                }
                footer .thanks {
                    margin-bottom: 40px;
                    color: #8BC34A;
                    font-size: 1.16666666666667em;
                    font-weight: 600;
                }
                footer .notice {
                    margin-bottom: 25px;
                }
                footer .end {
                    padding-top: 5px;
                    border-top: 2px solid #8BC34A;
                    text-align: center;
                }
            </style>
        </head>
        
        <body>
            <header class="clearfix">
                <div class="container">
                   
                    <div class="company-address">
                        <h2 class="title">FasoCom</h2>
                        <p> 
                            Secteur10 Ouaga,<br>
                            BP 8504, Burkina Faso
                        </p>
                    </div>
                    <div class="company-contact">
                        <div class="phone left">
                        <span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
                            <a href="tel:602-519-0450"></a>
                            <span class="helper"></span>
                        </div>
                        <div class="email right">
                            <a href="mailto:fasocom@gmail.com">fasocom@gmail.com</a>
                            <span class="helper"></span>
                        </div>
                    </div>
                </div>
            </header>
        
            <section>
                <div class="container">
                    <div class="details clearfix">
                        <div class="client left">
                            <p>FACTURER A:</p>
                            <p class="name">'.$commandeDetails['name'].'</p>
                            <p>'.$commandeDetails['address'].' '.$commandeDetails['ville'].' '.$commandeDetails['rue'].'
                            '.$commandeDetails['pays'].'-'.$commandeDetails['codepostal'].'</p>
                            <a href="mailto:'.$commandeDetails['email'].'">'.$commandeDetails['email'].'</a>
                        </div>
                        <div class="data right">
                            <div class="title">Commande Id# '.$commandeDetails['id'].'</div>
                            <div class="date">
                               Date de commande :'.date('Y-m-d h:i:s', strtotime($commandeDetails['created_at'])).' <br>
                               Montant de la commande : '.$commandeDetails['grand_total'].' <br>
                               Statut de la commande : '.$commandeDetails['commande_status'].' <br>
                               Méthode de paiement: '.$commandeDetails['payment_method'].' <br>
                            </div>
                        </div>
                    </div>
        
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="desc">Code du Produit</th>
                                <th class="qty">Taille du Produit</th>
                                <th class="qty">Couleur du Produit</th>
                                <th class="qty">Quantité du Produit</th>
                                <th class="unit">Prix du Produit</th>
                                <th class="total">Total</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $subtotal = 0 ;
                        foreach($commandeDetails['commandes_products'] as $product){
                            $invoiceHTML .='  
                               <tr>
                                    <td class="desc">'.$product['product_code'].'</td>
                                    <td class="qty">'.$product['product_size'].'</td>
    							  	<td class="qty">'.$product['product_color'].'</td>
    							  	<td class="qty">'.$product['product_qty'].'</td>
    							  	<td class="unit">'.$product['product_price'].' .Fr</td>
    							  	<td class="total">'.$product['product_price']*$product['product_qty'].' .Fr</td>
                                </tr>';
                         $subtotal = $subtotal + ($product['product_price']*$product['product_qty']);
                        }
                        $invoiceHTML .=' 
                        </tbody>
                    </table>
                    <div class="no-break">
                        <table class="grand-total">
                            <tbody>
                                <tr>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="total" colspan=2>Total</td>
                                    <td class="total">'. $subtotal.'</td>
                                </tr>
                                <tr>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="total" colspan=2>Frais de livraison:</td>
                                    <td class="total">0.Fr</td>
                                </tr>
                                <tr>
                                     <td class="desc"></td>
                                     <td class="desc"></td>
                                     <td class="desc"></td>
                                     <td class="total" colspan=2>Coupon discount:</td>';
                                     if($commandeDetails['coupon_amount']>0){
                                        $invoiceHTML .=' <td class="total">'.$commandeDetails['coupon_amount'].'.Fr</td>';
                                     }else{
                                        $invoiceHTML .='<td class="total">0.Fr</td> ';
                                     }
                                     $invoiceHTML .='
                                </tr>
                                <tr>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="desc"></td>
                                    <td class="total" colspan="2">TOTAL</td>
                                    <td class="total">'.$commandeDetails['grand_total'].'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        
            <footer>
                <div class="container">
                    <div class="thanks">Merci !</div>
                    <div class="notice">
                        <div>NOTIFICATION</div>
                        <div>Une charge financière de 1,5 % sera appliquée sur les soldes impayés après 30 jours.</div>
                    </div>
                    <div class="end">La facture a été créée sur un ordinateur et est valide sans la signature et le cachet.</div>
                </div>
            </footer>
        
        </body>
        
        </html>
        ';
        // instantiate and use the dompdf class
         $dompdf = new Dompdf();
         $dompdf->loadHtml($invoiceHTML);

         // (Optional) Setup the paper size and orientation
         $dompdf->setPaper('A4', 'landscape');

         // Render the HTML as PDF
         $dompdf->render();

         // Output the generated PDF to Browser
         $dompdf->stream();

    }
}
