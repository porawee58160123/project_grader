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
                                                เพิ่มบทเรียน
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="accordionBlue-one" class="collapse" role="tabpanel">
                                        <div class="panel-body">
                                            <!-- form add Lessons -->
                                            <form id="lesson_form" method="post" autocomplete="off">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="nk-int-mk sl-dp-mn pull-left">
                                                                        <h2>ชื่อบทเรียน</h2>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="nk-int-st">
                                                                            <input type="text" id="name" name="name"  class="form-control" required>
                                                                        </div>
                                                                        <div id="error_less_name"></div>
                                                                    </div>
                                                                </div> <!-- col 3 -->
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                    <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                                                                        <label>กำหนดส่ง</label>
                                                                        <div class="input-group date nk-int-st">
                                                                            <span class="input-group-addon"></span>
                                                                            <input  type="text" id="due_date" name="due_date" class="form-control" required>
                                                                        </div>
                                                                        <div id="error_less_date"></div>                                                                        
                                                                    </div>
                                                                </div> <!-- col 3 -->
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                                                                    <div class="nk-int-mk sl-dp-mn pull-left">
                                                                        <h2>เลือกกลุ่ม</h2>
                                                                    </div>
                                                                    <div class="bootstrap-select fm-cmp-mg">
                                                                        <select name="grp" class="selectpicker">
                                                                            <option value="*">ทั้งหมด</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                        </select>
                                                                    </div>
                                                                </div> <!-- col 3 -->
                                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding-left:50px"> 
                                                                    <button id="lesson_submit" class="btn btn-primary notika-btn-primary waves-effect" style="margin-top: 26px; width: 140px;">บันทึก</button>
                                                                </div> <!-- col 3 -->
                                                            </div>
                                                        </div>
                                                    </div>
                                            </form>
                                            <!-- </form> add Lessons -->
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
                    <div id="lessons_table" class="table-responsive">

                        <table id="data_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ชื่อบทเรียน</th>
                                    <th style="text-align: center;">กำหนดส่ง</th>
                                    <th style="text-align: center;">กลุ่ม</th>
                                    <th style="text-align: center;">สถานะ</th>
                                    <th style="text-align: center;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($lessons->result() as $i => $row) {
                                ?>
                                    <tr>
                                    
                                        <td ><a href="<?php echo base_url('index.php/ManageProblems/index/'.$row->id.'/');
                                                    if ($row->grp == "*") {
                                                        echo "0";
                                                    } else {
                                                        echo $row->grp;
                                                    } ?>"> <?php echo $row->name; ?> </a>
                                        </td>  
                                        <td style="text-align: center;"><?php echo $row->due_date; ?></td>                                  
                                        <td  style="text-align: center;"><?php if ($row->grp == "*") {
                                                                            echo "ทั้งหมด";
                                                                        } else {
                                                                            echo $row->grp ;
                                                                        }?></td>
                                        <td style="text-align: center;">
                                            <div class="toggle-select-act sm-res-mg-t-5">
                                                <div class="nk-toggle-switch " data-ts-color="blue">
                                                <?php 
                                                    if($row->active == 1 ){ 
                                                ?>
                                                    <input class="status" id="<?php echo $row->id ;?>" type="checkbox" hidden="hidden" value="<?php echo $row->active ;?>" checked>
                                                    <label for="<?php echo $row->id ;?>" class="ts-helper"></label>
                                                <?php
                                                    }else{
                                                ?> 
                                                    <input class="status" id="<?php echo $row->id ;?>" type="checkbox" hidden="hidden" value="<?php echo $row->active ;?>" >
                                                    <label for="<?php echo $row->id ;?>" class="ts-helper"></label>
                                                <?php 
                                                    }
                                                ?>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <button name="edit" id="<?php echo $row->id ;?>" data-toggle="modal" data-target="#myModalone" class="edit btn btn-orange orange-icon-notika btn-reco-mg btn-button-mg waves-effect" ><i class="notika-icon notika-edit"></i></button> 
                                            <button name="del" id="<?php echo $row->id ;?>" class="del btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect"><i class="notika-icon notika-close"></i>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->

