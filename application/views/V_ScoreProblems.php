<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<!-- Dropdown area start-->
    <div class="dropdown-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="dropdown-list mg-t-30">
                        <div class="row">
                            <div class="pull-left" style="width:100%" >
                                <div class="dropdown-trig-sgn" style="width:100%">
                                    <button class="btn triger-flipInX-dp " data-toggle="dropdown" id="prob_title" style="width:100%"> กรุณาเลือกโจทย์
                                        <i class="fa fa-chevron-circle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu triger-flipInX-dp " style="width:96% ; left:2%">
                                    <?php foreach ($problems_data->result() as $i => $row_problems) { ?>
                                        <li><a href="javascript:get_score('<?php echo $row_problems->prob_id; ?>')"><?php echo $row_problems->prob_id." ".$row_problems->prob_name; ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- Row -->
                    </div><!-- Dropdown list -->
                </div>
            </div><!-- Row -->
        </div><!-- Container -->
    </div>
<!-- Dropdown area End -->

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
                                    <th style="text-align: center;">เวลาที่ใช้</th>
                                    <th style="text-align: center;">จำนวนครั้ง</th>
                                    <th style="text-align: center;">คะแนน</th>
                                </tr>
                            </thead>
                            <tbody id="std_score_problem_data">
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
function get_score(prob_id){

    $.ajax({
        type: "POST",
        url: "<?php echo base_url()."index.php/Score/get_score_data"; ?>",
        data: {prob_id:prob_id},
        dataType: "json",
        success: function(result){
            if(result.length != 0){
                $("#prob_title").html(result[0].prob_name + " <i class=\"fa fa-chevron-circle-down\"></i>")
            }else{
                $("#prob_title").html("ไม่มีนิสิตที่ทำโจทย์ข้อนี้");
            }
            $("#std_score_problem_data").empty()
            
            var tb = ""
            $.each( result, function( key, value ) {
                if(value.grp == "*"){
                    value.grp = "ทั้งหมด";
                }
                tb += "<tr>"
                tb += "<td style=\"text-align: center;\">"+value.user_id+"</td>"
                tb += "<td>"+value.name+"</td>"
                tb += "<td style=\"text-align: center;\">"+value.grp+"</td>"
                tb += "<td style=\"text-align: center;\">"+value.time_diff+"</td>"
                tb += "<td style=\"text-align: center;\">"+value.sub_num+"</td>"
                tb += "<td style=\"text-align: center;\">"+value.score+"</td>"
                tb += "<tr>"
            });
            $("#std_score_problem_data").append(tb)
        }
    });
}

</script>