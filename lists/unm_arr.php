<?php 
    if($_POST['oscimp_hidden'] == 'Y') {
        //Form data sent
        global $wpdb;
        $create_table_query = "
            CREATE TABLE `{$wpdb->prefix}adlists` 
            ( `id` INT(255) NOT NULL AUTO_INCREMENT , 
            `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
            `post_num` INT(255) NOT NULL , 
            PRIMARY KEY (`id`)) 
            ENGINE = InnoDB
            DEFAULT CHARSET=utf8;
        ";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $create_table_query );
?>
        <div class="updated"><p><strong><?php _e('Done.' ); ?></strong></p></div>
<?php
    } else {
        //Normal page display
    }
?>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Установка', 'oscimp_trdom' ) . "</h2>"; ?>
     
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="oscimp_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Установка или проверка базы данных', 'oscimp_trdom' ) . "</h4>"; ?>
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Запуск', 'oscimp_trdom' ) ?>" />
        </p>
    </form>
</div>