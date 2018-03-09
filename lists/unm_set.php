<?php 
    if($_POST['oscimp_hidden'] == 'Y') {
        $osc_postnum = $_POST['oscimp_postnum'];
        update_option('oscimp_postnum', $osc_postnum);
?>
        <div class="updated"><p><strong><?php _e('Обновлено.' ); ?></strong></p></div>
<?php
    } else {
        //Normal page display
    }
?>
    <?php
        $osc_postnum = get_option('oscimp_postnum');
    ?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Настройки', 'oscimp_trdom' ) . "</h2>"; ?>
     
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="oscimp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Настройки работы плагина', 'oscimp_trdom' ) . "</h4>"; ?>
        <p><?php _e("Количество записей в запросе: " ); ?><input type="text" name="oscimp_postnum" value="<?php echo $osc_postnum; ?>" size="20" required><?php _e(" большое количество запросов могут замедлить работу плагина" ); ?></p>
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Обновить', 'oscimp_trdom' ) ?>" />
        </p>
    </form>
</div>