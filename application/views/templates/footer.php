<script type="text/javascript">
$(document).ready(function() {
	
	$('.file-link').on('click',function(e) {
	
		e.preventDefault();
		
		$('#downloadFrame').attr('src',$(this).attr('href'));
		
	});
	
});
</script>
</body>
</html>
