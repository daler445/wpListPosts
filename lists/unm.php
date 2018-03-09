<?php 
    $list1 = 4;
    $list2 = 8;
    $lang = "ru";
    if(($_POST['oscimp_hidden'] == 'Y')&&($_POST['oscimp_hidden_2'] != 'Y')) {
        //Form data sent

        //id
        $list_selected = $_POST['list_s'];

        global $wpdb;
        $table_name = $wpdb->prefix . "adlists";
        $tID = $list_selected;
        $retrieve_data_l = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$tID" );
        $list_length = $retrieve_data_l[0]->post_num;
?>
    <div class="wrap">
        <?php    echo "<h2>" . __( 'Списки', 'oscimp_trdom' ) . "</h2>"; ?>
        <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="oscimp_hidden" value="Y">
            <input type="hidden" name="oscimp_hidden_2" value="Y">
            <input type="hidden" name="list_num" value="<?php echo $list_selected; ?>">
            <input type="hidden" name="optnums" value="<?php echo $list_length; ?>">
            <?php    echo "<h4>" . __( 'Список: ' . $retrieve_data_l[0]->name . ' Количество записей: ' . $retrieve_data_l[0]->post_num . ' ID:' . $list_selected, 'oscimp_trdom' ) . "</h4>"; ?>
            <?php
                $query_post_num = get_option('oscimp_postnum');
                $args = array( 'post_type'=>'post', 'post_status'=>'publish', 'numberposts' => $query_post_num );
                $posts = get_posts($args);
                $j = 1;
                for($i=1;$i<=$list_length;$i++) {
            ?>
                <p>
                    <?php _e("№" . $i . ". Введите ID поста: " ); ?>
                    <?php
                        $ch = 'val-'.$list_selected.'-'.$i;
                        $gv = get_option($ch);
                        $j++;
                    ?>
                    <input type="text" id="t-<?php echo $i; ?>" name="val-<?php echo $i; ?>" value="<?php echo $gv; ?>" required> или выберите отсюда: 
                    <select onchange="OnSelectionChange<?php echo $i; ?> (this)" style="width:450px;display:block;"> 
                        <?php
                            $founded = false;
                            foreach ($posts as $value) {
                                if ($gv==$value->ID) {
                                    $selected="selected";
                                    $founded = true;
                                } else { 
                                    $selected = ""; 
                                }
                                echo "<option value='".$value->ID."' $selected>" . $value->ID . ". " . $value->post_title . "</option>";
                            }
                            if ($founded==false) {
                                echo "<option selected>-</option>";
                            }
                        ?>
                    </select>

                    <script type="text/javascript">
                        function OnSelectionChange<?php echo $i; ?> (select) {
                            var selectedOption = select.options[select.selectedIndex];
                            document.getElementById("t-<?php echo $i; ?>").value = selectedOption.value;
                        }
                    </script>

                </p>

            <?php
                }
            ?>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Обновить', 'oscimp_trdom' ) ?>" />
            </p>
        </form>
    </div>
<?php
    } elseif (($_POST['oscimp_hidden'] == 'Y')&&($_POST['oscimp_hidden_2'] == 'Y')) {
        //Store page
        $list = $_POST["list_num"];
        $optnums = $_POST["optnums"];
        $k = 1;
        for ($i=1;$i<=$optnums;$i++) {
            $gVal = $_POST["val-".$i];
            $tname = "val-".$list."-".$k;
            update_option("$tname", "$gVal");
            $k++;
        }
    ?>
    <div class="updated"><p><strong><?php _e('Updated.' ); ?></strong></p></div>
    <p>Обновите страницу или нажмите <input type="button" value="сюда" onClick="window.location.reload()"></p>
    <?php
    } else {
        //Normal page display
?>
    <div class="wrap">
        <?php    echo "<h2>" . __( 'Списки', 'oscimp_trdom' ) . "</h2>"; ?>
        <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="oscimp_hidden" value="Y">
            <?php    echo "<h4>" . __( 'Выберите нужный список', 'oscimp_trdom' ) . "</h4>"; ?>
            <p>
                <?php _e("Название списка: " ); ?>
                <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . "adlists";     
                        $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name" );
                ?>
                <select name="list_s" style="width:300px;">
                    <?php
                        foreach ($retrieve_data as $retrieved_data){
                            echo "<option value='$retrieved_data->id'>";
                                echo $retrieved_data->name;
                            echo "</option>";
                        }
                    ?>
                </select>
            </p>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Выбрать', 'oscimp_trdom' ) ?>" />
            </p>
        </form>
    </div>
<?php
    }
?>
