
$(document).ready(function()
{
	stripeTable();
	stripeDl();
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

function stripeDl(table_name, class_name)
{
    var target;

    if(table_name && class_name)
    {
        target = table_name + " dt:even"; 
        $(target).addClass(class_name);
    }
    else
    {
        target = "dt:even"; 
        $(target).addClass("even-row");
    }
}