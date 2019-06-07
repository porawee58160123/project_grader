<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="accordion-area">
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 2.3%; padding-left:0px; padding-right:0px;">
            <div class="accordion-wn-wp">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="accordion-stn">
                            <div class="panel-group" data-collapse-color="nk-blue" id="accordionBlue" role="tablist" aria-multiselectable="true">
                                <div  class="panel panel-collapse notika-accrodion-cus">
                                    <div class="panel-heading" role="tab" >
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordionBlue" href="#accordionBlue-one" aria-expanded="true">
                                                เพิ่มโจทย์ปัญหา
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="accordionBlue-one" class="collapse" role="tabpanel">
                                        <div class="panel-body">
                                            <!-- form add prob -->
                                                <div class="container">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-t-20">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                    <div class="nk-int-mk sl-dp-mn pull-left">
                                                                            <h2>ข้อ</h2>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="nk-int-st">
                                                                            <input id="prob_id" type="text" class="form-control" required >
                                                                        </div>
                                                                        <div id="error_prob_id"></div>
                                                                    </div>
                                                                </div> <!-- col 3 -->
                                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                                    <div class="nk-int-mk sl-dp-mn pull-left">
                                                                        <h2>ชื่อโจทย์</h2>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="nk-int-st">
                                                                            <input id="prob_name" type="text" class="form-control" required >
                                                                        </div>
                                                                        <div id="error_prob_name"></div>                                                                        
                                                                    </div>
                                                                </div> <!-- col 5 -->
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >
                                                                    <div class="nk-int-mk sl-dp-mn pull-left">
                                                                        <h2>จำนวนครั้ง</h2>
                                                                        <!-- max = 10 -->
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="nk-int-st">
                                                                            <input id="prob_limits" type="number" class="form-control" min="0" max="10" required >
                                                                        </div>
                                                                        <div id="error_prob_limits"></div>
                                                                    </div>
                                                                </div> <!-- col 3 -->
                                                            </div>
                                                        </div>
                                                    
                                                <!-- Dropzone area Start-->
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                            <div class="dropdone-nk ">
                                                                <div class="cmp-tb-hd">
                                                                    <h2>อัปโหลดไฟล์ solution (.cpp, config) และไฟล์โจทย์ (PDF)</h2>
                                                                </div>
                                                                <div id="file_upload" class="dropzone dropzone-nk needsclick dz-max-files-reached">
                                                                    <input id="lessons_id" type="hidden" value="<?php echo $lessons_id ;?>">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Dropzone area End-->
                                                <div class="contrainer">
                                                    <div class="row">
                                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 " style="margin-left: -2.7%;">
                                                                <button style="width: 140px" id="prob_submit" class="pull-right btn btn-primary notika-btn-primary waves-effect">บันทึก</button>
                                                             <!-- col 2 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </form> add prob -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                    <th style="text-align: center;">สถานะ</th>
                                    <th style="text-align: center; width:150px">จำนวนในการส่ง</th>
                                    <th style="text-align: center;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ( $problems->result() as $key => $row ){ 
                            ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $row->prob_id; ?></td>
                                    <td><a id="<?php echo $row->prob_id; ?>" class="prob_pdf_show" href="" data-toggle="modal" data-target="#myModalthree"><?php echo $row->name; ?></a></td>
                                    
                                    <td style="text-align: center;">
                                        <div class="toggle-select-act sm-res-mg-t-5">
                                            <div class="nk-toggle-switch " data-ts-color="blue">
                                            <?php 
                                                if($row->active == 1 ){ 
                                            ?>
                                                <input class="status_prob" name="<?php echo $row->prob_id; ?>" id="<?php echo $key ;?>" type="checkbox" hidden="hidden" value="<?php echo $row->active ;?>" checked>
                                                <label for="<?php echo $key ;?>" class="ts-helper"></label>
                                            <?php
                                                }else{
                                            ?> 
                                                <input class="status_prob" name="<?php echo $row->prob_id; ?>" id="<?php echo $key ;?>" type="checkbox" hidden="hidden" value="<?php echo $row->active ;?>" >
                                                <label for="<?php echo $key ;?>" class="ts-helper"></label>
                                            <?php 
                                                }
                                             ?>
                                                
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;" ><?php if($row->limit == 0){echo "ไม่จำกัด";}else{echo $row->limit;} ;?></td>
                                    <td style="text-align:center;">
                                        <button name="edit_prob" id="<?php echo $row->prob_id ;?>" data-toggle="modal" data-target="#myModalone" class="edit_prob btn btn-orange orange-icon-notika btn-reco-mg btn-button-mg waves-effect" ><i class="notika-icon notika-edit"></i></button> 
                                        <button name="del_prob" id="<?php echo $row->prob_id ;?>" class="del_prob btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect"><i class="notika-icon notika-close"></i>
                                    </td>
                                </tr>
                            <?php 
                                } 
                            ?>
                            </tbody>
                            <tfoot>
                                <tr></tr>
                            </tfoot>
                        </table>
                        <!-- modal pdf -->
                        <div class="modal fade" id="myModalthree" role="dialog">
                            <div class="modal-dialog" style="width:90%">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="show_pdf_data" ></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- close modal pdf -->
                         <!-- modal edit -->
                        <div class="modal fade" id="myModalone" role="dialog" >
                            <div class="modal-dialog modal-large">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 id="header_prob"></h1>
                                        <hr class="divider">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" style="margin-top:2%;margin-bottom:2%">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <div class="nk-int-mk sl-dp-mn pull-left">
                                                    <h2 style="margin-left: 0px;">ข้อ</h2>
                                                </div>
                                                <div class="form-group">
                                                    <div class="nk-int-st">
                                                        
                                                        <input type="text" id="edit_prob_id" name="edit_prob_id"  class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div> <!-- col 4 -->
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <div class="nk-int-mk sl-dp-mn pull-left" style="width: 100%;" >
                                                    <h2 style="margin-left: 0px;">ชื่อโจทย์</h2>
                                                    <div class="form-group">
                                                        <div class="nk-int-st">
                                                            <input  type="text" id="edit_prob_name" name="edit_prob_name" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- col 4 -->
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
                                                <div class="nk-int-mk sl-dp-mn pull-left">
                                                    <h2 style="margin-left: 0px;">จำนวนในการส่ง</h2>
                                                </div>
                                                <div class="form-group">                                                
                                                    <div class="nk-int-st">
                                                        <input type="number" id="edit_prob_limit" name="edit_prob_limit" min="0" max="10" class="form-control" >
                                                    </div>
                                                    <div id="edit_error_num"></div>
                                                </div>
                                            </div> <!-- col 4 -->
                                        </div>
                                        <div class="row" style="margin-top:2%">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:2%">
                                                <div class="nk-int-mk sl-dp-mn">
                                                    <h2 id="pdf_name" style="padding-top: 7px;"></h2>
                                                </div>
                                            </div> <!-- col 12 -->
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                                <div id="pdf_data"></div>
                                            </div> <!-- col 6 -->
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                                                <div id="edit_file_upload" class="dropzone edit_dropzone dropzone-nk needsclick" style="min-height:300px">
                                                    <input id="edit_file_id" type="hidden">
                                                </div>
                                            </div> <!-- col 6 -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="edit_submit" type="button" class="btn btn-primary notika-btn-primary waves-effect" data-dismiss="modal">บันทึก</button>
                                        <button type="button" class="btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <!-- close modal edit -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->

