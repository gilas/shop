$(function() {
	$('*[rel=tooltip]').each(function() {
		$(this).tooltip({
			placement: $(this).attr('tooltip-place')
		})
	})
    $('html').keypress(function(event){
        if(event.keyCode == 27){
            $('#cancelButton').trigger('click');
        }
    })
})

function alert(message) {
	$.fallr({
		content: message,
        buttons: {
			button1: {
				text: "قبول",
				danger: false,
				onclick: function() {
					$.fallr("hide")
				}
			}
		}
	})
}
$(function(){
    // Show pop uo window for popup links
    $('.popup-link').click(function(){
        url = $(this).attr('href');
        window.open(url,'popup','width=800,height=600,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=50,top=0');
        return false;
    })
})

function closeModal(){
    $.fancybox.close();
}