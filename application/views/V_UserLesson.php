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
                                    <th style="text-align: center;">ชื่อบทเรียน</th>
                                    <th style="text-align: center;">กำหนดส่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($user_lesson->result() as $key => $row) {
                                        if($row->active == 1){
                                            
                                            if($user_session['grp'] == $row->grp || $row->grp == "*"){
                                ?>
                                    <tr>
                                        <td >
                                            <a href="<?php echo base_url('index.php/UserProblems/show_problems_actives/'.$user_session['user_id'].'/'.$row->id);?>"> 
                                                    <?php echo $row->name; ?> 
                                            </a>
                                        </td>  
                                        <td style="text-align: center;"><?php echo $row->due_date;?></td>
                                    </tr>
                                <?php 
                                            }// if check grp
                                        }// check active
                                    } // foreach get lesson                         
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

<script>
$(document).ready(function () {

    $('#data_table').DataTable({
    })


});
</script>