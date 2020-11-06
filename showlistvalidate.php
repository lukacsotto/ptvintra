<script>
$(document).ready(function(){
    $('.submission').attr('disabled',true);
    $('#name').keyup(function(){
        if($(this).val().length !=0)
            $('.submission').attr('disabled', false);            
        else
            $('.submission').attr('disabled',true);
    })
});
</script>