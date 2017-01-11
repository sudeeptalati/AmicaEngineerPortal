<?php if ($system_message != "" || $system_message != "null"): ?>
    <?php echo $system_message; ?>
<?php endif; ?>


<div style="float:right;">
	<a target="_blank" href="" title='Help'>
		<span  class="fa fa-question-circle fa-3x" ></span>
	</a>
</div>
<div style="text-align: center">
	<h1> Service Call # <?php echo $model->service_reference_number; ?></h1>
	<div><h2><?php echo $model->jobstatus->html; ?></h2></div>
</div>


<?php
echo CHtml::scriptFile("https://maps.googleapis.com/maps/api/js");//This has to import here else it shows that it is called multiple times
//echo CHtml::scriptFile("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");



$this->layout = 'column1';

//echo $model->data_recieved;
$j_data_recieved = json_decode( $model->data_recieved );
$j_data_sent = json_decode( $model->data_sent, true );
$j_chat_data = json_decode( $model->communications );


//var_dump($workcarriedoutmodel->attributes);
$workcarriedoutmodel->attributes = $j_data_sent;
$workcarriedoutmodel->chat_message = '';

//echo '<h4>IMAGE URL: '.$workcarriedoutmodel->product_plating_image_url.'</h4>';



if ($workcarriedoutmodel->product_plating_image_url == '' || $workcarriedoutmodel->product_plating_image_url == NULL) {
    $workcarriedoutmodel->product_plating_image_url='images/blank.png';
}




if ($workcarriedoutmodel->spares_array == '' || $workcarriedoutmodel->spares_array == NULL) {
    ///initialise the spares array
    $workcarriedoutmodel->spares_array = '{"spares":[]}';
}else
{
    $workcarriedoutmodel->spares_array = json_encode($workcarriedoutmodel->spares_array);
}


?>
<?php
//echo CHtml::link('Chat','#',array('class'=>'chat-button'));


$imghtml = CHtml::image( Yii::app()->baseUrl . '/images/chaticon.png', '', array("style" => "width:50px; height: 50px") );


