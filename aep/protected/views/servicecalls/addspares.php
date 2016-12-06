<table>
    <tr>
        <td>
            <?php echo $form->labelEx( $workcarriedoutmodel, 'spare_part_number_or_name' ); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php //echo $form->textField( $workcarriedoutmodel, 'spare_part_number_or_name' ); ?>
            <input type="text" id="Workcarriedout_spare_part_number_or_name">
            <?php echo $form->error( $workcarriedoutmodel, 'spare_part_number_or_name' ); ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->labelEx( $workcarriedoutmodel, 'spare_qty' ); ?>
            <?php //echo $form->textField( $workcarriedoutmodel, 'spare_qty') ?>
            <input type="text" id="Workcarriedout_spare_qty">
            <?php echo $form->error( $workcarriedoutmodel, 'spare_qty' ); ?>
        </td>
    </tr>
</table>


<div class="row submit">
    <?php echo CHtml::button( 'Save', array(
        'name' => 'savespares',
        'onclick' => "savespares();"
    ) ); ?>
</div>

<script type="text/javascript">

    $('#Workcarriedout_spare_qty').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            console.log('ENTER PORESSWd');
            savespares();
        }
    });



    function savespares() {
        //console.log('Save spares info ');
        var spare_name_or_part_number = document.getElementById('Workcarriedout_spare_part_number_or_name').value;
        var qty = document.getElementById('Workcarriedout_spare_qty').value;


        if (checkifnotblank(spare_name_or_part_number)) {
            if (isNumeric(qty)) {
                addsparestojson(spare_name_or_part_number, qty);

            } else {
                alert('Invalid Quantity ' + qty);
            }
        }
        else {
            alert('Invalid part number or name');
        }

    }

    function isNumeric(num) {
        if (checkifnotblank(num))
            return !isNaN(num)
    }

    function checkifnotblank(text) {
        text = text.trim()
        if (text == '' || text == null) {
            return false;
        } else {
            return true;
        }
    }//    function checkifnotblank()

    function addsparestojson(my_part_number_or_name, my_qty) {


        var spareinfo =
        {
            "part_number_or_name": my_part_number_or_name,
            "qty": my_qty,
        }


        ///Push the new spare into Json
        table_all_spares_json.spares.push(spareinfo);
        //assign it back in form of string
        document.getElementById('Workcarriedout_spares_array').value=JSON.stringify(table_all_spares_json);

        updatelayout();

        $("#addspares").dialog("close");


        ////Call AJAX and save this info in db

    }////end of addsparestojson

</script>

