
   <!-- Form-Fields /- -->
   <h4 class="section-h4 deliveryText">Ajouter une nouvelle adresse de livraison</h4>
   <div class="u-s-m-b-24">
       <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
       @if (count($deliveryAddresses)>0)
       <label class="label-text newAddress" for="ship-to-different-address">Expédier vers une adresse différente ?</label>
       @else
       <label class="label-text newAddress" for="ship-to-different-address">Check to add Delivery address</label>
       @endif
   </div>
   <div class="collapse" id="showdifferent">
    <form id="addressAddEditForm" action="javascript:;" method="post">@csrf
       <!-- Form-Fields -->
        <input type="hidden" name="delivery_id">
       <div class="group-inline u-s-m-b-13">
           <div class="group-1 u-s-p-r-16">
               <label for="first-name-extra">Nom
                   <span class="astk">*</span>
               </label>
              <input type="text" name="delivery_name" id="delivery_name" class="text-field">
              <p id="delivery-delivery_name"></p>
           </div>
            <div class="group-2">
              <label for="last-name-extra">Address
               <span class="astk">*</span>
              </label>
              <input type="text" name="delivery_address" id="delivery_address" class="text-field">
              <p id="delivery-delivery_address"></p>
           </div>
       </div>
        <div class="group-inline u-s-m-b-13">
          <div class="group-1 u-s-p-r-16">
             <label for="first-name-extra">Ville
               <span class="astk">*</span>
              </label>
             <input type="text" name="delivery_ville" id="delivery_ville" class="text-field">
              <p id="delivery-delivery_ville"></p>
          </div>
          <div class="group-2">
            <label for="last-name-extra">Rue
               <span class="astk">*</span>
            </label>
            <input type="text" name="delivery_rue" id="delivery_rue" class="text-field">
              <p id="delivery-delivery_rue"></p>
          </div>
       </div>  
   <div class="u-s-m-b-13">
       <label for="select-country-extra">Country
           <span class="astk">*</span>
      </label>
      <div class="select-box-wrapper">
      <select class="select-box" name="delivery_pays" id="delivery_pays" style="color:495057;">
          <option value="">Selection votre pays</option>
          @foreach($countries as $country)
            <option value="{{$country['pays']}}" @if($country['pays']==Auth::user()->country) selected @endif >
            {{$country['pays']}}
              </option>
          @endforeach
      </select>
      <p id="delivery-delivery_pays"></p>
      </div>
  </div>
                                
  <div class="u-s-m-b-13">
      <label for="postcode-extra">Code Postal
          <span class="astk">*</span>
      </label>
      <input type="text" name="delivery_codepostal" id="delivery_codepostal" class="text-field">
      <p id="delivery-delivery_codepostal"></p>
  </div>
  <div class="u-s-m-b-13">
      <label for="postcode-extra">telephone
          <span class="astk">*</span>
      </label>
      <input type="text" name="delivery_telephone" id="delivery_telephone" class="text-field">
      <p id="delivery-delivery_telephone"></p>
  </div> 
          <button style="width:100%;" type="submit" class="button button-outline-secondary" >Enregistrer</button>
      <!-- Form-Fields /- -->
   </form>
</div>
  <div>
      <label for="order-notes">Order Notes</label>
      <textarea class="text-area" id="order-notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
  </div>
