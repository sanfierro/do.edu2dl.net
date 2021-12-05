 $(document).ready(function() {

        	// Once we click the spoiler button
        	$(".spoiler_wrap input[type='button']").click(function() {
        		var btn_txt = ($(this).val() == 'Показати') ? 'Приховати' : 'Показати';
                var btn_clr = ($(this).css("background-color") == 'rgb(94, 111, 135)') ? 'rgb(189, 64, 60)' : 'rgb(94, 111, 135)';
                
        		// Actually change the button's value
        		$(this).val(btn_txt);
        		$(this).css("background-color", btn_clr);
        		
        		// Go to HTML element directly after this button and slideToggle it
        		$(this).next().stop().toggle();
            	});
            
            });