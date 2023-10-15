$(document).ready(function(){
  $("#getPrice").change(function(){
    var size = $(this).val();
    var product_id = $(this).attr("product-id");
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
      url:'/get-product-price',
      data:{size:size,product_id:product_id},
      type:'post',
      success:function(resp){
        alert(resp['discount']);
        if(resp['discount']>0){
          $(".getAttributePrice").html("");
        } else{
          $(".getAttributePrice").html("<div class='price'><h4>Fr."+resp['final_price']+"</h4></div>"); 
        }
      },error:function(){
        alert("Error");
      }
    });
  });
});

$(document).ready(function(){
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