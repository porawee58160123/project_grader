<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top: 2.3%;">
                <div class="data-table-list">
                    <div id="user_table" class="table-responsive">

                        <table id="user_data" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">รหัสนิสิต</th>
                                    <th style="text-align: center;">ชื่อ-สกุล</th>
                                    <th style="text-align: center;">กลุ่ม</th>
                                    <th style="text-align: center;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($user_data->result() as $i => $row) {
                                ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo $row->user_id ;?></td>
                                    <td ><?php echo $row->name ;?></td>
                                    <td style="text-align: center;"><?php if ($row->grp == "*") {
                                                                            echo "ทั้งหมด";
                                                                        } else {
                                                                            echo $row->grp ;
                                                                        }?></td>
                                    <td style="text-align: center;">   
                                        <button name="edit_user" id="<?php echo $row->user_id ;?>" data-toggle="modal" data-target="#user" class="edit_user btn btn-orange orange-icon-notika btn-reco-mg btn-button-mg waves-effect" ><i class="notika-icon notika-edit"></i></button> 
                                        <button name="del_user" id="<?php echo $row->user_id ;?>" class="del_user btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect"><i class="notika-icon notika-close"></i>
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
                <div class="modal fade" id="user" role="dialog">
                    <div class="modal-dialog modals-default">
                        <div class="modal-content">
                            <form id="update_user" method="post">
                                <div class="modal-header">
                                <h1 id="header_user"></h1>
                                <hr class="divider">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" style="padding-top:2%">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="nk-int-mk sl-dp-mn pull-left">
                                                <h2 style="margin-left: 0px;">ชื่อ-สกุล</h2>
                                            </div>
                                            <div class="form-group">
                                                <div class="nk-int-st">
                                                    <input type="text" id="edit_user_name" name="edit_user_name"  class="form-control" >
                                                    <input type="hidden" id="user_id"  name="user_id" >
                                                </div>
                                            </div>
                                        </div> <!-- col 6 -->
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="nk-int-mk sl-dp-mn pull-left">
                                                <h2 style="margin-left: 0px;">กลุ่ม</h2>
                                            </div>
                                            <div class="form-group">
                                                <div class="bootstrap-select fm-cmp-mg">
                                                    <select id="edit_user_grp" name="edit_user_grp" class="selectpicker">
                                                        <option value="*">ทั้งหมด</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> <!-- col 6 -->
                                    </div>
                                    <div class="row " style="margin-top:2%">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="nk-int-mk sl-dp-mn">
                                                <h2 style="margin-left: 0px;margin-bottom: 0px;">รหัสผ่านใหม่</h2>
                                            </div>
                                            <div class="form-group ic-cmp-int form-elet-mg">
                                                <div class="nk-int-st">
                                                    <input type="password" id="edit_user_pass" name="edit_user_pass"  class="form-control" >
                                                </div>
                                                <div class="form-ic-cmp">
                                                    <button type="button" class="btn" id="eye" style="background:none;" ><i  class="e fa fa-eye" style="position:initial;"></i></button>
                                                </div>
                                            </div>
                                        </div> <!-- col 6 -->
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="nk-int-mk sl-dp-mn">
                                                <h2 style="margin-left: 0px;">ยืนยันรหัสผ่าน</h2>
                                            </div>
                                            <div class="form-group">
                                                <div class="nk-int-st">
                                                    <input type="password" id="edit_user_cfpass" name="edit_user_cfpass"  class="form-control" >
                                                </div>
                                                <div id="error_cf_pass"><p style="color:red">กรุณากรอกรหัสให้ตรงกัน !</p></div>
                                            </div>
                                        </div> <!-- col 6 -->
                                    </div>
                                </div>
                                <div class="modal-footer mg-t-20">
                                    <button type="edit_user_submit"  name="submit" id="submit" class="btn btn-primary notika-btn-primary waves-effect" data-dismiss="modal">บันทึก</button>
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
    $('#error_cf_pass').hide();
    $('#user_data').DataTable(); 

}); // close doc ready

// icon hide/show password tag
$('#eye').click(function () { 
    if($('#edit_user_pass').attr('type') == 'password'){
        $('#edit_user_pass').prop('type','text');
        $('.e').prop('class','e fa fa-eye-slash');
    }else{
        $('#edit_user_pass').prop('type','password');
        $('.e').prop('class','e fa fa-eye');
    }
});

$('#edit_user_cfpass').keyup(function (e) { 
    if( $('#edit_user_pass').val() != $('#edit_user_cfpass').val() ){
        $('#error_cf_pass').show();
    }else{
        $('#error_cf_pass').hide();
    }   
});

// get user edit
$('.edit_user').click(function (e) { 
    e.preventDefault();
    var edit_user_id = $(this).attr("id");
    $.ajax({
        type: "post",
        url: "<?php echo base_url()."index.php/ManageUser/search_user";?>",
        data: {edit_user_id:edit_user_id},
        dataType: "json",
        success: function (data) {
            $('#header_user').html('<h2>แก้ไขข้อมูล : '+data[0].user_id+'</h2>');
            $('#user_id').val(data[0].user_id);
            $('#edit_user_name').val(data[0].name);
            $('select[name=edit_user_grp]').val(data[0].grp);
            $('.selectpicker').selectpicker('refresh');
        }
    });
    
});

$('#update_user').on("click","#submit", function(e){  
    e.preventDefault();
    $.ajax({  
            url:"<?php echo base_url()."index.php/ManageUser/update_user";?>",  
            type:"POST",  
            // serialize = pack data in form
            data:$('#update_user').serialize(),  
            success:function(data){  
                $('#update_user')[0].reset(); 
                swal({   
                    title: "อัปเดตข้อมูลสำเร็จ !",
                    showConfirmButton: true,
                }).then(function(){
                    location.reload();
                });
            }  
    });   
});

$('.del_user').on('click', function(){
    var user_id = $(this).attr("id");

    swal({   
        title: "ต้องการลบ "+user_id+" ?",   
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
                url: "<?php echo base_url().'index.php/ManageUser/delete_user' ;?>",
                data: {user_id:user_id},
                success: function (data) {
                    location.reload()
                }
            });   
        } else {     
            swal("Cancelled", "Your imaginary file is safe :)", "error");   
        } 
    });
});


</script>