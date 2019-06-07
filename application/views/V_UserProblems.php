<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 2.3%;">
                <div class="data-table-list">
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ข้อ</th>
                                    <th style="text-align: center;">ชื่อโจทย์</th>
                                    <th style="text-align: center; width:150px">จำนวนในการส่ง</th>
                                    <th style="text-align: center;">คะแนน</th>
                                    <th style="text-align: center;">ผลลัพธ์</th>
                                    <th style="text-align: center;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // CHECK STATUS PROB_ID 
                                if(empty($user_prob)){
                                    
                                }else{
                                    foreach ($user_prob as $i => $row) {

                                        if($row['compiler_msg'] != ''){
                                            $msg = substr($row['compiler_msg'],0,37)."...";
                                        }else{
                                            $msg = "<p style='color:red'> ยังไม่ส่ง!!! </p>";
                                        }

                                    ?> 
                                        <tr>
                                            <td style="text-align: center;"><?php echo $row['prob_id'];?></td>
                                            <td>
                                            <a href="#" id="<?php echo $row['prob_id']; ?>" class="prob_pdf_show" onclick="timestamp_open_pdf('<?php echo $row['prob_id']; ?>')" ><?php echo $row["prob_name"];?></a>
                                                
                                            </td>
                                            <td style="text-align: center;">
                                                <?php 
                                                    if($row['limit'] == "0"){
                                                        if($row['sub_num'] == ''){
                                                            echo "0"."/"." ไม่จำกัด";
                                                        }else{
                                                            echo $row['sub_num']."/"." ไม่จำกัด";
                                                        }
                                                    } else {
                                                        if($row['sub_num'] == ''){
                                                            echo "0"."/"."(".$row['limit'].")";
                                                        }else{
                                                            echo $row['sub_num']."/"."(".$row['limit'].")";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo "(".$row['score'].")"." ".$row['grading_msg'];?> </td>
                                            <td style="text-align: center;"><a href="#" onclick="show_msg('<?php echo $row['prob_id'];?>',`<?php echo str_replace('\n','{br}',$row['compiler_msg']) ;?>`)">ผลการตรวจสอบ</a></td>
                                            <td style="text-align: center;"> 
                                                    <?php 
                                                    // Check submit num
                                                        if($row['sub_num'] == $row['limit'] ) {
                                                    ?>
                                                            <button class="modal_code btn btn-danger notika-btn-danger waves-effect" id="<?php echo $row['prob_id'] ;?>" data-toggle="modal" data-target="#modal_source_code" disabled>ครบจำนวนครั้งในการส่ง</button> 
                                                    <?php 
                                                    // Check dua_date 
                                                        }else if( strtotime(date('Y-m-d')) >= strtotime($row['due_date']) ){
                                                    ?>
                                                            <button class="modal_code btn btn-danger notika-btn-danger waves-effect" id="<?php echo $row['prob_id'] ;?>" data-toggle="modal" data-target="#modal_source_code" disabled>เกินวันกำหนดส่ง</button> 
                                                    <?php
                                                        }else if($row['limit'] != null ){
                                                    ?>
                                                            <button class="modal_code btn btn-primary notika-btn-primary waves-effect" id="<?php echo $row['prob_id'] ;?>" data-toggle="modal" data-target="#modal_source_code">ส่งงาน</button> 
                                                    <?php 
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                    <?php 
                                    }// foreach
                                }//ESLE
                                ?>
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

<!-- modal pdf -->
<div class="modal fade" id="modal_pdf" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="prob_id_name" style="margin-bottom:0px"></h3>
            </div>
            <div class="modal-body">
                <div id="show_pdf_data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="check_time" class="btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<!-- close modal pdf -->

<!-- modal pdf -->
<div class="modal fade" id="modal_msg" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="msg_title" style="margin-bottom:0px"></h3>
            </div>
            <div class="modal-body">
                <pre id="show_msg_data"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" id="check_time" class="btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<!-- close modal pdf -->

<!-- modal source code -->
<div class="modal fade" id="modal_source_code" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="prob_title" style="margin-bottom:0px"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <form id="file_code" enctype="multipart/form-data" method="post" name="fileinfo">
                        <h4>Upload main .cpp file (main program) : </h4>
                        <div  style="padding-top: 20%; margin-left: 25%;">  
                            <input  type="file" name="code" >
                            <input id="upload_main_prob_id" type="hidden" name="prob_id">
                            <input id="upload_main_lessons_id" type="hidden" name="lessons_id">
                        </div>
                    </form>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h4>Upload other .cpp / .h files : </h4>
                        <div id="upload_code" class="upload_code_dropzone dropzone dropzone-nk needsclick" style="min-height:300px">
                            <input id="upload_prob_id" type="hidden">
                            <input id="upload_lessons_id" type="hidden">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save_source_code" type="button" class=" btn btn-primary notika-btn-primary waves-effect" data-dismiss="modal">บันทึก</button>
                <button type="button" class=" btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<!-- modal source code -->


<script>
$(document).ready(function () {
    $('#data_table').DataTable({});
        Dropzone.autoDiscover = false;

    var upload_code = new Dropzone('#upload_code',{
        url: "<?php echo base_url().'index.php/UserProblems/process_submission' ;?>",
        maxfilesize:10,
        dictDefaultMessage: "<h2 style='padding-top: 97px'>คลิกเพื่อเลือกอัปโหลดซอร์สโค้ดอื่น ๆ (.h, .cpp) </h2>",
        addRemoveLinks: true,
        autoProcessQueue:false,
        edit_prob_id: '', // hold parameter 
        init: function() {

            this.on("addedfile", function(file, progress) {
               
            });
            

            $("#save_source_code").click(function (e) { 
                e.preventDefault();
                var thisDropzone = Dropzone.forElement(".upload_code_dropzone");
                var prob_id = $('#upload_prob_id').val();
                var lessons_id = $('#upload_lessons_id').val();
                
                // SEND MAIN CODE TO GRADER
                var file_main_code = new FormData($("#file_code")[0]);

                $.ajax({
                    url: '<?php echo base_url().'index.php/UserProblems/process_submission' ;?>',  
                    type: 'POST',
                    data: file_main_code,
                    success:function(data){
                        console.log(data)
                        if(data == "refesh"){
                            swal({  
                                text:"กรุณารอซักครู่. . .!"
                            });
                            window.setTimeout(function(){
                                window.location.reload()
                                }, 2000);  
                        }
                    },
                    processData: false, 
                    contentType: false, 
                });
                // SEND ABOTHER CODE TO GRADER
                thisDropzone.on("sending", function(file, xhr, formData){
                            //sending prob_id
                            formData.append("prob_id", prob_id);                         
                            formData.append("lessons_id",lessons_id);                         
                        })
                thisDropzone.processQueue();

                thisDropzone.on("success", function(file, responseText) {
                    swal({  text:"กรุณารอซักครู่. . .!",
                            button: false,
                    });
                    window.setTimeout(function(){
                        window.location.reload()
                        }, 2000);  
                });
            });
           
        }   
    });// close edit_dropzone
});

$('.prob_pdf_show').click(function (e) { 
    e.preventDefault();
    var prob_id = $(this).attr("id");
    $.ajax({
        type: "post",
        url: "<?php echo base_url().'index.php/UserProblems/show_problem_pdf' ;?>",
        data: {prob_id:prob_id},
        success: function (data) {
            // show output from controller
            $('#show_pdf_data').html(data);
            $('#prob_id_name').html("ข้อ : "+prob_id);
           
            
        },
        error: function (req, status, err) {
            console.log('error ', status, err);
        }
    });
    
});

function timestamp_open_pdf(prob_id){
    $('#modal_pdf').modal('show')
    $.post( "<?php echo base_url()."index.php/UserProblems/insert_time_open_pdf"; ?>", { prob_id: prob_id } );

}

function show_msg(prob_id,msg){
    $("#modal_msg").modal('show')
    $('#msg_title').html("ข้อ : "+prob_id);
    $('#show_msg_data').html(msg.replace(/"/g, '\'').split('{br}').join('<br>'));

}

$('.modal_code').click(function (e) {
    var prob_id = $(this).attr("id");
    $.ajax({
        type: "post",
        url: "<?php echo base_url()."index.php/UserProblems/get_prob_name";?>",
        data: {prob_id:prob_id},
        dataType: "json",
        success: function (data) {
            $('#prob_title').html(data.prob_id + " : " + data.prob_name)
            $('#upload_lessons_id').val(data.lesson_id);
            $('#upload_prob_id').val(data.prob_id);
            $('#upload_main_lessons_id').val(data.lesson_id);
            $('#upload_main_prob_id').val(data.prob_id);
           
        }
    });
});
</script>