<!-- Modals area start-->
<div class="modals-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="modal fade" id="myModalone" role="dialog">
                    <div class="modal-dialog modals-default">
                        <div class="modal-content">
                            <form id="update" method="post">
                                <div class="modal-header">
                                <h1 id="header_lessons"></h1>
                                <hr class="divider">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" style="padding-top:2%">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="nk-int-mk sl-dp-mn pull-left">
                                                <h2 style="margin-left: 0px;">ชื่อบทเรียน</h2>
                                            </div>
                                            <div class="form-group">
                                                <div class="nk-int-st">
                                                <input type="text" id="edit_lessons_name" name="edit_lessons_name"  class="form-control" required>
                                                <input type="hidden" id="edit_id" name="edit_id"  class="form-control" >
                                                </div>
                                            </div>
                                        </div> <!-- col 4 -->
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="form-group nk-datapk-ctm form-elet-mg" id="data_1">
                                                <label>กำหนดส่ง</label>
                                                <div class="input-group date nk-int-st">
                                                    <span class="input-group-addon"></span>
                                                    <input  type="text" id="edit_due_date" name="edit_due_date" class="form-control" >
                                                </div>
                                            </div>
                                        </div> <!-- col 4 -->
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
                                            <div class="nk-int-mk sl-dp-mn pull-left">
                                                <h2>เลือกกลุ่ม</h2>
                                            </div>
                                            <div class="bootstrap-select fm-cmp-mg">
                                                <select id="edit_grp" name="edit_grp" class="selectpicker">
                                                    <option value="*">ทั้งหมด</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                        </div> <!-- col 4 -->
                                    </div>
                                </div>
                                <div class="modal-footer mg-t-20">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary notika-btn-primary waves-effect" data-dismiss="modal">บันทึก</button>
                                    <button type="button" class="btn btn-gray notika-btn-gray waves-effect" data-dismiss="modal">ยกเลิก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals area end--> 

<script>
$(document).ready(function () {
    $('.status').change(function (e) { 
        e.preventDefault();
        var id = $(this).attr('id');
        var active = $(this).val();
        $.ajax({
            type: "post",
            url: "update_status_lessons",
            data: {lessons_id:id,lessons_active:active},
            dataType: "json",
            success: function (data) {
            }
        });
        
    });

    $('#data_table').DataTable( {
        "order": [[ 1, "desc" ]]
    } );

    $(document).on('click','.edit',function(){
        var lessons_id = $(this).attr("id")

        $.ajax({
            type: "POST",
            url: "search_lessons",
            data: {lessons_id:lessons_id},
            dataType: "json",
            success: function (data) {
                $('#edit_id').val(data[0].id);
                $('#edit_lessons_name').val(data[0].name);
                $('#edit_due_date').val(data[0].due_date);
                $('select[name=edit_grp]').val(data[0].grp);
                $('.selectpicker').selectpicker('refresh');
                $('#header_lessons').html("แก้ไขบทเรียน : "+data[0].name)
            }
        });
    })
}); // close doc ready
$('#update').on("click","#submit", function(e){  
    e.preventDefault();
    $.ajax({  
            url:"update_lessons",  
            type:"POST",  
            // serialize = pack data in form
            data:$('#update').serialize(),  
            success:function(data){  
                $('#update')[0].reset();  
                $('#myModalone').modal('hide');  
                $('#lessons_table').html(data); 
                location.reload();
            }  
    });   
}); 

$('.del').on('click', function(){
    var del_lessons_id = $(this).attr("id");
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
                url:"delete",  
                type:"POST",  
                data:{del_lessons_id:del_lessons_id},  
                success:function(data){  
                    location.reload();

                }  
            });     
        } else {     
            swal("Cancelled", "Your imaginary file is safe :)", "error");   
        } 
    });
});


$('#lesson_form').on("click","#lesson_submit", function(e){  
    e.preventDefault();
    if( $('#name').val() === ""){
        $('#error_less_name').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณาตั้งชื่อบทเรียน !</p>').show();
    }else if( $('#due_date').val() === ""){
        $('#error_less_date').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณากำหนดวันส่งงาน !</p>').show();
    }else{
        $('#error_less_name').hide();
        $('#error_less_date').hide();
    
        $.ajax({  
                url:"<?php echo base_url('index.php/ManageLessons/create_lessons');?>",  
                type:"POST",  
                // serialize = pack data in form
                data:$('#lesson_form').serialize(),  
                success:function(data){  
                    if(data == 1){
                        swal({   
                            title: "<p style='color:red' > กรุณาตรวจสอบชื่อบทเรียนไม่ให้ซ้ำ !</p>",
                            showConfirmButton: true,
                        }).then(function(){
                            location.reload();
                        });
                    }else{
                        location.reload();
                    }
                }  
        });
    }   
});

$('#name').keyup(function (e) { 
    e.preventDefault();
    $('#error_less_name').hide();
});
$('#due_date').keyup(function (e) { 
    e.preventDefault();
    $('#error_less_date').hide();
});
</script>
