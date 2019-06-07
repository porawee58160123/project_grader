<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>


<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 2.3%;">
            <div class="dropdone-nk" style="padding-bottom:55px">
                <div class="cmp-tb-hd">
                    <h2>อัปโหลดไฟล์รายชื่อผู้ใช้ (.CSV)</h2>
                </div>
                <div id="csv_upload" class="dropzone dropzone-nk needsclick dz-max-files-reached">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="margin-top:1%; padding-right:0px" >
                        <button style="width: 140px" id="prob_submit" class="pull-right btn btn-primary notika-btn-primary waves-effect">บันทึก</button>
                    <!-- col 12 -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    Dropzone.autoDiscover = false;
    var csv_file = new Dropzone("#csv_upload",{
        url: "<?php echo base_url().'index.php/ManageUser/insert_csv_file' ;?>",
        maxfilesize:10,
        dictDefaultMessage: "<h2 style='padding-top: 20px'>คลิกเพื่อเลือกอัปโหลดไฟล์ ",
        addRemoveLinks: true,
        autoProcessQueue:false,
        init: function() {
            let myDropzone = this
            $("#prob_submit").click(function (e) { 
                e.preventDefault();
                var myDropzone = Dropzone.forElement(".dropzone"); 
                myDropzone.processQueue();
                swal({
                    title: '<div class="loader" style="margin-left:37%"></div>',
                    text: 'กรุณารอซักครู่. . .',
                    showCancelButton: false,
                    showConfirmButton: false
                })
            });
           
        },
        success: function(file, response){
            swal({   
                title: "อัปโหลดสำเร็จ !",
                showConfirmButton: true,
            }).then(function(){
                window.location.replace("<?php echo base_url('index.php/ManageUser/show_user')?>");
            });
        }         
    }); // close my_dropzone
});

</script>
<style>
/* loader css default */
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>