<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/17
 * Time: 10:55 AM
 */

// Call the REDCap Connect file in the main "redcap" directory

// echo '<pre>' . print_r($_SESSION["DataQualityLogicErrors"], TRUE) . '</pre>';

namespace Stanford\GoProd;

?>


<!--TODO: is possible to create a partial file with the DIV and table to avoid repetition.-->
<div class="panel panel-default" width="50%">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr">  <?php echo lang('DATA_QUALITY_LOGIC_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div >
        <table id="data_quality_logic_data_table" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?> </button>
    </div>
</div>

<script>
    var result = sessionStorage.getItem("DataQualityLogicErrors");
    dataSet =jQuery.parseJSON(result);



    $(document).ready(function() {

        $('#data_quality_logic_data_table').DataTable({

            "paging":         false,
            "searching": false,

            data: dataSet,
            columns: [
                { title: "Quality Rule Name" },
                { title: "Real Time Executed?" },
                { title: "Missing Variable" },
                { title: "Edit" }
            ],

            "columnDefs": [


                {"className": "dt-center", "targets": 2},
                {"className": "dt-center", "targets": 3},
                { "width": "25px", "targets": 2},
                { "width": "25px", "targets": 3}
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 15
        } );
    } );

</script>

