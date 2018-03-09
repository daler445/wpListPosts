<?php 
    $display = true;
    if($_POST['oscimp_hidden'] == 'Y') {
        //Create new one
        $listname = $_POST["listname"];
        $postnum = $_POST["post_num"];

        global $wpdb;
        $table_name = $wpdb->prefix . "adlists";
        $data = array ('name'=>$listname,'post_num'=>$postnum);
        $wpdb -> insert($table_name,$data);
?>
        <div class="updated"><p><strong><?php _e('Добавлено.' ); ?></strong></p></div>
<?php
    } elseif ($_GET["act"]==1) {
        // edit data
        $display = false;
        global $wpdb;
        $table_name = $wpdb->prefix . "adlists";     
        $tID = $_GET["id"];
        $retrieve_data_fn = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$tID" );
    }
    elseif ($_POST["oscimp_hidden"]=="D") {
        global $wpdb;
        $table_name = $wpdb->prefix . "adlists";
        $id = $_POST["sID"];

        // delete
        $wpdb->delete( $table_name, array( 'id' => $id ) );
?>
        <div class="updated"><p><strong><?php _e('Удалено.' ); ?></strong></p></div>
<?php
    }
    elseif ($_POST["oscimp_hidden"]=="E") {
            $listname = $_POST["listname"];
            $postnum = $_POST["post_num"];

            global $wpdb;
            $subs = array('id'=>$_POST["id"]);
            $table_name = $wpdb->prefix . "adlists";
            $data = array ('name'=>$listname,'post_num'=>$postnum);
            $wpdb->update($table_name, $data, $subs);
            $display = true;
    ?>
            <div class="updated"><p><strong><?php _e('Изменено.' ); ?></strong></p></div>
    <?php
    }
    else {
        //Normal page display
    }

    global $wpdb;
    $table_name = $wpdb->prefix . "adlists";     
    $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
?>
<style>
    .b1 tr td{
        padding:10px;
    }
</style>
<div class="wrap">
    <?php
        if ($display==true) {
    ?>
    <?php    echo "<h2>" . __( 'Все списки', 'oscimp_trdom' ) . "</h2>"; ?>
     
        
        <?php    echo "<h4>" . __( 'Список всех созданных списков', 'oscimp_trdom' ) . "</h4>"; ?>
        <table border=1 class="b1">
            <tr>
                <td>ID</td>
                <td>Название</td>
                <td>Кол. записей</td>
                <td>php call</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                foreach ($retrieve_data as $retrieved_data){
                    echo "<tr>";
                        echo "<td>" . $retrieved_data->id . "</td>";
                        echo "<td>" . $retrieved_data->name . "</td>";
                        echo "<td>" . $retrieved_data->post_num . "</td>";
                        echo '<td>osimp_get_list(' . $retrieved_data->id . ')</td>';
                        echo "<td><a href='".$actual_link."&id=".$retrieved_data->id."&act=1'>Изменить</a></td>";
                        //echo "<form method=post><td>Удалить</td>";
            ?>
                        <style>
                            .cl1 {
                                vertical-align:bottom;
                                overflow:visible;
                                font-size:1em; 
                                display:inline;  
                                margin:0; 
                                padding:0; 
                                border:0; 
                                border-bottom:1px solid #0073aa; 
                                color:#0073aa; 
                                cursor:pointer;
                                background: #f1f1f1;
                            }
                        </style>
                        <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                            <input type="hidden" name="oscimp_hidden" value="D" />
                            <input type="hidden" name="sID" value="<?php echo $retrieved_data->id; ?>" />
                            <td><input class="cl1" type="submit" name="Submit" value="<?php _e('Удалить', 'oscimp_trdom' ) ?>" onclick="return confirm('Are you sure?')"/></td>
                        </form>
                        <td><a href="<?php echo admin_url(); ?>admin.php?page=adlists_show&id=<?php echo $retrieved_data->id; ?>" target="_blank">Посмотреть</a></td>
            <?php
                    echo "</tr>";
                }
            ?>
        </table>
        <br /><br />
        <hr>
        <?php    echo "<h4>" . __( 'Создать новый список', 'oscimp_trdom' ) . "</h4>"; ?>
        <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="oscimp_hidden" value="Y">
            <p><?php _e("Название списка: " ); ?><input type="text" name="listname" value="" size="20" required><?php _e(" к примеру: my_list1" ); ?></p>
            <p><?php _e("Количество записей: " ); ?><input type="number" name="post_num" value="" size="20" min="1" max="500" required><?php _e(" минимальное значение - 1" ); ?></p>
            <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Добавить новую', 'oscimp_trdom' ) ?>" />
            </p>
        </form>
    <?php
    }
    else {
            $path_only = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $newpath = $path_only . "?page=adlists_li";
    ?>
        <?php    echo "<h4>" . __( 'Изменение списка. ID: '.$retrieve_data_fn[0]->id.'', 'oscimp_trdom' ) . "</h4>"; ?>
        <form name="oscimp_form" method="post" action="<?php echo $newpath; ?>">
            <input type="hidden" name="oscimp_hidden" value="E">
            <input type="hidden" name="id" value="<?php echo $retrieve_data_fn[0]->id; ?>">
            <p><?php _e("Название списка: " ); ?><input type="text" name="listname" value="<?php echo $retrieve_data_fn[0]->name; ?>" size="20" required><?php _e(" к примеру: my_list1" ); ?></p>
            <p><?php _e("Количество записей: " ); ?><input type="number" name="post_num" value="<?php echo $retrieve_data_fn[0]->post_num ?>" size="20" min="1" max="500" required><?php _e(" минимальное значение - 1" ); ?></p>
            <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Обновить', 'oscimp_trdom' ) ?>" />
            </p>
        </form>
    <?php
    }
    ?>
</div>