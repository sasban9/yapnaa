							  
<?php
require_once('controller/admin_controller.php');
if(isset($_POST['id'])){
	$id		=	$_POST['id'];
	$control	=	new admin();
	
	
	
	// Get get_brand List
	$user_srm_question_list = $control->user_srm_question_list($id);
	// echo  '<pre>';
	// print_r($user_srm_question_list);
	$j=1;
	for($i=0;$i<count($user_srm_question_list);$i++){
?>
	<div class="form-group has-warning">
		<label class="col-sm-2 control-label">Question <?php echo $i+1;?>:</label>
			<input type="hidden" class="form-control" name="que[]"  value="<?php echo $user_srm_question_list[$i]['srm_question_id'];?>" required>	
			<div class="col-sm-10"><?php echo $user_srm_question_list[$i]['srm_questions'];?>
		</div>
	</div>
	<?php if($user_srm_question_list[$i]['srm_question_type']=='Multi'){ ?> 
			 <div class="form-group">
				<label class="col-sm-2 control-label"> </label>

				<div class="col-sm-10">
					<div class="checkbox"><label> <input type="checkbox"  class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>" name="ques<?php echo $j;?>[]" value="1"> <?php echo $user_srm_question_list[$i]['srm_question_opt1'];?></label></div>
					
					<div class="checkbox"><label> <input type="checkbox" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  name="ques<?php echo $j;?>[]" value="2"> <?php echo $user_srm_question_list[$i]['srm_question_opt2'];?></label></div>
					
					
					<div class="checkbox"><label> <input type="checkbox" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  name="ques<?php echo $j;?>[]" value="3"> <?php echo $user_srm_question_list[$i]['srm_question_opt3'];?></label></div>
					
					
					<div class="checkbox"><label> <input type="checkbox" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  name="ques<?php echo $j;?>[]" value="4"> <?php echo $user_srm_question_list[$i]['srm_question_opt4'];?></label></div>
				</div>
			</div> 
		<hr/>
	
	
	 <?php } else { ?>
		 
		 <div class="form-group"><label class="col-sm-2 control-label"> </label>

			<div class="col-sm-10">
				  
				<div class="radio"><label> <input type="radio" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  value="1" id="optionsRadios2" name="ques<?php echo $j;?>">  <?php echo $user_srm_question_list[$i]['srm_question_opt1'];?> </label></div>
				
				<div class="radio"><label> <input type="radio" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  value="2" id="optionsRadios2" name="ques<?php echo $j;?>" >  <?php echo $user_srm_question_list[$i]['srm_question_opt2'];?> </label></div>
				
				
				<div class="radio"><label> <input type="radio" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  value="3" id="optionsRadios2" name="ques<?php echo $j;?>"> <?php echo $user_srm_question_list[$i]['srm_question_opt3'];?> </label></div>
				
				<div class="radio"><label> <input type="radio" class="ques<?php echo $j;?>" qu_id="<?php echo $j;?>"  value="4" id="optionsRadios2" name="ques<?php echo $j;?>"> <?php echo $user_srm_question_list[$i]['srm_question_opt4'];?> </label></div>
			</div>
		</div>
	<hr/>
<?php 
}
$j++;
}
?>
<input id="submit_g"   type="button" name="submit" class="btn btn-info pull-right"  value="Generate SRM">
<?php }

?>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>

            $(document).ready(function () {  
			var p_id 		=	<?php echo $_POST['id'];?>;
			var user_id 	=	<?php echo $_POST['user_id'];?>;
			// alert(up_id);
			var ans = [];
              $('input[type=radio]').change(function() {
			  //alert('working');
                var q_id = $(this).attr('qu_id');
                if($("input[type='radio'].ques"+q_id).is(':checked')) {
                    var card_type = $("input[type='radio'].ques"+q_id+":checked").val();
                    ans[q_id]=card_type;
					 // console.log(ans);
                }
            });
              
            $("input[type=checkbox]").change( function() {
                var q_id = $(this).attr('qu_id');
                var val = [];
                $('.ques'+q_id+':checkbox:checked').each(function(i){
                  val[i] = $(this).val();
                });
                ans[q_id]=val.join("");
            });

                $('#submit_g').click(function(){
				//alert('dsfsd');
                    console.log(ans);
					//alert(ans);
                    $.ajax({
                            type: "POST",
                            url: "ans-list.php",
                            data: ({ans: ans,p_id :p_id ,user_id:user_id}), // <--- THIS IS THE CHANGE
                            dataType: "html",
                            success: function (data) {
                                // alert(data); 
								if(data==1){
									alert("SRM created succefully");
								}else{
									alert("Please try again");
								}
                            },
                            error: function () {
                                alert("Failed");
                            }
                        });

                });

});
</script>	