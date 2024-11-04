//  this is done by using oninput DOM event in javascript
$(function(){
        var user_password = document.getElementById("psw").value;
        if(user_password=="")
        {
            document.getElementById("next-button").disabled=true;

        }
        else {
            document.getElementById("next-button").disabled=false;

        }
});
function checkTel1() {
    var tel1 = document.getElementById("tel1").value;
    var btn=document.getElementById("btn");
    var patcno=/^\+94[0-9]{9}$/;

    if(!tel1.match(patcno))
    {
        document.getElementById("Tel1error").innerHTML = "Invalid telephone number.Eg: +94112713384" ;
        document.getElementById("Tel1error").style.color = 'red';
        document.getElementById("next-button").disabled=true;
    }
    else
    {
        document.getElementById("Tel1error").innerHTML = "Valid mobile number" ;
        document.getElementById("Tel1error").style.color = 'green';
        document.getElementById("next-button").disabled=false;

    }
}

function checkTel2() {
    var tel2 = document.getElementById("tel2").value;
    var btn=document.getElementById("next-button");
    var patmob=/^\+947[0-9]{8}$/;

    if(!tel2.match(patmob))
    {
        document.getElementById("Tel2error").innerHTML = "Invalid mobile number:Eg: +94779283711" ;
        document.getElementById("Tel2error").style.color = 'red';
        document.getElementById("next-button").disabled=true;

    }
    else
    {

        document.getElementById("Tel2error").innerHTML = "Valid mobile number" ;
        document.getElementById("Tel2error").style.color = 'green';
        document.getElementById("next-button").disabled=false;

    }
}

function checkemail() {
    var uemail = document.getElementById("uemail").value;
    var btn=document.getElementById("btn");
    var patemail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/;

    if(!uemail.match(patemail))
    {
        document.getElementById("emailerror").innerHTML = "Eg:abc@gmail.com" ;
        document.getElementById("emailerror").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }
    else
    {

        document.getElementById("emailerror").innerHTML = "Valid email" ;
        document.getElementById("emailerror").style.color = 'green';
        document.getElementById("btn").disabled=false;

    }
}
function checknic()
{
    var unic = document.getElementById("unic").value;
    var btn=document.getElementById("next-button");
    var patnic=/^[0-9]{12}|[0-9]{9}[vVxX]$/;


    if(unic.match(patnic))
    {
        document.getElementById("nicError").innerHTML = "Valid NIC" ;
        document.getElementById("nicError").style.color = 'green';
        document.getElementById("next-button").disabled=false;

    }
    else
    {
        document.getElementById("nicError").innerHTML = "Incorrect NIC. NIC should match 928119273V / 1964 104 0241 7" ;
        document.getElementById("nicError").style.color = 'red';
        document.getElementById("next-button").disabled=true;

    }


}
function checkvalue()
{
    $(function(){/*order*/
        $('#tax, #incentices').keyup(function(){

            var salary = parseFloat($('#Amount').val()) || 0;
            var tax = parseFloat($('#tax').val()) || 0;
            var incentives = parseFloat($('#incentices').val()) || 0;
            var epf8 = parseFloat($('#EPF8').val()) || 0;
            var travelallowance = parseFloat($('#travelallowance').val()) || 0;

            $('#TotAmount').val( (salary + travelallowance + incentives) - (tax + epf8));
        });
    });

    var tax = document.getElementById("tax").value;
    var btn=document.getElementById("btn");

    if(tax>=0)
    {
        document.getElementById("MinusError").innerHTML = "Valid incentive amount" ;
        document.getElementById("MinusError").style.color = 'green';
        document.getElementById("btn").disabled=false;
        $("#TotAmount").val(tax);

    }
    else
    {
        document.getElementById("MinusError").innerHTML = "Incentive cannot contain negative values" ;
        document.getElementById("MinusError").style.color = 'red';
        document.getElementById("btn").disabled=true;
    }
}

