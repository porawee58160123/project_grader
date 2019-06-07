<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-element-list mg-t-30">
                <div class="cmp-tb-hd">
                    <h2 id="user_id_reset">เปลี่ยนรหัสของ : <?php echo $user_session['name'];?> </h2>
                </div>
                <div class="row">
                    <form id="reset_form" method="POST">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                            <div class="form-group ic-cmp-int ">
                                <div class="form-ic-cmp">
                                    <i class="notika-icon notika-edit"></i>
                                </div>
                                <div class="nk-int-st">
                                    <input id="new_passwd" name="new_passwd" type="password" class="form-control" placeholder="รหัสผ่านใหม่">
                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_session['user_id'];?>">
                                </div>
                                <div id="error_length"></div>
                                <div class="form-ic-cmp">
                                    <button type="button" class="btn" id="eye_reset" style="background:none;" ><i  class="e fa fa-eye" style="position:initial;"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group ic-cmp-int ">
                                <div class="form-ic-cmp">
                                    <i class="notika-icon notika-next"></i>
                                </div>
                                <div class="nk-int-st" >
                                    <input id="cf_passwd" name="cf_passwd" type="password" class="form-control" placeholder="ยืนรหัสผ่าน">
                                </div>
                                <div id="error_cf_pass"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-t-5">
                            <button style="width: 140px; margin-right:10px;margin-left:10px;" class="pull-right btn btn-gray notika-btn-gray waves-effect"> <a href="<?php echo base_url().'index.php/ManageLessons/index';?>" style="color:#fff">ยกเลิก</a></button>
                            <button style="width: 140px" id="reset_submit" class="pull-right btn btn-primary notika-btn-primary waves-effect">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#error_cf_pass').hide();
    $('#error_length').hide();
});

$('#eye_reset').click(function () { 
    if($('#new_passwd').attr('type') == 'password'){
        $('#new_passwd').prop('type','text');
        $('.e').prop('class','e fa fa-eye-slash');
    }else{
        $('#new_passwd').prop('type','password');
        $('.e').prop('class','e fa fa-eye');
    }
});

$('#new_passwd').keyup(function (e) { 
    var num_string = $('#new_passwd').val().length;

    if(num_string < 8){
        $('#error_length').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณาตั้งรหัสผ่านมากกว่า 8 ตัวอักษร !</p>').show();
        $('#reset_submit').prop('disabled', true);
    }else{
        $('#error_length').hide();
        $('#reset_submit').prop('disabled', false);

    }
});
$('#cf_passwd').keyup(function (e) { 
    if( $('#new_passwd').val() != $('#cf_passwd').val() ){
        $('#error_cf_pass').html('<p style="color:red;margin-top:2px;margin-bottom:3px;">กรุณากรอกรหัสให้ตรงกัน !</p>').show();
        $('#reset_submit').prop('disabled', true);
    }else{
        $('#error_cf_pass').hide();
        $('#reset_submit').prop('disabled', false);
    }   
});
$('#reset_form').on('click','#reset_submit',function(e) {
    e.preventDefault();
    $.ajax({  
        url:"<?php echo base_url()."index.php/ResetPassword/reset_passwd";?>",  
        type:"POST",  
        // serialize = pack data in form
        data:$('#reset_form').serialize(),  
        success:function(data){ 
            if(data == 0){
                swal({   
                    title: "<p style='color:red' > อัปเดตข้อมูลไม่สำเร็จ !</p>",
                    showConfirmButton: true,
                }).then(function(){
                    location.reload();
                });
            }else if (data == 2) {
                swal({   
                    title: "<p style='color:red' > เปลี่ยนรหัสผ่านไม่สำเร็จ !</p>",
                    showConfirmButton: true,
                }).then(function(){
                    location.reload();
                });
            }else if(data == 3){
                swal({   
                    title: "<p style='color:red'> กรุณาตั้งรหัสมากกว่า 8 ตัว !</p>",
                    showConfirmButton: true,
                }).then(function(){
                    location.reload();
                });

            }else{
                swal({   
                    title: "<p> อัปเดตข้อมูลสำเร็จ !</p>",
                    showConfirmButton: true,
                }).then(function(){
                    location.reload();
                });
            }
        }  
    });   
    
});


</script>