Yii::app()->clientScript->registerScript( 'chat_time', "
        $('.person').click(function(){
        $('.chat_time').toggle();
        return false;
       });
    " );


Yii::app()->clientScript->registerScript( 'chat', "
$('.chat-button').click(function(){
	$('.chat-form').toggle();
    document.getElementById('chat_text').scrollTop=document.getElementById('chat_text').scrollHeight;
    return false;
});
" );

?>





<table>
    <tr>
    <tr>
        <td colspan="2"
            style="text-align: right;"><?php echo CHtml::link( $imghtml, '#', array('class' => 'chat-button') ); ?></td>
    </tr>
    <tr>
        <td style="width: 50%;"><h3>Customer</h3></td>
        <td style="width: 50%;"><h3>Product</h3></td>
    </tr>
    <tr>
        <td>
            <div class="data_box">
                <table>
                    <tr>
                        <td>
                            <h4><?php echo $model->customer_fullname; ?></h4>
                            <h4><?php echo $model->customer_address; ?></h4>
                            <h4><?php echo $model->customer_postcode; ?></h4>


                            <table>
                            	<tr>
                            		<td><i class="fa fa-phone fa-lg"></i></td>
                            		<td>
                            			<b>
			                            <?php if (isset($j_data_recieved->customer_telephone))
            		                		echo $j_data_recieved->customer_telephone;
                    			        ?>
                    			        </b>
                            		</td>
                            	</tr>
                            	<tr>
                            		<td><i class="fa fa-mobile fa-lg"></i></td>
                            		<td>
			                        	    <b>
			                        	    <?php if (isset($j_data_recieved->customer_mobile	))
            		            	    		echo $j_data_recieved->customer_mobile;
                    			        	?>
                    			        	</b>
                            		</td>
                            	</tr>
                            </table>


                        </td>
                        <td style="text-align: right;">
                            <a target="_blank" href="https://www.google.co.uk/maps?q=<?php echo $model->customer_address . ' ' . $model->customer_postcode; ?>">View Larger Map</a>
                            <br>
                            <div class="googlemapdiv" style="display:block; float: right;">
                                <?php $this->renderPartial('postcodeongooglemap', array('address' => $model->customer_address . ' ' . $model->customer_postcode)); ?>
                            </div><!-- googlemapdiv -->
                        </td>
                    </tr>
                </table>


            </div><!-- databox-->
        </td>
        <td>
            <div class="data_box">
                <h4><?php echo $j_data_recieved->product_brand_name; ?> - <?php echo $j_data_recieved->product_product_type_name; ?></h4>
                <h4><?php echo $j_data_recieved->product_model_number; ?></h4>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
            <h3>Fault Reported</h3>
            <div class="data_box"><?php echo $j_data_recieved->fault_description; ?></div>
        </td>
    </tr>

</table>


<div class="form">
    <?php $form = $this->beginWidget( 'CActiveForm', array(
        'id' => 'workcarriedout-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ) );

    ?>


    <?php echo CHtml::errorSummary( $workcarriedoutmodel ); ?>


    <div class="data_box">
        <table>
            <tr><th style="width:50%;"></th><th style="width:50%;"></th></tr>
            <tr>
                <td>

                    <div class="row compactRadioGroup">
                        <?php echo $form->labelEx( $workcarriedoutmodel, 'product_serial_number_available' ); ?>
                        <?php
                        echo $form->radioButtonList( $workcarriedoutmodel, 'product_serial_number_available',
                            array(1 => 'Yes', 0 => 'No'),
                            array('separator' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'tabindex'=>'1', 'style' => 'display: inline;') ); // choose your own separator
                        ?>
                        <?php echo $form->error( $workcarriedoutmodel, 'product_serial_number_available' ); ?>
                        <hr>

                        <h4>
                            <?php
                            if ($workcarriedoutmodel->product_serial_number_available == 1)
                                echo $workcarriedoutmodel->product_serial_number;
                            else
                                echo $workcarriedoutmodel->product_serial_number_unavailable_reason;
                            ?>
                        </h4>


                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            ///////When YES is clicked for Product Serial Number///////
                            $('#Workcarriedout_product_serial_number_available_0').click(function () {
                                $('#reason_product_serial_no').hide('fast');
                                $('#product_serial_no').show('fast');
                                $('#Workcarriedout_product_serial_number').val('');
                                $('#Workcarriedout_product_serial_number_unavailable_reason').val('Serial Number is Provided:');
                            });

                            ///////When NO is clicked for Product Serial Number///////
                            $('#Workcarriedout_product_serial_number_available_1').click(function () {
                                $('#product_serial_no').hide('fast');
                                $('#reason_product_serial_no').show('fast');
                                $('#Workcarriedout_product_serial_number_unavailable_reason').val('');
                                $('#Workcarriedout_product_serial_number').val('00000000000000');
                            });
                        });
                    </script>


                    <div class="row" style="display: none; " id="product_serial_no">

                        <?php echo $form->labelEx( $workcarriedoutmodel, 'product_serial_number' ); ?>
                        <?php echo $form->textField( $workcarriedoutmodel, 'product_serial_number', array('tabindex'=>'3', 'style' => 'width:250px;') ); ?>
                        <?php echo $form->error( $workcarriedoutmodel, 'product_serial_number' ); ?>
                    </div>

                    <div class="row" style="display: none; " id="reason_product_serial_no">
                        <?php echo $form->labelEx( $workcarriedoutmodel, 'product_serial_number_unavailable_reason' ); ?>
                        <?php echo $form->textArea( $workcarriedoutmodel, 'product_serial_number_unavailable_reason', array('tabindex'=>'4', 'style' => 'width:100%;height:100px;') ); ?>
                        <?php echo $form->error( $workcarriedoutmodel, 'product_serial_number_unavailable_reason' ); ?>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <script type="text/javascript">

                            $(document).ready(function () {
                                $('.image-popup-vertical-fit').magnificPopup({
                                    type: 'image',
                                    closeOnContentClick: true,
                                    mainClass: 'mfp-img-mobile',
                                    image: {
                                        verticalFit: true
                                    }
                                });
                            });

                            function showimagepreview(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        $('#img_preview')
                                            .attr('src', e.target.result)
                                        //    .width('25%')
                                        //    .height('25%')
                                        ;
                                        $("#img_preview_a_tag").attr("href", e.target.result);
                                    };
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>

                        <div class="row">
                            <?php echo $form->labelEx( $workcarriedoutmodel, 'product_plating_image' ); ?>
                            <?php echo $form->fileField( $workcarriedoutmodel, 'product_plating_image', array( 'tabindex'=>'5', 'onchange' => 'showimagepreview(this);') ); ?>
                            <?php echo $form->error( $workcarriedoutmodel, 'product_plating_image' ); ?>
                        </div>

                        <!--<img id="img_preview" src="images/blank.png" alt="your image"/>
                        -->

                        <a class="image-popup-vertical-fit" id="img_preview_a_tag"  href="<?php echo $workcarriedoutmodel->product_plating_image_url.'?'.time(); ?>" title="Product Image">
                            <img style='width:25%;' id="img_preview" src="<?php echo $workcarriedoutmodel->product_plating_image_url.'?'.time(); ?>" >
                        </a>

                        <div class="row">
                            <?php //echo $form->labelEx( $workcarriedoutmodel, 'product_plating_image_url' ); ?>
                            <?php echo $form->hiddenField( $workcarriedoutmodel, 'product_plating_image_url', array('onchange' => 'showimagepreview(this);') ); ?>
                            <?php echo $form->error( $workcarriedoutmodel, 'product_plating_image_url' ); ?>
                        </div>
                    </div>

                </td>

            </tr></table>

    </div>




    <script src="js/magnificpopup/jquery.magnific-popup.min.js"></script>


    <link href="js/magnificpopup/magnific-popup.css" rel="stylesheet" type="text/css">














    <div class="row">
        <?php echo $form->labelEx( $workcarriedoutmodel, 'work_done' ); ?>
        <?php echo $form->textArea( $workcarriedoutmodel, 'work_done', array('tabindex'=>'6', 'style' => 'width:90%;height:100px;') ); ?>
        <?php echo $form->error( $workcarriedoutmodel, 'work_done' ); ?>
    </div>


    <table>
        <tr>
            <td>
                <?php echo $form->labelEx( $workcarriedoutmodel, 'first_visit_date' ); ?>
                <?php
                $form->widget( 'zii.widgets.jui.CJuiDatePicker', array(
                    'name' => CHtml::activeName( $workcarriedoutmodel, 'first_visit_date' ),
                    'model' => $workcarriedoutmodel,
                    'value' => $workcarriedoutmodel->attributes['first_visit_date'],
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fadeIn',
                        'dateFormat' => 'dd-M-yy',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                        'readonly' => 'true',

                        'tabindex'=>'8'

                    ),
                ) );
                ?>
                <?php echo $form->error( $workcarriedoutmodel, 'first_visit_date' ); ?>
            </td>
            <td>

                <?php echo $form->labelEx( $workcarriedoutmodel, 'job_completion_date' ); ?>
                <?php
                $form->widget( 'zii.widgets.jui.CJuiDatePicker', array(
                    'name' => CHtml::activeName( $workcarriedoutmodel, 'job_completion_date' ),
                    'model' => $workcarriedoutmodel,
                    'value' => $workcarriedoutmodel->job_completion_date,
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fadeIn',
                        'dateFormat' => 'dd-M-yy',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',
                         'readonly' => 'true',
                        'tabindex'=>'9'
                    ),
                ) );
                ?>
                <?php echo $form->error( $workcarriedoutmodel, 'job_completion_date' ); ?>


            </td>
               <td>


                <div class="data_box">
                    <label>Payment Date</label>
                    <h6><?php echo Servicecalls::model()->findpaymentdate($model->communications); ?></h6>
                </div>


            </td>

        </tr>
    </table>


    <div class="row compactRadioGroup">



        <script type="text/javascript">
            var tableallspares = '<?php echo $workcarriedoutmodel->spares_array; ?>';
            var table_all_spares_json = JSON.parse(tableallspares);

            //    document.addEventListener('keyup', openaddsparesdialog(), false);
            $(document).keypress(function(e) {

                //console.log('KEY PRESSED');
                //console.log('KEY PRESSED'+e.which );

                if (e.which==1 )
                {
                    //console.log("ctral=A pressed");
                    openaddsparesdialog();
                }

            });


        </script>


        <?php echo $form->labelEx( $workcarriedoutmodel, 'spares_used' ); ?>
        <?php
        echo $form->radioButtonList( $workcarriedoutmodel, 'spares_used',
            array(1 => 'Yes', 0 => 'No'),
            array('separator' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'style' => 'display: inline;') ); // choose your own separator
        ?>
        <?php echo $form->error( $workcarriedoutmodel, 'spares_used' ); ?>
        <br><br>



        <script type="text/javascript">
            $(document).ready(function () {
                ///////When YES is clicked for Spares Used///////
                $('#Workcarriedout_spares_used_0').click(function () {

                    $("#addspares").dialog("open");

                });
            });
        </script>


        <?php
        $this->beginWidget( 'zii.widgets.jui.CJuiDialog', array(
            'id' => 'addspares',
            // additional javascript options for the dialog plugin
            'options' => array(
                'title' => 'Add Spares',
                'autoOpen' => false,
                'show' => "slide",
                'modal' => 'true',
            ),
        ) );
        ?>

        <?php $this->renderPartial( 'addspares', array('workcarriedoutmodel' => $workcarriedoutmodel, 'form' => $form) ); ?>


        <?php
        $this->endWidget( 'zii.widgets.jui.CJuiDialog' );
        ?>
    </div>


    <div class="row">
        <div id="sparestable_div" class="data_box">
            <?php //echo $form->labelEx( $workcarriedoutmodel, 'spares_array' ); ?>


            <?php echo $form->textField( $workcarriedoutmodel, 'spares_array', array('style' => 'background:#DDD; width:90%;height:100px;') ); ?>
            <?php echo $form->error( $workcarriedoutmodel, 'spares_array' ); ?>


            <table id="sparestable" style="width:50%;">
                <tr>
                    <th>#</th>
                    <th>Part Number/Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </table>
        </div><!-- end of sparestable_div-->

        <script type="text/javascript">

            updatelayout();

            function openaddsparesdialog() {
                document.getElementById('Workcarriedout_spare_part_number_or_name').value='';
                document.getElementById('Workcarriedout_spare_qty').value='';
                $("#addspares").dialog("open");
            }//nend of function openaddsparesdialog()

            function deletespare(pos) {
                table_all_spares_json.spares.splice(pos, 1);//////removes 1 item starting at pos
                updatelayout();

            }


            function updatelayout() {

                if (table_all_spares_json.spares.length == 0)
                    $('#sparestable_div').hide('fast');
                else
                    $('#sparestable_div').show('fast');


                var i = 1;
                $("#sparestable  td").remove();
                $.each(table_all_spares_json.spares, function (key, value) {
                    // Write your code here
                    $('#sparestable tr:last').after("<tr><td>" + i + "</td><td>" + value.part_number_or_name + "</td><td>" + value.qty + "</td><td><a href='#sparestable' onclick='deletespare(" + key + ");'>Delete</a></td></tr>");
                    i++;
                });
                $('#sparestable tr:last').after("<tr><td colspan=3><a href='#sparestable' onclick='openaddsparesdialog();'>Add More</a></td></tr>");


            }///end of updatesparestabele
        </script>

    </div>


    <br><br>
    <p class="note"><?php echo 'Use <span class="required">Ctrl+A</span> from keyboard to add spares.'; ?></p>
    <p class="note"><?php echo 'Fields with <span class="required">*</span> are required.'; ?></p>



	<div class="row submit">
		  	<?php echo CHtml::submitButton( 'Submit The Claim' ); ?>

    </div>



    <div class="chat-form" style="display:block">


        <div id="chat_window">
            <div class="chat-button">
                <table>
                    <tr>
                        <td><h3>Communication for this Job</h3>
                        </td>
                        <td>X</td>
                    </tr>
                </table>
            </div>
            <div id="chat_text">
                <table class="chat_table">
                    <tr>
                        <th style="width:15%"></th>
                        <th style="width:70%"></th>
                        <th style="width:15%"></th>
                    </tr>

                    <?php $fullchatarray = json_decode( $model->communications, true ); ?>
                    <?php foreach ($fullchatarray['chats'] as $c) { ?>
                        <tr>
                            <?php if ($c['person'] === 'me'): ?>
                                <td></td>
                                <td>
                                    <div id='me_talkbubble'> <?php echo $c['message']; ?></div>
                                </td>
                                <td>
                                    <div class="person" style="text-align: right"><b><?php echo $c['person']; ?>
                                            says:</b></div>
                                    <div class="chat_time"
                                         style="display:none;font-size: 10px;"> <?php echo $c['date']; ?>:
                                    </div>
                                </td>
                            <?php else: ?>
                                <td>
                                    <div class="person"><b><?php echo $c['person']; ?> says:</b>
                                        <div><img style="width: 40px;border-radius: 50%;"
                                                  src="<?php echo YiiBase::app()->baseUrl; ?>/images/amicapic.jpg">
                                        </div>
                                    </div>
                                    <div class="chat_time"
                                         style="display:none;font-size: 10px;"><?php echo $c['date']; ?></div>
                                </td>
                                <td>
                                    <div id='amica_talkbubble'><?php echo $c['message']; ?></div>
                                </td>
                                <td></td>

                            <?php endif; ?>
                        </tr>
                    <?php }///end of foreach  ?>


                </table>
            </div><!-- <div class="chat_text">    -->


       		<?php if ($model->jobstatus_id!=34 && $model->jobstatus_id!=35 && $model->jobstatus_id!=102): ///it means if job is approved?>

            <div style="text-align: right;">
                <?php echo $form->labelEx( $workcarriedoutmodel, 'chat_message' ); ?>
                <?php echo $form->textArea( $workcarriedoutmodel, 'chat_message', array('style' => 'width:78%;height:50px;') ); ?>
                <?php echo $form->error( $workcarriedoutmodel, 'chat_message' ); ?>
                <?php echo CHtml::button("Reply to this Chat", array('title' => "Reply to this Chat", 'onclick' => 'js:replytothecchat();')); ?>
                <!--
                <div class="row submit"><?php echo CHtml::submitButton( 'Reply' ); ?></div>
                -->
			</div>
	    	<?php endif; ?>



        </div> <!-- <div id="chat_window"> -->

    </div><!--<div class="chat-form" style="display:none">-->
    <?php $this->endWidget(); ?>
