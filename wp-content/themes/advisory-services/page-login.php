<?php /* Template Name: Login */ ?>
<?php
if (is_user_logged_in()) { wp_redirect(home_url('dashboard')); }?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:300,400,500,700,900" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
    <?php wp_head(); ?>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<section class="col-sm-6 logoWrapper">
				<img src="<?php echo get_template_directory_uri(); ?>/images/encaselogo.png" alt="logo">
			</section>
			<section class="col-sm-6 loginFormWrapper ">
				<div class="login-box">
					<form class="login-form">
						<h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
						<div class="form-group">
							<label class="control-label">EMAIL</label>
							<input class="form-control" type="email" id="email" placeholder="Email" autofocus>
						</div>
						<div class="form-group">
							<label class="control-label">PASSWORD</label>
							<input class="form-control" type="password" id="password" placeholder="Password">
						</div>
						<div class="form-group">
							<div class="utility">
						  		<div class="animated-checkbox">
						    		<label class="semibold-text">
						      		<input type="checkbox" id="remember"><span class="label-text">Stay Signed in</span>
						    		</label>
						  		</div>
							</div>
						</div>
						<div class="form-group btn-container">
							<input type="submit" class="btn btn-primary btn-block" value="SIGN IN">
							<p style="margin-top: 15px"><strong>By accessing this portal, you are agreeing to these <a href="#" data-toggle="modal" data-target="#myModal">Terms of Use</a>.</strong></p>
							<div class="clearfix"></div>
						</div>
					</form>
					<div class="login-footer"> <img src="<?php echo get_template_directory_uri(); ?>/images/login-logo.png" alt="logo"> </div>
				</div>
			</section>
		</div>
	</div>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content modal-inverse">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Terms of Use</h4>
				</div>
				<div class="modal-body"><iframe width="100%" height="600" src="<?php echo IMAGE_DIR_URL ?>pdf/Portal_Privacy_Policy_2020.pdf"></iframe></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
    
	<?php wp_footer(); ?>
</body>
</html>