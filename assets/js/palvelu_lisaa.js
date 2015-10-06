$(document).ready(function(){   

    $("form").submit(function(e){
        e.preventDefault();
        saveChanges();
    });
    
    function saveChanges(){       
        // käy läpi soveltuva_toimitila -rivit toimitilataulukosta ja poimi valitut        
        var palveluToimitilat = [];
        $('.soveltuva_toimitila').each(function(){
            if($(this).find("input.toimitila_id").prop('checked')){
                palveluToimitilat.push({
                    toimitila_id: $(this).find("input.toimitila_id").val()                
                });
            }
        });
        
        // käy läpi tarjoava_tyontekija -rivit terapeuttitaulukosta ja poimi
        // ne, joilla on annettu hintatieto
        var palveluTyontekijat = [];
        $('.tarjoava_tyontekija').each(function(){
            if($.trim($(this).find("input.tyontekija_hinta").val()) !== ""){
                palveluTyontekijat.push({
                    tyontekija_id: $(this).find("td.tyontekija_hinta").data("tyontekija-id"),
                    hinta: $(this).find("input.tyontekija_hinta").val()
                });
            }
        });
        
        // paketoi käyttäjän antamat tiedot olioksi
        var saveData = {
            nimi: $('#nimi').val(),
            kesto: $('#kesto').val(),
            kuvaus: $('#kuvaus').val(),
            soveltuvat_toimitilat: palveluToimitilat,
            tarjoavat_tyontekijat: palveluTyontekijat
        };
        
        // lähetä tallennettavat tiedot kontrollerille json-muodossa POST-metodilla;
        // ajax-pyynnön url riippuu siitä, onko kyseessä uuden palvelun tallennus vai
        // olemassa olevan palvelun muutos
        var url = "http://jpkangas.users.cs.helsinki.fi/vallila/palvelu";
        if(document.getElementById('palvelu_id'))
            url = url + "/" + document.getElementById('palvelu_id').val() + "/muokkaa";

        $.ajax({
           type: "POST",
           url: url,
           data: JSON.stringify(saveData),
           contentType: "application/json; charset=UTF-8",
           dataType: "json",
           success: function(result){
               //alert(result[0].redirect);
               window.location = result[0].redirect;
           }
        });
        
//        return false;
    }
});