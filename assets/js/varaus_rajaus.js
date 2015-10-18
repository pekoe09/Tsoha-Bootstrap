$(document).ready(function(){   
    
    getDependants();

    $("#palvelu_id").change(function(){
       getDependants();       
    });
    
    function getDependants(){        
        // haetaan valittuun palveluun soveltuvat toimitilat ja terapeutit
        var criteria = JSON.stringify({ palvelu_id:$("#palvelu_id").val()});
        $.post("http://jpkangas.users.cs.helsinki.fi/vallila/palvelu/sopivat", criteria, populateDependants); 
    }

    function populateDependants(data){
        // populoidaan toimitila- ja terapeutti-alasvetovalikot tuloksilla
        $("#tyontekija_id").empty();
        $("#toimitila_id").empty();
        
        var toimitilat;
        $.each((JSON.parse(data)).toimitilat, function(key, value){
            toimitilat += "<option value=" + value.id + ">" + value.nimi + "</option>";
        });
        $("#toimitila_id").append(toimitilat);
        
        var terapeutit;
        $.each((JSON.parse(data)).tyontekijat, function(key, value){
           terapeutit += "<option value=" + value.id + ">" + value.sukunimi + ", " + value.etunimi + "</option>";
        });
        $("#tyontekija_id").append(terapeutit);
        
        if ($("#toimitila_id option").length == 0 || $("#tyontekija_id option").length == 0){
            $("#resource-error").removeAttr("style");
            $("#submit").attr("disabled", true);
        } else {
            $("#resource-error").css("display", "none");
            $("#submit").attr("disabled", false);
        }
    }

});