
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="recursos/js/jq-toast.min.js"></script>
<script type="text/javascript">
    $(function () {
        let msg='<?=$msg['titulo']?>';
        if(msg==''){
            
        }else{
            let icono = (msg=='Error')?'error':'success';
            var myToast = $.toast({
                heading: msg,
                text: '<?=$msg['cuerpo']?>',
                icon: icono,
                position: 'top-right',
                showHideTransition: 'plain',
                // bgColor: 'green',
                    textColor: 'white',
                    hideAfter: 2000
            });
        }
        

        $("#btnBuscar").click(function (e) { 
            e.preventDefault();
            let clave= $("#txtBuscar").val().trim();
            if (clave){
                $("table").find('tbody tr').hide();

                $('table tbody tr').each(function(){
                    let nombres=$(this).children().eq(1);
                    if (nombres.text().toUpperCase().includes(clave.toUpperCase())){
                        $(this).show();
                    }
                });
            }else{
                $("table").find('tbody tr').show();

            }

        });

        $("#txtBuscar").keyup(function (e) { 
            e.preventDefault();
            let clave= $("#txtBuscar").val().trim();
            if (clave){
                $("table").find('tbody tr').hide();

                $('table tbody tr').each(function(){
                    let nombres=$(this).children().eq(1);
                    if (nombres.text().toUpperCase().includes(clave.toUpperCase())){
                        $(this).show();
                    }
                });
            }else{
                $("table").find('tbody tr').show();

            }
        });
        

    });
</script>