</div><!-- form -->



<script type="text/javascript">//<![CDATA[


    function replytothecchat() {
        console.log('Open Chat Window To disReply to this Chat');


        var chat_msg=document.getElementById("Workcarriedout_chat_message").value;

        chat_msg=chat_msg.replace(/\s+/, "")

        if (chat_msg=='' || chat_msg==null)
        {
            document.getElementById("Workcarriedout_chat_message").style.backgroundColor = "#FEEEEE";
            document.getElementById("Workcarriedout_chat_message_em_").innerHTML='Please input some reason for Rejection';
            document.getElementById("Workcarriedout_chat_message_em_").style.color = "#C00000";
            //alert('Please specify the reason');
        }
        else
        {

            chat_msg;

            service_reference_number='<?php echo $model->service_reference_number; ?>';


            $.ajax({
                url: 'index.php?r=servicecalls/sendmessagetoamica',
                type: 'post',
                data: {'chat_msg': chat_msg, 'service_reference_number':service_reference_number},
                success: function (data, status) {

                    console.log(data);
                    //alert(data);
                    //location.reload();



                },
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    alert("Details: " + desc + "\nError:" + err);
                }
            }); // end ajax call



        }

    }///end of function replytothecchat


var objDiv = document.getElementById("chat_text");
objDiv.scrollTop = objDiv.scrollHeight;



</script>