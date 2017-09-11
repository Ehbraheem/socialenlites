/**
 * Created by DeeVexx on 7/23/2017.
 */

$(document).ready(function () {
    $("#acctype").change(function () {

        if($(this).val()=="company"){
            $("#companyname").removeAttr("hidden");
        }
        else{
            $("#companyname").attr("hidden", "true");
        }

    })
});



