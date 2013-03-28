<script type="text/javascript">
$(document).ready(function() {
	
	$('.file-link').on('click',function(e) {
		
		$('#downloadFrame').attr('src',$(this).attr('href'));
		
		e.preventDefault();
		
	});
	$('.edit-col').on('click','a',function(e) {
		
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
	
});
</script>
</body>
</html>
