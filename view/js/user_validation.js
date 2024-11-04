$(document).ready(function (){

    $.getJSON('../json/locs.json',function (data) {
        js=data;
        $.each(data,function (key,value) {
            console.log(key,value);

            $.each(value.options,function (key2,value2) {
                console.log(value2);
                $("#Hometown").append("<option value='"+value2+","+key+"'>"+value2+" , "+key+" </option>");
            })
        })
    });

    $("#user_role").change(function(){
        var url="../controller/user_controller.php?status=getfunctions";

        var x= $("#user_role").val();
     $.post(url,{role_id:x},function(data){
            $("#myfunctions").html(data).show();
        });

    });

        var myInput = document.getElementById("psw");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

        // Validate length
        if(myInput.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
    }

    $("#addUser").submit(function (){
        
        var fname=$("#fname").val();
        var lname=$("#lname").val();
        var user_email=$("#uemail").val();
        var dob=$("#psw").val();
        var nic=$("#unic").val();
        var cno1=$("#tel1").val();
        var cno2=$("#tel2").val();
        var user_role=$("#user_role").val();


        if(fname=="")
      {
          $("#alertDiv").html("First Name Cannot be Empty!!!");
          $("#alertDiv").addClass("alert alert-danger");
          $("#fname").focus();
          return false;
      }
      if(lname=="")
      {
          $("#alertDiv").html("Last Name Cannot be Empty!!!");
          $("#alertDiv").addClass("alert alert-danger");
          $("#lname").focus();
          return false;
      }

      if(nic=="")
      {
          $("#alertDiv").html("NIC Cannot be Empty!!!");
          $("#alertDiv").addClass("alert alert-danger");
          $("#unic").focus();
          return false;
      }

       if(cno1=="")
        {
            $("#alertDiv").html("Contact Number 1 Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#tel1").focus();
            return false;
        }
        if(cno2=="")
        {
            $("#alertDiv").html("Contact Number 1 Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#tel2").focus();
            return false;
        }
        if(user_email=="")
        {
            $("#alertDiv").html("Email Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#uemail").focus();
            return false;
        }
        if(dob=="")
        {
            $("#alertDiv").html("Date of Birth Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#dob").focus();
            return false;
        }
        if(user_role=="")
        {
            $("#alertDiv").html("User role Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#user_role").focus();
            return false;
        }

      var patnic=/^[0-9]{9}[vVxX]|[0-9]{12}$/;
      var patcno=/^\+94[0-9]{9}$/;
      var patmob=/^\+947[0-9]{8}$/;
      var patemail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/;

      if(!nic.match(patnic))
      {
          $("#alertDiv").html("NIC is Invalid");
          $("#alertDiv").addClass("alert alert-danger");
          $("#unic").focus();
          return false;
      }
       if(!cno1.match(patcno))
      {
          $("#alertDiv").html("Contact Number 1 is Invalid");
          $("#alertDiv").addClass("alert alert-danger");
          $("#tel1").focus();
          return false;
      }
       if((cno2!="")&&(!cno2.match(patmob)))
      {
          $("#alertDiv").html("Contact Number 2(Mobile) is Invalid");
          $("#alertDiv").addClass("alert alert-danger");
          $("#tel2").focus();
          return false;
      }

      if(!user_email.match(patemail))
      {
          $("#alertDiv").html("Email is Invalid");
          $("#alertDiv").addClass("alert alert-danger");
          $("#user_email").focus();
          return false;
          
      }
      

      
   });
    $("#editUser").submit(function (){

        var editUserfname=$("#editUserfname").val();
        var editUserlname=$("#editUserlname").val();
        var editUserNIC=$("#editUserNIC").val();
        var editUserDOB=$("#editUserDOB").val();
        var editUserCno1=$("#editUserCno1").val();
        var editUserCno2=$("#editUserCno2").val();
        var editUserEmail=$("#editUserEmail").val();
        var editUserRole=$("#editUserRole").val();



        if(editUserfname=="")
        {
            $("#alertDiv").html("First Name Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserfname").focus();
            return false;
        }
        if(editUserlname=="")
        {
            $("#alertDiv").html("Last Name Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserlname").focus();
            return false;
        }
        if(editUserEmail=="")
        {
            $("#alertDiv").html("Email Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserEmail").focus();
            return false;
        }
        if(editUserDOB=="")
        {
            $("#alertDiv").html("Date of Birth Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserDOB").focus();
            return false;
        }
        if(editUserNIC=="")
        {
            $("#alertDiv").html("NIC Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserNIC").focus();
            return false;
        }

        if(editUserCno1=="")
        {
            $("#alertDiv").html("Contact Number 1 Cannot be Empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#editUserCno1").focus();
            return false;
        }
        var patnic=/^[0-9]{9}[vVxX]|[0-9]{12}$/;

        var patcno=/^\+94[0-9]{9}$/;

        var patmob=/^\+947[0-9]{8}$/;

        var patemail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/;



    });
    navigatetopage=function(x) {
        // alert(x);
        /*emp name is obtained to check in search*/
        var search_user_name=$("#search_user_name").val();
        var search_role=$("#search_role").val();
        var search_status=$("#state").val();

        alert(search_status);
        var url="../controller/user_controller.php?status=paginate";
        /*ajax request is made*/
        /*no need variable x as we are passing it in function */
        $.post(url,{page:x,search_user_name:search_user_name,search_role:search_role,search_status:search_status},function(data){
            /*show the data that is being responded by server in the div id myfunctions*/
            $("#userCont").html(data).show();
        });




    }


});