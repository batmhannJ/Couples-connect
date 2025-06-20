<?php
require "includes/cc_header.php";

$header_name = '';
if ($_SESSION['usertype'] == 'DSK') {
    $header_name = "DESK";
} else if ($_SESSION['usertype'] == 'CNR') {
    $header_name = "COUNSELOR";
} else if ($_SESSION['usertype'] == 'HED') {
    $header_name = "HEAD";
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#tbl_list').DataTable();

        $('.btn-delete').click(function() {
            var dataId = $(this).data('id');

            let x = confirm("Are you sure do you want to remove?");

            if (x==true) {
                window.location = `?remove=${dataId}`
            }
        });

    });
</script>

<?php
if (isset($_GET['remove'])) {
    $deleted_db = "delete from tbl_questions where questions_id=:questions_id";
    $stmt = $link->prepare($deleted_db);
    $stmt->bindParam(':questions_id', $_GET['remove']);

    if ($stmt->execute()) {
        $msg = "Question deleted successfully.";
        $status = "Success";
        $bg = "success";
    } else {
        $msg = "Error deleted record.";
        $status = "Failed";
        $bg = "danger";
    }
}
?>


<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>

        <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>

            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>

            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
            </div>

            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couplesconnectprog/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
            </div>

        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self" style='height:100%'>
    <table style="width:100%;height:100%">
        <tr>
            <td style='width:30%'>
                <div class="row h-100 justify-content-center align-items-center">
                    <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                        <div class="m-3 pt-2 text-center login_form_header">
                            <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                            <img src="images/Rectangle 11934.png" style='width:100%'>
                        </div>

                        <?php
                        require 'cc_mf_menu.php';
                        ?>


                    </div>
                </div>
            </td>

            <td style='width:70%'>
                <div class="row h-100 justify-content-center align-items-center">
                    <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>
                        <div class="m-3 pt-2">
                            <br />
                            <br style='display:block;margin:16px 0;content:""' />
                            <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>
                            <h2> Question List</h2>

                            <div class="card-body">

                                <a href="new_question.php" class="btn btn-primary mb-3 text-white">New Question</a>

                                <div style="overflow: auto;">
                                    <table id="tbl_list" class="table table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Questions</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $select_db = "SELECT * FROM tbl_questions ORDER BY questions_id DESC";
                                            $stmt    = $link->prepare($select_db);
                                            $stmt->execute();
                                            while ($rs = $stmt->fetch()) {
                                                echo "
                                                        <tr>
                                                            <td>$rs[questions_id]</td>
                                                            <td>$rs[questions]</td>
                                                            <td class='text-center' style='display:flex; gap: 10px'>
                                                            " ?>

                                                <button class="btn btn-danger btn-delete" data-id="<?= $rs['questions_id'] ?>">Remove</button>

                                                <a class="btn btn-success text-white" href="new_question.php?edit=<?= $rs['questions_id'] ?>">Edit</a>

                                            <?php "</td>
                                                        </tr>
                                                    ";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

    </table>



    <?php
    require "includes/cc_footer.php";
    ?>