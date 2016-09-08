  $("#loginAdmin").submit(function(e){
    
    e.preventDefault();

    var data = $(this).serializeArray();
    data.push({ name: "namefunction", value: "verifyPasswordLogin" });

    $.ajax({
      url: "../admin/php/functions.php",
			type: "POST",
			data : data, 
      success: function(result){
       
        if(result=='0'){
          $('.not_name').css({'display':'block'});
          setTimeout(function(){
            $('.not_name').css({'display':'none'});
          }, 2000);
        }else{
          if(result=='-1'){
            $('.not_pass').css({'display':'block'});
            setTimeout(function(){
              $('.not_pass').css({'display':'none'});
            }, 2000);
          }else{
            $('.welcome').css({'display':'block'});
            setTimeout(function(){
              $('.welcome').css({'display':'none'});
              window.location.href = "listProducts.php";
            }, 2000);
          }
        }
      },
      error: function(error){
        alert('error');
      },
      complete: function(){
      },
			timeout: 10000
    });

  });