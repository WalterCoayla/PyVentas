
<?php 

foreach ($jsGbl as $c) { ?>

<script src="<?=$c['url']?>"></script>
<?php }
?>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script type="text/javascript">
    $(function () {
        let msg='<?=$msg['titulo']?>';
        if(msg!=''){
            let icono = (msg=='Error')?'error':'success';
            $.toast({
                heading: msg,
                text: '<?=$msg['cuerpo']?>',
                icon: icono,
                position: 'top-right',
                showHideTransition: 'plain',
                // bgColor: 'green',
                    textColor: 'white',
                    hideAfter: 2000
            });
        };
        

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
        
        $('.nuevo').click( function(){ 
            
            $('.modal-title').html('Nuevo Registro');
            $.ajax({
                url:'index.php',
                type:'get',
                data:{'ctrl':'<?=$_GET['ctrl']?>','accion':'nuevo'}
            }).done(function(data){
                $('#body-form').html(data);
                $('#modal-form').modal('show');
            }).fail(function(){
                alert("error");
            });
        });
        $('.editar').click( function(){ 
            var id= $(this).data('id');
            $('.modal-title').html('Editando el Reg.: '+id);
            $.ajax({
                url:'index.php',
                type:'get',
                data:{'ctrl':'<?=$_GET['ctrl']?>','accion':'editar','id':id}
            }).done(function(data){
                $('#body-form').html(data);
                $('#modal-form').modal('show');
            }).fail(function(){
                alert("error");
            });
        });
        $('.eliminar').click( function(){ 
            var id= $(this).data('id');
            var nombre= $(this).data('reg');
           
            $('.modal-title').html('<i class="fa fa-trash"></i> Eliminando el Reg.: '+id );
            // $('#body-eliminar').html('');
            $('.reg-eliminacion').html('Registro: <code>' + nombre +'</code>');
            $('#btn-confirmar').attr('data-id', id);
            $('#btn-confirmar').attr('href', '?ctrl=<?=$_GET['ctrl']?>&accion=eliminar&id='+id);
            // alert($('#btn-confirmar').attr('href'));
            $('#modal-eliminar').modal('show');
            
        });
    });
</script>
