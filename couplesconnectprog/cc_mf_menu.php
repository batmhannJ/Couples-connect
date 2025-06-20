<?php

    $select_db="SELECT * FROM mf_cc_menu WHERE usr_access LIKE '%".$_SESSION['usertype']."%' ORDER BY menidx DESC";
    $stmt	= $link->prepare($select_db);
    $stmt->execute();
    while($rs = $stmt->fetch()){
        
        echo "<div style='display:flex;justify-content:center'>";
            echo "<div class='row' style='width:80%;padding-bottom:10px'>";
                echo "<div class='col-2'>";
                    echo "<img src='images/menu_logos/".$rs['menlogo']."'style='width:20px;height:auto'/>";
                echo "</div>";

                echo "<div class='col-10' style='font-family:inter;font-size:22px;font-weight:700;'>";
                    echo "<a style='color:black;text-decoration:none' href='".$rs['menprog']."'>".$rs['mencap']."</a>";
                echo "</div>";
            echo "</div>";
        echo "</div>";

    }

?>