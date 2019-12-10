<table class="table table-bordered table-hover footable" data-page-size="15">

        <thead>

            <tr>

               <?php 
                $header = array();
                $i = 0;
                while($results->getColumnMeta($i)){
                    $meta = $results->getColumnMeta($i);
                    $header[] = $meta['name'];
                    echo "<th><a href='http://rapidresponseauto.info/".$table.".php?mode=sort&field=".$table_fields[$i]."&sortMode=";
                    if($_GET['sortMode'] == "" || $_GET['sortMode'] == "ASC"){
                        echo "DESC";
                    }else{
                        echo "ASC";
                    }
                    echo "'>".$meta['name'];
                    if($_GET['sortMode'] == "ASC" && $table_fields[$i] == $_GET['field']){
                        echo " &UpArrow; ";;
                    }else if($_GET['sortMode'] == "DESC" && $table_fields[$i] == $_GET['field']){
                        echo " &DownArrow; ";
                    }
                    echo "</a></th>"; 
                    $i++;

                } 
                ?>
                <th>View</th>

                <th>Edit</th>
                <?php if($_SESSION['user']['LEVEL_OF_ACCESS'] == "Manager"){ ?>
                <th>Remove</th>
                <?php } ?>
            </tr>

        </thead>



    <tbody>

        <?php
            while($row = $results->fetch()){
                echo "<tr>";
                for($k = 0; $k < count($header); $k++){
                    echo "<td>";
                    echo $row[$header[$k]];
                    echo "</td>";
                }
                ?>
                 <td><a href="http://rapidresponseauto.info/view/view_<?php echo $table; ?>.php?id=<?php echo $row['ID']; ?>"><button>View</button></a></td>

                <td><a href="http://rapidresponseauto.info/edit/edit_<?php echo $table; ?>.php?id=<?php echo $row['ID']; ?>"><button>Edit</button></a></td>
                <?php if($_SESSION['user']['LEVEL_OF_ACCESS'] == "Manager"){ ?>
                <td><a href="http://rapidresponseauto.info/remove/remove_<?php echo $table;?>.php?id=<?php echo $row['ID']; ?>"><button>Remove</button></a></td>
                <?php } ?>
                <?php
                echo "</tr>";
            }
        ?>

    </tbody>
    <tfoot class="hide-if-no-paging">
        <tr>
            <td colspan="100">
                <div class="pagination pagination-centered"></div>
            </td>
        </tr>
    </tfoot>

    </table>