<script>
$( document ).ready(function() {

    $('#edit_prob_limit').keyup(function (e) {
        e.preventDefault();
        if( $('#edit_prob_limit').val() > 10 || $('#edit_prob_limit').val() < 0 ){
            $('#edit_error_num').html('<p style="color:red;"> กรุณาพิมพ์จำนวนในการส่งไม่เกิน 10 ครั้ง </p>').show();
            $('#edit_submit').prop('disabled', true);
        }else{
            $('#edit_error_num').hide();
            $('#edit_submit').prop('disabled', false);
        }
    });
    $('#prob_limits').keyup(function (e) {
        e.preventDefault();
        if( $('#prob_limits').val() > 10 || $('#prob_limits').val() < 0){
            $('#error_prob_limits').html('<p style="color:red;"> กรุณาพิมพ์จำนวนในการส่งไม่เกิน 10 ครั้ง </p>').show();
            $('#prob_submit').prop('disabled', true);
        }else{
            $('#error_prob_limits').hide();
            $('#prob_submit').prop('disabled', false);
        }
    });
  
    Dropzone.autoDiscover = false;
    // insert file 
    var my_dropzone = new Dropzone("#file_upload",{
        url: "<?php echo base_url().'index.php/ManageProblems/insert_file' ;?>",
        maxfilesize:10,
        dictDefaultMessage: "<h2 style='padding-top: 20px'>คลิกเพื่อเลือกอัปโหลดไฟล์  <p style=\"color:red;\">ขนาด PDF ไม่เกิน 1 mb</p></h2>",
        addRemoveLinks: true,
        autoProcessQueue:false,
        prob_id: '', // hold parameter 
        lessons_id : $('#lessons_id').val(),
        init: function() {
            this.on("addedfile", function(file, progress) {
                
                if(file['type'] == 'application/pdf' && file['size'] > 1000000 ){
                    swal({   
                        title: "<p style='color:red'> ไม่สามารถอัปโหลดไฟล์ ! กรุณาตรวจสอบขนาดไฟล์</p>",
                        showConfirmButton: true,
                    }).then(function(){
                        file.previewElement.remove();
                    });
                }
            });

            let myDropzone = this
            $("#prob_submit").click(function (e) { 
                e.preventDefault();
                var myDropzone = Dropzone.forElement(".dropzone");
                var lessons_id = $('#lessons_id').val();
                var prob_id = $('#prob_id').val();
                var prob_name = $('#prob_name').val();
                var prob_limits = $('#prob_limits').val();

                 // check required 
                if(prob_id == ""){
                    $('#error_prob_id').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณาตั้งชื่อข้อ !</p>').show();
                    return;
                } 
                if(prob_name == ""){
                    $('#error_prob_name').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณาตั้งชื่อโจทย์ !</p>').show();
                    return;
                } 
                if(prob_limits == ""){
                    $('#error_prob_limits').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณาใส่จำนวนครั้ง !</p>').show();
                    return;
                }else{
                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url().'index.php/ManageProblems/create_problems' ;?>",
                        data: {prob_id:prob_id, prob_name:prob_name, prob_limits:prob_limits,lessons_id:lessons_id },
                        success: function (data,status) {
                            
                                myDropzone.on("sending", function(file, xhr, formData){
                                        //sending prob_id
                                        formData.append("prob_id", prob_id);                         
                                        formData.append("lessons_id",lessons_id);                         
                                })  
                                myDropzone.processQueue();
                                location.reload();  
                        }
                    });
                }
      
            });
           
        }              
    }); // close my_dropzone

    // edit file
    var edit_dropzone = new Dropzone('#edit_file_upload',{
        url: "<?php echo base_url().'index.php/ManageProblems/edit_file_upload' ;?>",
        maxfilesize:10,
        dictDefaultMessage: "<h2 style='padding-top: 97px'>คลิกเพื่อเลือกอัปโหลดไฟล์ที่แก้ไข <p style=\"color:red;\">ขนาด PDF ไม่เกิน 1 mb</p></h2>",
        addRemoveLinks: true,
        autoProcessQueue:false,
        edit_prob_id: '', // hold parameter 
        init: function() {
            // check size file
            this.on("addedfile", function(file, progress) {
                if(file['size'] > 1000000){
                    swal({   
                        title: "<p style='color:red'> ไม่สามารถอัปโหลดไฟล์ ! กรุณาตรวจสอบขนาดไฟล์</p>",
                        showConfirmButton: true,
                    }).then(function(){
                        // remove file 
                        file.previewElement.remove();
                        
                    });
                }
            });

            $("#edit_submit").click(function (e) { 
                e.preventDefault();
                var thisDropzone = Dropzone.forElement(".edit_dropzone");;
                var edit_prob_id = $('#edit_prob_id').val();
                var edit_lessons_id = $('#lessons_id').val();
                var edit_prob_name = $('#edit_prob_name').val();
                var edit_prob_limit = $('#edit_prob_limit').val();
                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url().'index.php/ManageProblems/update_prob' ;?>",
                        data: {
                                edit_prob_id:edit_prob_id,
                                edit_prob_name:edit_prob_name, 
                                edit_prob_limit:edit_prob_limit, 
                                edit_lessons_id:edit_lessons_id 
                            },
                        success: function (response,status) {
                                    thisDropzone.on("sending", function(file, xhr, formData){
                                        //sending prob_id
                                        formData.append("edit_prob_id", edit_prob_id);                        
                                    }) 
                                    thisDropzone.processQueue();
                                    swal({   
                                        title: "<p> อัปเดตไฟล์สำเร็จ !</p>",
                                        showConfirmButton: true,
                                    }).then(function(){
                                        location.reload();
                                    });
                        },
                        error: function (req, status, err) {
                            console.log('error ', status, err);
                        }
                    });
      
            });
           
        }     
    });// close edit_dropzone

    $('.status_prob').change(function (e) { 
        e.preventDefault();
        var prob_id = $(this).attr("name");
        var lessons_id = $('#lessons_id').val();
        var active = $(this).val();
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'index.php/ManageProblems/update_prob_status' ;?>",
            data: {prob_id:prob_id,lessons_id:lessons_id,prob_active:active},
            success: function (data) {
            }
        });
    });

    
}); // close doc ready


