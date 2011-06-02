$(document).ready(function(){
echo(window.location.hash);
	bind('hashchange',function(){
	    var repertoire = window.location.hash.substring(1);
	    
	    $.ajax({
	    	  url: 'listing.php?dir='+repertoire,
	    	  success: function(data) {
	    	    $('.result').html(data);
	    	    alert('Load was performed.');
	    	  }
	    });
	});

	$(window).trigger('hashchange');
});