(function($){ 
    "use strict"; 
    var format = function (str, col) {
	    col = typeof col === 'object' ? col : Array.prototype.slice.call(arguments, 1);

	    return str.replace(/\{\{|\}\}|\{(\w+)\}/g, function (m, n) {
	        if (m == "{{") { return "{"; }
	        if (m == "}}") { return "}"; }
	        return col[n];
	    });
	};
	function message(data) {
		data = (JSON.parse(data));
		logged_fields =lang.logged_fields
		message = "";
		$.each(data, function(k, v) {
			key = v[0];
			if (Array.isArray(v)){
		    	message += format(lang.log_message, {'key':logged_fields[key], 'old':v[1], 'new':v[2]})+"<br>";
			}else{
				message += v+"<br>";
			}
		});
		return message;
	}
    $(document).ready(function () {
        let id = $('#repair_id').val();
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": site.settings.rows_per_page,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': site.base_url + 'panel/reparation/getLogTable/' + id,
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": get_csrf_token_name,
                    "name": get_csrf_hash
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "aoColumns": [
            null,
            null,
            {"mRender": message},
            ],
           
        });
    });
})(jQuery); 