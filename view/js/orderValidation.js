$(document).ready(function (){
    $("#payslipNo").val("TC - 20E - "+$("#payslipId").val());

    $(":input").inputmask();
    $("#tel1").inputmask({"mask": "+99999999999"});
    $("#tel3").inputmask({"mask": "+99999999999"});
    $("#tel4").inputmask({"mask": "+99999999999"});
    $("#tel5").inputmask({"mask": "+99999999999"});

    uploadDoc=function (){
        var url="../controller/order_controller.php?status=Upload_Document";
        var x= $("#itemtype").val();
        $.post(url,{item_id:x},function(data){
            $("#document-row").html(data).show();

        });

    }
    loadRate=function (){
        var destination_id=$("#destination").val();

        var url="../controller/order_controller.php?status=get_rate";

        $.post(url,{destination_id:destination_id},function(data){
            $("#rateRow").html(data).show();

        });
    }

    var js;

    $.getJSON('../json/countries.json',function (data) {
        js=data;
        $.each(data,function (key,value) {
            console.log(key);
            $("#countryId").append("<option value='"+key+"'>"+key+"</option>");

            $("#countryId2").append("<option value='"+key+"'>"+key+"</option>");


        });

    });

    $("#countryId").change(function () {
        var country=$("#countryId").val();
        var countryCities=js[country];

        // alert(countryCities);

        $.each(countryCities,function (key,value) {
            console.log(key);
            $("#stateId").append("<option value='"+value+"'>"+value+"</option>");
        });

    });


    $.getJSON('../json/locs.json',function (data) {
        js=data;
        $.each(data,function (key,value) {
            console.log(key,value);

            $.each(value.options,function (key2,value2) {
                console.log(value2);
                $("#cityId").append("<option value='"+value2+","+key+"'>"+value2+" , "+key+" </option>");

            })

        })

    });

    $("#addOrder").submit(function (){
        alert("test");

        var payDate=$("#payDate").val();
        var payperiod=$("#payperiod").val();
        var description=$("#description").val();
        var Amount=$("#Amount").val();
        var travelallowance=$("#travelallowance").val();
        var incentices=$("#incentices").val();
        var tax=$("#tax").val();
        var EPF8=$("#EPF8").val();
        var EPF12=$("#EPF12").val();
        var etf=$("#etf").val();
        var TotAmount=$("#TotAmount").val();

        if(payDate=="")
        {
            $("#alertDiv").html("Pay date cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#CustomerName").focus();
            return false;
        }
        if(payperiod=="")
        {
            $("#alertDiv").html("Pay period cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#phoneNo").focus();
            return false;
        }

        if(description=="")
        {
            $("#alertDiv").html("Description cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#deliveryAddress").focus();
            return false;
        }

        if(Amount=="")
        {
            $("#alertDiv").html("Amount cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#cityId").focus();
            return false;
        }


        if(travelallowance=="")
        {
            $("#alertDiv").html("Travel allowance cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#orderType").focus();
            return false;
        }


        if(incentices=="")
        {
            $("#alertDiv").html("Incentives cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#orderDate").focus();
            return false;
        }

        if(tax=="")
        {
            $("#alertDiv").html("Tax cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#Paymentmethod").focus();
            return false;
        }


        if(EPF8=="")
        {
            $("#alertDiv").html("EPF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#paymentStatus").focus();
            return false;
        }

        if(EPF12=="")
        {
            $("#alertDiv").html("EPF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#product").focus();
            return false;
        }
        if(etf=="")
        {
            $("#alertDiv").html("ETF cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#Quantity").focus();
            return false;
        }

        if(TotAmount=="")
        {
            $("#alertDiv").html("Total amount cannot be empty!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#consignerName").focus();
            return false;
        }


    });



    checkExist= function () {

        var value = $('#driver_Name2').val();
        var driverEmployeeID2=($('#driverName2 [value="' + value + '"]').data('value'));
        alert(driverEmployeeID2);
        if(driverEmployeeID2=="")
        {
            $("#alertDiv").html("Please type the contact number!!!");
            $("#alertDiv").addClass("alert alert-danger");
            $("#tel1").focus();
            return false;
        }
        else {

            var url = "../controller/order_controller.php?status=check_emp";

            $.post(url, {driverEmployeeID2: driverEmployeeID2}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $("#earnings-deductions").html(data).show();
            });
        }

    };

});
