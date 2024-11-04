$(document).ready(function (){



    $("#add-row").click(function () {

        var itemid=$("#itemid").val();
        var qty=$("#qty").val();
        var price=$("#price").val();

        var url="../controller/purchaseController.php?status=add_poitem";

        /*ajax request is made*/
        $.post(url,{itemid:itemid,qty:qty,price:price},function(data){
            /*show the data that is being responded by server in the div id myfunctions*/
            $("#pocontent").html(data).show();
            /*data is fetched from the product controller and subcatdiv is replaced by that value*/
        });




    });
    addnewitem= function (x) {
        alert(x);
        var itemid=$("#itemid").val();
        var qty=$("#qty").val();
        var price=$("#price").val();

        var url="../controller/purchaseController.php?status=add_poitem";

        /*ajax request is made*/
        $.post(url,{itemid:itemid,qty:qty,price:price},function(data){
            /*show the data that is being responded by server in the div id myfunctions*/
            $("#pocontent").html(data).show();
            /*data is fetched from the product controller and subcatdiv is replaced by that value*/
        });


    }
    removeItem= function (x) {
        var con=confirm("Do you really want to remove this item?");
        if(con==true) {

            var url = "../controller/purchaseController.php?status=removepoitem";

            /*ajax request is made*/
            $.post(url, {tmp_id: x}, function (data) {
                /*show the data that is being responded by server in the div id myfunctions*/
                $("#pocontent").html(data).show();
                /*data is fetched from the product controller and subcatdiv is replaced by that value*/
            });
        }


    }


});
/**
 * Created by LENOVO on 9/15/2020.
 */
