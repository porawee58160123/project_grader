<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 2.3%;">
                <div class="data-table-list">
                    <div id="lessons_table" class="table-responsive">
                        <table id="data_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">รหัสนิสิต</th>
                                    <th style="text-align: center;">ชื่อ - นามสกุล</th>
                                    <th style="text-align: center;">กลุ่ม</th>
                                    <th style="text-align: center;">คะแนน</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($score_total->result() as $i => $row_score) { ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $row_score->user_id; ?></td>
                                    <td style="width:52%">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ">
                                            <?php echo $row_score->name; ?> 
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 ">
                                            <a style="margin-left:1%" href="<?php echo base_url('index.php/Score/score_person/'.$row_score->user_id); ?>">
                                                      (ดูคะแนนรายโจทย์ปัญหา)
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php 
                                            if($row_score->grp == "*"){
                                                echo "ทั้งหมด" ;
                                            }else{
                                                echo $row_score->grp ; 
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row_score->total_score; ?></td>
                                </tr>
                                <?php }  ?>
                            </tbody>
                            <tfoot>
                                <tr></tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->


<script>
$(document).ready(function () {

    $('#data_table').DataTable({
        "order": [[ 3, "desc" ]]
    })


});
</script>