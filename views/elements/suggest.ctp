<?php
echo $html->script("/jqcake/js/jquery-autocomplete/lib/jquery.bgiframe.min");
//echo $html->script("/jqcake/js/jquery-autocomplete/lib/jquery.ajaxQueue.js");
//echo $html->script("/jqcake/js/jquery-autocomplete/lib/thickbox-compressed.js");
echo $html->script("/jqcake/js/jquery-autocomplete/jquery.autocomplete");

echo $html->css("/jqcake/css/jquery-autocomplete/main", null, array('inline'=>false));
echo $html->css("/jqcake/css/jquery-autocomplete/jquery.autocomplete", null, array('inline'=>false));
//echo $html->css("/jqcake/css/jquery-autocomplete/thickbox", null, array(), false);
//if(empty($suggestField)){
//	$suggestField = '.suggestEm';
//}
//$contains = "true";
//$jsonVar = "Product";

?>
<script type="text/javascript">
$().ready(function() {
    function findValueCallback(event, data, formatted) {
        $("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
    }
    
    function formatItem(row) {
        return row[0] + " (<strong>id: " + row[1] + "</strong>)";
    }
    function formatResult(row) {
        return row[0].replace(/(<.+?>)/gi, '');
    }
    
    
    <?php foreach($suggests as $elem=>$suggest): ?>
    $("<?= $elem ?>").autocomplete(<?= $suggest ?>, {
        minChars: 0,
        width: 310,
        matchContains: true,
        autoFill: false,
        formatItem: function(row, i, max) {
            return i + "/" + max + ": \"" + row.name + "\" [" + row.to + "]";
        },
        formatMatch: function(row, i, max) {
            return row.name + " " + row.to;
        },
        formatResult: function(row) {
            return row.to;
        }
    });
    <?php endforeach; ?>
    
});
</script>