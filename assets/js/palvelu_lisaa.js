//$(document).ready(function(){   
//
//    $("form").submit()(function(e){
//        alert("submit-event huudettu")
//        e.preventDefault();
//        saveChanges();
//    });
    
    function saveChanges(){       
//        alert('saveChanges huudettu');
        //var message = 'arvot: (nimi = '.concat($('#nimi').val(), ' kesto = ', $('#kesto').val(), 'kuvaus = ', $('#kuvaus').val(), ')');
        //alert(message);
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

        
        // lähetä tallennettavat tiedot kontrollerille json-muodossa POST-metodilla
        alert(JSON.stringify(saveData));
//        $.post("http://jpkangas.users.cs.helsinki.fi/vallila/palvelu", JSON.stringify(saveData), function(){});

        $.ajax({
           type: "POST",
           url: "http://jpkangas.users.cs.helsinki.fi/vallila/palvelu",
//           url: "{{base_path}}/palvelu",
           data: JSON.stringify(saveData),
           contentType: "application/json; charset=UTF-8",
           dataType: "json"           
        });
        
        return false;
    }
//});