function checkvalue2()
{
    var quanityOrder = document.getElementById("quanityOrder").value;
    var btn=document.getElementById("btn");

    if(quanityOrder>0)
    {
        document.getElementById("MinusError2").innerHTML = "Valid Amount" ;
        document.getElementById("MinusError2").style.color = 'green';
        document.getElementById("btn").disabled=false;
        $("#TotAmount").val(Amount);
    }
    else
    {
        document.getElementById("MinusError2").innerHTML = "Quantity cannot contain negative values" ;
        document.getElementById("MinusError2").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }
}
/*for quote single*/
$(function(){ /*for quote single*/

    $('#taxQuote').keyup(function(){

        var taxQuote = document.getElementById("taxQuote").value;
        if(taxQuote>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#pieces').keyup(function(){
        var pieces = document.getElementById("pieces").value;
        if(pieces>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#length').keyup(function(){
        var length = document.getElementById("length").value;
        if(length>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#width').keyup(function(){
        var width = document.getElementById("width").value;
        if(width>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#height').keyup(function(){
        var height = document.getElementById("height").value;
        if(height>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#weightQuote').keyup(function(){
        var weightQuote = document.getElementById("weightQuote").value;
        if(weightQuote>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });

});
/*for quote regular*/
$(function(){ /*for quote regular shipping*/

    $('#rateShip').keyup(function(){
        var rateShip = document.getElementById("rateShip").value;
        if(rateShip>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#DiscountShip').keyup(function(){
        var DiscountShip = document.getElementById("DiscountShip").value;
        if(DiscountShip>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#shipPieces').keyup(function(){
        var shipPieces = document.getElementById("shipPieces").value;
        if(shipPieces>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#length').keyup(function(){
        var slength = document.getElementById("length").value;
        if(slength>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#width').keyup(function(){
        var swidth = document.getElementById("width").value;
        if(swidth>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#height').keyup(function(){
        var sHeight = document.getElementById("height").value;
        if(sHeight>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#weight').keyup(function(){
        var sWeight = document.getElementById("weight").value;
        if(sWeight>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values(Eg:Tax,pieces,Dimension,weight)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });

});
/*for billing and bulk billing*/
$(function(){ /*for billing*/

    $('#clearance').keyup(function(){

        var clearance = document.getElementById("clearance").value;
        if(clearance>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#landTransport').keyup(function(){
        var landTransport = document.getElementById("landTransport").value;
        if(landTransport>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#SLTransport').keyup(function(){
        var SLTransport = document.getElementById("SLTransport").value;
        if(SLTransport>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });

    $('#bulkSub').keyup(function(){

        var bulkSub = document.getElementById("bulkSub").value;
        if(bulkSub>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#bulkDiscount').keyup(function(){
        var bulkDiscount = document.getElementById("bulkDiscount").value;
        if(bulkDiscount>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#bulktotal').keyup(function(){
        var bulktotal = document.getElementById("bulktotal").value;
        if(bulktotal>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });



});

/*warehouse validations*/
$(function(){

    $('#chosenPackageCount').keyup(function(){

        var chosenPackageCount = document.getElementById("chosenPackageCount").value;
        if(chosenPackageCount>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#matLength').keyup(function(){
        var matLength = document.getElementById("matLength").value;
        if(matLength>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
    $('#packageweight').keyup(function(){
        var packageweight = document.getElementById("packageweight").value;
        if(packageweight>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values)" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });

    $('#goodQty').keyup(function(){
        var goodQty = document.getElementById("goodQty").value;
        if(goodQty>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("page1").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("page1").disabled=true;
        }
    });
 });
/*transport validations*/
$(function(){
    $('#BasicRate').keyup(function(){
        var BasicRate = document.getElementById("BasicRate").value;
        if(BasicRate>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit").disabled=true;
        }
    });
    $('#RateKm').keyup(function(){
        var RateKm = document.getElementById("RateKm").value;
        if(RateKm>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit").disabled=true;
        }
    });

    $('#rate').keyup(function(){
        var rate = document.getElementById("rate").value;
        if(rate>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit2").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit2").disabled=true;
        }
    });
    $('#RateKm2').keyup(function(){
        var RateKm2 = document.getElementById("RateKm2").value;
        if(RateKm2>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit2").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit2").disabled=true;
        }
    });
    $('#empID').keyup(function(){
        var empID = document.getElementById("empID").value;
        if(empID>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid employee ID format";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Employee ID cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
    $('#trackNo').keyup(function(){
        var trackNo = document.getElementById("trackNo").value;
        var patTrack=/^[0-9]{6}$/;
        var btn=document.getElementById("btn");

        if(trackNo.match(patTrack))
        {
            document.getElementById("MinusError4").innerHTML = "Valid track number";
            document.getElementById("MinusError4").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinusError4").innerHTML = "Invalid track number.Eg: 200001" ;
            document.getElementById("MinusError4").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });
});
/*order zipcode*/
$(function(){

$('#ConsigneeZipcode').keyup(function(){
    var ConsigneeZipcode = document.getElementById("ConsigneeZipcode").value;
    var patTrack=/^[0-9]{5}$/;
    var btn=document.getElementById("btn");

    if(ConsigneeZipcode.match(patTrack))
    {
        document.getElementById("zipCode").innerHTML = "Valid zip code";
        document.getElementById("zipCode").style.color = 'green';
        document.getElementById("btn").disabled=false;
    }
    else
    {
        document.getElementById("zipCode").innerHTML = "Invalid zip code.Eg: 10354" ;
        document.getElementById("zipCode").style.color = 'red';
        document.getElementById("btn").disabled=true;
    }
});
});

/*raw materials validations*/
$(function(){
    $('#qty').keyup(function(){
        var qty = document.getElementById("qty").value;
        if(qty>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit").disabled=true;
        }
    });
    $('#itemPrice').keyup(function(){
        var itemPrice = document.getElementById("itemPrice").value;
        if(itemPrice>0)
        {
            document.getElementById("MinusError3").innerHTML = "Valid numerical value";
            document.getElementById("MinusError3").style.color = 'green';
            document.getElementById("submit").disabled=false;
        }
        else
        {
            document.getElementById("MinusError3").innerHTML = "Numerical fields cannot contain negative values" ;
            document.getElementById("MinusError3").style.color = 'red';
            document.getElementById("submit").disabled=true;
        }
    });

});
/*billing validations*/
$(function(){
    $('#amount').keyup(function(){
        var amount = document.getElementById("amount").value;
        if(amount>0)
        {
            document.getElementById("amountError").innerHTML = "Valid numerical value";
            document.getElementById("amountError").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("amountError").innerHTML = "Amount cannot contain negative values" ;
            document.getElementById("amountError").style.color = 'red';
            document.getElementById("btn").disabled=true;
        }
    });

    $('#chequeNo').keyup(function(){
        var chequeNo = document.getElementById("chequeNo").value;
        var patCheque=/^[0-9]{6,18}$/;
        var btn=document.getElementById("btn");

        if(chequeNo.match(patCheque))
        {
            document.getElementById("MinError2").innerHTML = "Cheque is valid";
            document.getElementById("MinError2").style.color = 'green';
            document.getElementById("btn").disabled=false;
        }
        else
        {
            document.getElementById("MinError2").innerHTML = "Please check the cheque number" ;
            document.getElementById("MinError2").style.color = 'red';
            document.getElementById("btn").disabled=true;

        }
    });
});


function checkvalue5()
{
    var pack = document.getElementById("package").value;
    var btn=document.getElementById("btn");

    if(pack>0)
    {
        document.getElementById("MinusError5").innerHTML = "Package value is valid";
        document.getElementById("MinusError5").style.color = 'green';
        document.getElementById("btn").disabled=false;

    }
    else
    {
        document.getElementById("MinusError5").innerHTML = "Package value cannot contain negative values" ;
        document.getElementById("MinusError5").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }
}
function checkNegative()/*for order pieces */
{
    var number = document.getElementById("number").value;
    var btn=document.getElementById("btn");
    if(number>0)
    {
        document.getElementById("MinError").innerHTML = "Value is valid";
        document.getElementById("MinError").style.color = 'green';
        document.getElementById("btn").disabled=false;
    }
    else
    {
        document.getElementById("MinError").innerHTML = "Cannot contain negative values" ;
        document.getElementById("MinError").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }
}
function checkNegative2()
{
    var weight = document.getElementById("weight").value;
    var btn=document.getElementById("btn");
    if(weight>0)
    {
        document.getElementById("MinError2").innerHTML = "Value is valid";
        document.getElementById("MinError2").style.color = 'green';
        document.getElementById("btn").disabled=false;
    }
    else
    {
        document.getElementById("MinError2").innerHTML = "Cannot contain negative values" ;
        document.getElementById("MinError2").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }
}
$(function(){/*bill number*/
    $('#BillNo').keyup(function(){
        var BillNo = document.getElementById("BillNo").value;
        var btn=document.getElementById("btn");
        var patBillNo=/^BL32N180+[0-9]{1,}$/;

        if(!BillNo.match(patBillNo))
        {
            document.getElementById("Billerror").innerHTML = "Invalid bill number.Eg:BL32N1801" ;
            document.getElementById("Billerror").style.color = 'red';
            document.getElementById("submit").disabled=true;
        }
        else
        {
            document.getElementById("Billerror").innerHTML = "Valid bill number" ;
            document.getElementById("Billerror").style.color = 'green';
            document.getElementById("submit").disabled=false;
        }
    });
});

$(function(){/*edit order*/
    $('#Tax, #amount,#shippingcharge').keyup(function(){
        var valueEdit1 = parseFloat($('#Tax').val()) || 0;
        var valueEdit2 = parseFloat($('#amount').val()) || 0;
        var valueEdit3 = parseFloat($('#shippingcharge').val()) || 0;
        $('#Totamount').val(valueEdit1 + valueEdit2 + valueEdit3);
    });
});

$(function(){
    $('#BasicRate, #RateKm,#FinalRate').keyup(function(){
        var rate = parseFloat($('#BasicRate').val()) || 0;
        var ratekm = parseFloat($('#RateKm').val()) || 0;
        $('#FinalRate').val(rate * ratekm);
        $('#Rate').val(rate * ratekm);

    });
});
$(function(){
    $('#rate, #RateKm2,#FinalRate').keyup(function(){
        var rate = parseFloat($('#rate').val()) || 0;
        var ratekm = parseFloat($('#RateKm2').val()) || 0;
        $('#FinalRate').val(rate * ratekm);
        $('#Rate').val(rate * ratekm);

    });
});
$(function(){
    $('#SLTransport, #landTransport,#clearance').keyup(function(){
        var SLTransport = parseFloat($('#SLTransport').val()) || 0;
        var landTransport = parseFloat($('#landTransport').val()) || 0;
        var clearance = parseFloat($('#clearance').val()) || 0;
        var weightCost = parseFloat($('#weightCost').val()) || 0;
        var shipping_charge = parseFloat($('#shipping_charge').val()) || 0;
        var tax = parseFloat($('#tax').val()) || 0;
        var packing = parseFloat($('#packing').val()) || 0;
        var subtotal = parseFloat($('#subtotal').val()) || 0;

        $('#total').val(SLTransport+landTransport+clearance+weightCost+shipping_charge+tax+packing+subtotal);

    });
});
/*order rate*/
$(function(){
    $('#weight').keyup(function(){
        var AddiotionalWeightRate = parseFloat($('#AddiotionalWeightRate').val()) || 0;
        var weight=parseFloat($('#weight').val()) || 0;
        if(weight>2) {
            $('#wghtcost').val((weight - 2) * AddiotionalWeightRate);
        }
        else{
            $('#wghtcost').val(0);
        }

    });
});




/*single quote order*/
$(function(){
    $('#weightQuote').keyup(function(){
        var additionalweightRate = parseFloat($('#additionalweightRate').val()) || 0;
        var weightQuote=parseFloat($('#weightQuote').val()) || 0;

        if(weightQuote>2) {

            $("#additionalrate").val((weightQuote-2)*additionalweightRate);
        }
        else {
            $("#additionalrate").val(0);

        }

    });
});

/*quote additions*/
$(function(){
    $('#weightQuote,#taxQuote').keyup(function(){
        var rate= parseFloat($('#rate').val()) || 0;
        var additionalrate=parseFloat($('#additionalrate').val()) || 0;
        var basicWeightRate=parseFloat($('#weightRateAir').val()) || 0;
        var taxQuote=parseFloat($('#taxQuote').val()) || 0;
        $("#total").val(rate+basicWeightRate+additionalrate+taxQuote);

    });
});
/*quote substraction=shipping*/
$(function(){
    $('#rateShip,#DiscountShip').keyup(function(){
        var rateShip= parseFloat($('#rateShip').val()) || 0;
        var DiscountShip=parseFloat($('#DiscountShip').val()) || 0;

        $("#finalRateShip").val(rateShip-DiscountShip);

    });
});

/*bulk substraction discount*/
$(function(){
    $('#bulkSub,#bulkDiscount').keyup(function(){
        var bulkSub= parseFloat($('#bulkSub').val()) || 0;
        var bulkDiscount=parseFloat($('#bulkDiscount').val()) || 0;

        $("#bulktotal").val(bulkSub-bulkDiscount);
    });
});

/*quote substraction=courier*/
$(function(){
    $('#rate,#Discount').keyup(function(){
        var rate= parseFloat($('#rate').val()) || 0;
        var Discount=parseFloat($('#Discount').val()) || 0;

        $("#finalRate").val(rate-Discount);

    });
});
function checkHours1()
{
    var VehMaintainHrs = document.getElementById("VehMaintainHrs").value;
    var btn=document.getElementById("btn");
    var engHrsPat=/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;


    if(VehMaintainHrs.match(engHrsPat))
    {
        document.getElementById("EngHrs").innerHTML = "Valid hours" ;
        document.getElementById("EngHrs").style.color = 'green';
        document.getElementById("btn").disabled=false;

    }
    else
    {
        document.getElementById("EngHrs").innerHTML = "Incorrect value for hours.Eg: 23:15:10" ;
        document.getElementById("EngHrs").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }

}
function checkHours2()
{
    var VehMaintainEngHrs = document.getElementById("VehMaintainEngHrs").value;
    var btn=document.getElementById("btn");
    var engHrsPat=/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;


    if(VehMaintainEngHrs.match(engHrsPat))
    {
        document.getElementById("EstHrs").innerHTML = "Valid hours" ;
        document.getElementById("EstHrs").style.color = 'green';
        document.getElementById("btn").disabled=false;

    }
    else
    {
        document.getElementById("EstHrs").innerHTML = "Incorrect value for hours.Eg: 23:15:10" ;
        document.getElementById("EstHrs").style.color = 'red';
        document.getElementById("btn").disabled=true;

    }


}
function checkHours3()
{
    var WorkingHours = document.getElementById("WorkingHours").value;
    var workHrsPat=/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;

    if(WorkingHours.match(workHrsPat))
    {
        document.getElementById("Hrs").innerHTML = "Valid hours" ;
        document.getElementById("Hrs").style.color = 'green';
    }
    else
    {
        document.getElementById("Hrs").innerHTML = "Incorrect value for hours.Eg: 23:15:10" ;
        document.getElementById("Hrs").style.color = 'red';
    }


}















