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
	
});
</script>
</body>
</html>
