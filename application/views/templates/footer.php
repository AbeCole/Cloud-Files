		<div id="statistics">
			<p>
				Execution time: {elapsed_time} Seconds - Memory Usage: {memory_usage}
			</p>
		</div>
	</div><!-- #page-container -->
<script type="text/javascript">
$(document).ready(function() {
	
	$('.file-link').on('click',function(e) {
		
		$('#downloadFrame').attr('src',$(this).attr('href'));
		
		e.preventDefault();
		
	});
	$('.edit-col').on('click','img',function(e) {
		
		$(this).closest('tr').next('.edit-row').toggle();
		
		e.preventDefault();
		
	});
	if ($('#link-select').length >= 1) {
		 
		$('#link-select').after('<button id="copy-button" data-clipboard-target="link-select" title="Click to copy link">Copy to Clipboard</button>');
		
		var clip = new ZeroClipboard( document.getElementById('copy-button'), {
		  moviePath: "<?php echo base_url('assets/js/ZeroClipboard.swf'); ?>"
		} );
		
		clip.on( 'complete', function(client, args) {
		  alert("Copied link to clipboard");
		});
		clip.on( 'noflash', function(client, args) {
			$('#copy-button').hide();
			$('#link-select').focus().select()
			 .after('<small id="copy-text">The link should be highlight, you can now press Control + C to copy the link to your clipboard</small>');
		});
		
	}
	if ($('#message-box').length >= 1) {
		
		var link = $('<span id="message-icon"><img src="<?php echo base_url('assets/images/error.png'); ?>" alt="Error" /></span>'); 
		
		$('#message-box').append(link);
		
		link.on('click',function() {
			if ($('#message-box').hasClass('shown')) {
				$('#message-box').animate({'top':-$('#message-box').outerHeight()},300, function() {
					$(this).removeClass('shown');
				});
			} else {
				$('#message-box').animate({'top':'0px'},300, function() {
					$(this).addClass('shown');
				});
			}
		});
		
		setTimeout(function() {
			$('#message-box').animate({'top':-$('#message-box').outerHeight()},300);
		}, 1000 * 3);
		
	}
	
});
</script>
</body>
</html>
