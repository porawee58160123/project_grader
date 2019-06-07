<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Accordion area start-->
<div class="accordion-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 2.3%;">
                    <div class="accordion-wn-wp">
                        <div class="accordion-hd">
                            <h2>
                                <?php 
                                    if($person_info->student_group == "*"){
                                        $person_info->student_group = "ทั้งหมด";
                                    }
                                    echo $person_info->user_id." ".$person_info->student_name." กลุ่ม ".$person_info->student_group; 
                                ?>
                            </h2>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="accordion-stn">
                                    <?php foreach ($person_lessons->result() as $i => $row_lessons) { ?>
                                    <div class="panel-group" data-collapse-color="nk-blue" id="<?php echo $i; ?>" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-collapse notika-accrodion-cus">
                                            <div class="panel-heading" role="tab">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#<?php echo $i; ?>" href="#<?php echo $i; ?>-one" aria-expanded="true">
															<?php echo $row_lessons->lesson_name; ?>
														</a>
                                                </h4>
                                            </div>
                                            <!-- row lessons -->
                                            <div id="<?php echo $i; ?>-one" class="collapse" role="tabpanel">
                                                <div class="panel-body">
                                                    <!-- Data Table area Start-->
                                                    <div class="data-table-area">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                                                        <div class="data-table-list">
                                                                            <div id="lessons_table" class="table-responsive">
                                                                            <table id="<?php $i ?>" class="table table-striped">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="text-align: center;">ข้อ</th>
                                                                                        <th style="text-align: center;">ชื่อโจทย์</th>
                                                                                        <th style="text-align: center;">เวลาที่ใช้ (นาที)</th>
                                                                                        <th style="text-align: center;">จำนวนครั้ง</th>
                                                                                        <th style="text-align: center;">คะแนน</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php foreach ($score_person as $i => $row) {
                                                                                        if ($row_lessons->lesson_id == $row['lesson_id']) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td style="text-align: center;"><?php echo $row['prob_id']; ?></td>
                                                                                            <td ><?php echo $row['prob_name']; ?></td>
                                                                                            <td style="text-align: center;"><?php echo $row['time_spent']; ?></td>
                                                                                            <td style="text-align: center;"><?php echo $row['sub_num']; ?></td>
                                                                                            <td style="text-align: center;"><?php echo $row['score']; ?></td>
                                                                                        </tr>
                                                                                        <?php }
                                                                                    } ?>
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
                                                    <!-- Data Table area End-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- Group -->
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Accordion area End-->

<script>
$(document).ready(function () {

    $('#data_table').DataTable({
    })


});
</script>