$('.prob_pdf_show').click(function (e) { 
    e.preventDefault();
    var prob_id = $(this).attr("id");
    $.ajax({
        type: "post",
        url: "<?php echo base_url().'index.php/ManageProblems/show_problem_pdf' ;?>",
        data: {prob_id:prob_id},
        success: function (data) {
            // show output from controller
            $('#show_pdf_data').html(data);
            
        },
        error: function (req, status, err) {
            console.log('error ', status, err);
        }
    });
    
});


$('.del_prob').on('click', function(){
    var prob_id = $(this).attr("id");
    var lessons_id = $('#lessons_id').val();

    swal({   
        title: "ต้องการลบ"+""+" ?",   
        text: "กรุณาตรวจสอบความถูกต้องของข้อมูล !",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: '#03A9F4',
        confirmButtonText: "ตกลง",
        cancelButtonText: "ยกเลิก",
    }).then(function(isConfirm){
        if (isConfirm) {   
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'index.php/ManageProblems/delete_prob' ;?>",
                data: {prob_id:prob_id,lessons_id:lessons_id},
                success: function (data) {
                    location.reload()
                }
            });   
        } else {     
            swal("Cancelled", "Your imaginary file is safe :)", "error");   
        } 
    });
});

$('.edit_prob').click(function (e) { 
    e.preventDefault();
    var prob_id = $(this).attr("id");

    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'index.php/ManageProblems/search_edit_problem_id' ;?>",
        data: {prob_id:prob_id},
        dataType: "json",
        success: function (data) {
            
            if(data == 0){
                $('#header_prob').html("ไม่พบข้อมูลภายในระบบ !");
            }else{

                $('#header_prob').html("แก้ไขโจทย์ปัญหา : " + data.prob_id);
                $('#edit_prob_id').val(data.prob_id);
                $('#edit_prob_name').val(data.prob_name);
                $('#edit_prob_limit').val(data.limit);
                $('#edit_file_id').val(data.pdf_id);
                    
                    if(data.pdf_data == null || data.pdf_data == ""){
                        $('#pdf_name').html("ไม่พบข้อมูลเอกสาร");                
                    } else {
                        $('#pdf_data').html('<object type="application/pdf" data="data:application/pdf;base64,' + data.pdf_data + '" style="height:300px;width:100%" ></object>')
                        $('#pdf_name').html("ชื่อเอกสาร : " + data.pdf_name);
                    }
            }

        }, error: function (req, status, err) {
            console.log('error ', status, err);
        }
    });
    
    
});

$('#prob_id').keyup(function (e) { 
    e.preventDefault();
    $('#error_prob_id').hide();
});
$('#prob_name').keyup(function (e) { 
    e.preventDefault();
    $('#error_prob_name').hide();
});
$('#prob_limits').keyup(function (e) { 
    e.preventDefault();
    $('#error_prob_limits').hide();
});


</script>