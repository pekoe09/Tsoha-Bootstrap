$(document).ready(function(){
    
    $('#on_johtaja').click()(function(e){
        if($('#on_johtaja').prop('checked')){
            $('#on_johtaja').prop('checked', false);
        } else {
            $('#on_johtaja').prop('checked', true);
        }
    });
    
});
