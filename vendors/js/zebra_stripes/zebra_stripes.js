
$(document).ready(function()
{
	stripeTable();
});

function stripeTable(table_name, class_name)
{
	var target;

	if(table_name && class_name)
	{
		target = table_name + " tr:even"; 
		$(target).addClass(class_name);
	}
	else
	{
		target = "table tr:even"; 
		$(target).addClass("even-row");
	}
}