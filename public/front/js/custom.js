$(document).ready(function () {

  $("#getPrice").change(function(){
    var size = $(this).val();
    var product_id = $(this).attr("product-id");
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url:'/get-product-price',
      data: { size: size, product_id: product_id },
      type: 'post',
      success: function(resp) {
        // alert(resp.discount);
        var priceHtml = "<div class='price'><h4>Fr." + resp.final_price + "</h4></div>";
        if (resp.discount > 0) {
          $(".getAttributePrice").html(priceHtml);
        } else {
          $(".getAttributePrice").html(priceHtml); 
        }
      },error: function() {
        alert("Error");
      }
    });
  });
   //update panier
  $(document).on("click", ".updatePanierItem", function () {
    if ($(this).hasClass('plus-a')) {
        //Obtenir la quantité
        var quantity = $(this).data('qty');
        //Augmenter la quantité de 1
          new_qty = parseInt(quantity) + 1;
        // alert(new_qty);
    }

    if ($(this).hasClass('minus-a')) {
        //Obtenir la quantité
        var quantity = $(this).data('qty');
        //Diminuer la quantité de 1
        if (quantity <= 1) {
            alert("La quantité d'article doit être de 1 ou plus!");
            return false;
        }
           new_qty = parseInt(quantity) - 1;
        // alert(new_qty);
    }
    var panierid = $(this).data('panierid');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        data: { panierid:panierid, qty:new_qty },
        url: 'panier/update',
        type: 'post',
        success: function (resp) {
          $(".totalPanierItems").html(resp.totalPanierItems);
          if(resp.status==false){
            alert(resp.message);
          }
           $("#appendPanierItems").html(resp.view);
           $("#appendHeaderPanierItems").html(resp.headerview);
        },
        error: function () {
            alert("Erreur");
        }
    });
  });

  //delete panier 
  $(document).on("click", ".deletePanierItem", function () {
    var panierid = $(this).data('panierid');
    var result = confirm('Êtes-vous sûr de supprimer cet élément de panier');

    if(result){
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { panierid: panierid },
        url: 'panier/delete',
        type: 'post',
        success: function (resp) {
          $(".totalPanierItems").html(resp.totalPanierItems);
           $("#appendPanierItems").html(resp.view);
           $("#appendHeaderPanierItems").html(resp.headerview);  
        },
        error: function () {
            alert("Erreur");
        }
      });
    }
  });


    $(document).on("click", ".placerCommande", function(){
      $(".loader").show();
    });

  // inscription Form validation
  $("#registerForm").submit(function() {
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({ 
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        url: "/user/register",
        type: "POST",
        data: formdata,
        success: function(resp) {
          $(".loader").hide();
          if(resp.type=="error"){
            $.each(resp.errors,function(i,error){
              $("#register-"+i).attr('style','color:red');
              $("#register-"+i).html(error);
              setTimeout(function(){
                $("#register-"+i).css({'display':'none'});
              },3000);
            });
          } else if(resp.type=="success"){
            $(".loader").hide();
            window.location.href = resp.url;
          } 
        }
    });
  });

  // accunt user 
  $("#accountForm").submit(function() {
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({ 
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        url: "/user/account",
        type: "POST",
        data: formdata,
        success: function(resp) {
          $(".loader").hide();
          if(resp.type=="error"){
            $.each(resp.errors,function(i,error){
              $("#account-"+i).attr('style','color:red');
              $("#account-"+i).html(error);
              setTimeout(function(){
                $("#account-"+i).css({'display':'none'});
              },3000);
            });
          } else if(resp.type=="success"){
            $("#account-success").attr('style','color:green');
            $("#account-success").html(resp.message);
          }
        }
    });
  });

    // password user 
    $("#passwordForm").submit(function() {
      $(".loader").show();
      var formdata = $(this).serialize();
      $.ajax({ 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          url: "/user/update-password",
          type: "POST",
          data: formdata,
          success: function(resp) {
            $(".loader").hide();
            if(resp.type=="error"){
              $.each(resp.errors,function(i,error){
                $("#password-"+i).attr('style','color:red');
                $("#password-"+i).html(error);
                setTimeout(function(){
                  $("#password-"+i).css({'display':'none'});
                },3000);
              });
            } else if(resp.type=="incorrect"){
                $("#password-error").attr('style','color:red');
                $("#password-error").html(resp.message);
                setTimeout(function(){
                  $("#password-"+i).css({'display':'none'});
                },3000);
            } else if(resp.type=="success"){
              $("#password-success").attr('style','color:green');
              $("#password-success").html(resp.message);
            }
          }
      });
    });

  // connexion Form validation
   $("#loginForm").submit(function() {
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        url: "/user/login",
        type: "POST",
        data: formdata,
        success: function(resp) {
          $(".loader").hide();
          if(resp.type=="error"){
            $.each(resp.errors,function(i,error){
              $("#login-"+i).attr('style','color:red');
              $("#login-"+i).html(error);
            setTimeout(function(){
              $(".loader").hide();
              $("#login-"+i).css({'display':'none'});
            },3000);
          });
          }else if(resp.type=="incorrect"){
            $("#login-error").attr('style','color:red');
            $("#login-error").html(resp.message);
          }else if(resp.type=="inactive"){
            $("#login-error").attr('style','color:red');
            $("#login-error").html(resp.message);
          }else if(resp.type=="success"){
            $(".loader").hide();
            window.location.href = resp.url;
          }

        },error: function(error) { // Ajout de la gestion d'erreur
            alert("Error");
        }
    });
   });

  // mot de pas oublier validator 
  $("#forgotForm").submit(function() {
    $(".loader").show();
    var formdata = $(this).serialize();
    $.ajax({ 
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
        url: "/user/forgot-password",
        type: "POST",
        data: formdata,
        success: function(resp) {
          $(".loader").hide();
          if(resp.type=="error"){
            $.each(resp.errors,function(i,error){
              $("#forgot-"+i).attr('style','color:red');
              $("#forgot-"+i).html(error);
              setTimeout(function(){
                $("#forgot-"+i).css({'display':'none'});
              },3000);
            });
          } else if(resp.type=="success"){
            $("#forgot-success").attr('style','color:green');
            $("#forgot-success").html(resp.message);
          }
        }
    });
  });

      //Apply coupon code 
      $("#ApplyCoupon").submit(function(){
        var user = $(this).attr("user");
        if(user==1){

        }else{
          alert("Veuillez vous connecter pour appliquer le coupon");
          return false;
        }
        var code = $("#code").val();
        $.ajax({ 
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            type: "POST",
            data: {code:code},
            url: "/apply-coupon",
            success: function(resp) {
                 if(resp.message!=""){
                   alert(resp.message);
                 }
                 $(".totalPanierItems").html(resp.totalPanierItems);
                 $("#appendPanierItems").html(resp.view);
                 $("#appendHeaderPanierItems").html(resp.headerview);
                 if(resp.CouponAmount>0){
                    alert(resp.CouponAmount);
                   $(".couponAmount").text("Fr."+resp.couponAmount);
                 }else{
                   $(".couponAmount").text("Fr.0");
                 }
                 if(resp.grand_total>0){
                   $(".grand_total").text("Fr."+resp.grand_total);
                 }
              },error:function(){
                alert("Error");
              }
     });

      }); 

   $(document).on('click','.editAddress',function(){
      var addressid = $(this).data("addressid");
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{addressid:addressid},
          url:"get-delivery-address",
          type:"post",
          success:function(resp){
            $("#showdifferent").removeClass("collapse");
            $(".newAddress").hide();
            $(".deliveryText").text("Modifier l'adresse de livraison");
            $('[name=delivery_id]').val(resp.address['id']);
            $('[name=delivery_name]').val(resp.address['name']);
            $('[name=delivery_address]').val(resp.address['address']);
            $('[name=delivery_ville]').val(resp.address['ville']);
            $('[name=delivery_pays]').val(resp.address['pays']);
            $('[name=delivery_rue]').val(resp.address['rue']);
            $('[name=delivery_codepostal]').val(resp.address['codepostal']);
            $('[name=delivery_telephone]').val(resp.address['telephone']);
          },error:function(){
            alert("Error");
          }
        });
   })

   // save delivery 
   $(document).on('submit', '#addressAddEditForm', function () {
    var formdata = $('#addressAddEditForm').serialize();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/save-address-address",
        type: "post",
        data: formdata,
        success:function(resp){
          if(resp.type=="error"){
          $(".loader").hide();
            $.each(resp.errors,function(i,error){
              $("#delivery-"+i).attr('style','color:red');
              $("#delivery-"+i).html(error);
              setTimeout(function(){
                $("#delivery-"+i).css({'display':'none'});
              },3000);
            });
          }else{
            $("#deliveryAddresses").html(resp.view);
            window.location.href = "checkout";
          }
        },
        error: function (xhr, status, error) {
            console.error('Erreur lors de la requête Ajax:', status, error);
            alert("Une erreur s'est produite lors de la sauvegarde de l'adresse.");
        }
    });
 });

 //delete address delivery 
 $(document).on('click','.removeAddress', function () {
    if(confirm("Are you sure to remove this,")){
      var addressid = $(this).data("addressid");
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/remove-address-address",
        type: "post",
        data: {addressid:addressid},
        success:function(resp){
          $("#deliveryAddresses").html(resp.view);
          window.location.href = "checkout";
        },error:function(){
          alert("Error");
        }
      })
    };
 });

    $("input[name=address_id]").bind('change', function(){
      var shipping_charges = $(this).attr("shipping_charges");
      var total_price = $(this).attr("total_price");
      var coupon_amount = $(this).attr("coupon_amount");
         $(".shipping_charges").html("Fr."+shipping_charges);
         if(coupon_amount==""){
          coupon_amount = 0;
         }
         $(".couponAmount").html("Fr."+couponAmount);
         var grand_total = parseInt(total_price) + parseInt(shipping_charges) - parseInt(coupon_amount);
         $(".grand_total").html("Fr."+grand_total);

    });



   $("#sort").on("change",function(){
    //  this.form.submit();
    var sort = $("#sort").val();
    var url = $("#url").val();
    // alert(url); return false;
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      url:url,
      method:'post',
      data:{sort:sort,url:url},
      success:function(data){
        $('.filter_products').html(data);
      },error:function(){
        alert(Error);
      }
    })
   });
});
