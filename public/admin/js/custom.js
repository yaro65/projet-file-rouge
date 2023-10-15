// JavaScript
$(document).ready(function(){
    //call datatable 
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#marques').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();

    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");
    var typingTimer;                // Timer identifier
    var doneTypingInterval = 1000;  // Délai de saisie en millisecondes (1 seconde)

    function checkAdminPassword(){
        var current_password = $("#current_password").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-admin-password',
            data: {current_password: current_password},
            success: function(resp){
                if(resp == "false"){
                    $("#check_password").html("<font color='red'>Le mot de passe est incorrect!</font>");
                } else if(resp == "true"){
                    $("#check_password").html("<font color='green'>Le mot de passe est correct!</font>");
                }
            },
            error: function(){
                alert('Error');
            }
        });
    }

    $("#current_password").keyup(function(){
        clearTimeout(typingTimer);
        if ($("#current_password").val()) {
            typingTimer = setTimeout(checkAdminPassword, doneTypingInterval);
        } else {
            $("#check_password").html("");
        }
    });
    //update admin 
    $(document).on("click",".updateAdminStatus",function(){
        var status = $(this).children("i").attr("status");
        var admin_id =$(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-admin-status',
            data:{status:status,admin_id:admin_id},
            success:function(resp){
               if(resp['status']==0){
                $("#admin-"+admin_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
               } else if(resp['status']==1){
                $("#admin-"+admin_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        })
    })

    //update section

    $(document).on("click",".updateSectionStatus",function(){
        var status = $(this).children("i").attr("status");
        var section_id =$(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
               if(resp['status']==0){
                $("#section-"+section_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
               } else if(resp['status']==1){
                $("#section-"+section_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        })
    })

    //confirm
    // $(".confirmDelete").click(function(){
    //     var title = $(this).attr("title");
    //     if(confirm("Êtes-vous sûr de supprimer cette "+title+"?")){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // })
    // $(".confirmDelete").click(function(){
    $(document).on("click",".confirmDelete",function(){
        var module = $(this).attr("module");
        var moduleid = $(this).attr("moduleid");
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprime-le!',
            cancelButtonText: 'Retour'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Supprimé!',
                'Votre fichier a été supprimé.',
                'success'
              )
              window.location= "/admin/delete-"+module+"/"+moduleid;
            }
          })
    })


  //update categorie
    $(document).on("click",".updateCategoryStatus",function(){
        var status = $(this).children("i").attr("status");
        var category_id =$(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(resp){
               if(resp['status']==0){
                $("#category-"+category_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
               } else if(resp['status']==1){
                $("#category-"+category_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        })
    })

   ///update banner 
   $(document).on("click",".updateBannerStatus",function(){
    var status = $(this).children("i").attr("status");
    var banner_id =$(this).attr("banner_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        url:'/admin/update-banner-status',
        data:{status:status,banner_id:banner_id},
        success:function(resp){
           if(resp['status']==0){
            $("#banner-"+banner_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
           } else if(resp['status']==1){
            $("#banner-"+banner_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
           }
        },error:function(){
            alert("Error");
        }
    })
})
    
  //update marque
  $(document).on("click",".updateMarqueStatus",function(){
    var status = $(this).children("i").attr("status");
    var marque_id =$(this).attr("marque_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        url:'/admin/update-marque-status',
        data:{status:status,marque_id:marque_id},
        success:function(resp){
           if(resp['status']==0){
            $("#marque-"+marque_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
           } else if(resp['status']==1){
            $("#marque-"+marque_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
           }
        },error:function(){
            alert("Error");
        }
    })
})


 //update product
 $(document).on("click",".updateProductStatus",function(){
    var status = $(this).children("i").attr("status");
    var product_id =$(this).attr("product_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        url:'/admin/update-product-status',
        data:{status:status,product_id:product_id},
        success:function(resp){
           if(resp['status']==0){
            $("#product-"+product_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
           } else if(resp['status']==1){
            $("#product-"+product_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
           }
        },error:function(){
            alert("Error");
        }
    })
})

    //update attributes status
    $(document).on("click",".updateAttributeStatus",function(){
        var status = $(this).children("i").attr("status");
        var attribute_id =$(this).attr("attribute_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-attribute-status',
            data:{status:status,attribute_id:attribute_id},
            success:function(resp){
               if(resp['status']==0){
                $("#attribute-"+attribute_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
               } else if(resp['status']==1){
                $("#attribute-"+attribute_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
               }
            },error:function(){
                alert("Error");
            }
        })
    })

        //update image status
        $(document).on("click",".updateImageStatus",function(){
            var status = $(this).children("i").attr("status");
            var image_id =$(this).attr("image_id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-image-status',
                data:{status:status,image_id:image_id},
                success:function(resp){
                   if(resp['status']==0){
                    $("#image-"+image_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                   } else if(resp['status']==1){
                    $("#image-"+image_id).html("<i  style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                   }
                },error:function(){
                    alert("Error");
                }
            })
        })
    //Append categorie level

    $("#section_id").change(function(){
        var section_id = $(this).val();  // Utilisez la même variable dans la déclaration et dans la data de la requête AJAX
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/admin/append-categories-level',
            data: { section_id:section_id },  // Utilisez la variable correcte ici
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);
            },
            error: function() {
                alert("Erreur");
            }
        });
    });

     //product attributes
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var x = 1; //Initial field counter is 1
    var fieldHTML = '<div> <div style="height:10px;">  </div><input type="text" name="size[]" placeholder="Size" style="width: 110px;"/>&nbsp;<input type="text" name="sku[]" placeholder="Sku" style="width: 110px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 110px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 110px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Sup</a></div>'; //New input field html 
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });
    

});
