	<div class="container-fluid footer">
		<div class="footer_content">
			<div class="row">
				<div class="col-xs-12 col-sm-6"><a href="#">Help</a><a href="#">Support</a></div>
				<div class="col-xs-12 col-sm-6 copy_right"> &copy; 2017 School of Banking Excellence </div>
			</div>				
		</div>
	</div>
	</div>
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="../js/bootstrap.min.js"></script>
	
	<!-- Boday page to responsive set with menu.-->
	<script type="text/javascript">
		function htmlbodyHeightUpdate(){
			var height3 = $( window ).height()
			var height1 = $('.nav').height()+50
			height2 = $('.main').height()
			if(height2 > height3){
				$('html').height(Math.max(height1,height3,height2)+10);
				$('body').height(Math.max(height1,height3,height2)+10);
			}else{
				$('html').height(Math.max(height1,height3,height2));
				$('body').height(Math.max(height1,height3,height2));
			}
		}
		$(document).ready(function () {
			htmlbodyHeightUpdate()
			$( window ).resize(function() {
				htmlbodyHeightUpdate()
			});
			$( window ).scroll(function() {
				height2 = $('.main').height()
				htmlbodyHeightUpdate()
			});
		});
	</script>
	<!-- For Add Active Class Script.-->
	<script>		
		$(document).ready(function() {
			// get current URL path and assign 'active' class
			var pathname = window.location.pathname;
			$('li').removeClass("active");
			$('.nav > li > a[href="'+pathname+'"]').parent().addClass('active');
		});
	</script>	
	<script type="text/javascript">
		$(document).on('click', '.browse', function(){
			var file = $(this).parent().parent().parent().find('.file');
			file.trigger('click');
		});
		$(document).on('change', '.file', function(){
			$(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
		});
	</script>
</body>
</html>