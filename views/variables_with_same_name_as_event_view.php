<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/27/17
 * Time: 10:06 PM
 */

namespace Stanford\GoProd;
?>




<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> <?php echo lang('VAR_NAMES_EVENT_NAMES_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div style="padding: 1px">
        <table id="variables_with_same_name_as_event_view" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>

    var result = sessionStorage.getItem("VariableNamesWithTheSameNameThanAnEventName");
    dataSet =jQuery.parseJSON(result);



    //console.log(dataSet);
    $(document).ready(function() {
        $('#variables_with_same_name_as_event_view').DataTable( {
            data: dataSet,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,

            columns: [

                { "data": "name" }



            ]

        } );
    } );




</script>

