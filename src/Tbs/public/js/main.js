var Main = 
{
	init: function()
	{
		$('#it-works').click(function() {
			alert('It Works!');
		});
	}
}

$(document).ready(function() {
	Main.init();
});
