@section('style')

	<!-- Footer CSS -->
	<style>
		.footer {
			border-radius: 0px;
			padding: 20px 0px 10px 0px;
			border-bottom: 0px;
		}
		.footer .no-container {
			padding: 0px 15px 0px 15px;
		}
		.footer .navbar-nav {
			margin: 0px;
		}
		.footer .content1 .navbar-nav li {
			clear: both;
		}
		.footer .content1 .navbar-nav li a {
			padding: 5px;
			margin-left: -5px;
			border: 0px;
		}
		.footer .content1 .navbar-brand {
			line-height: 100%;
			height: 0px;
			margin-bottom: 10px;
		}
		.footer .content2 .navbar-nav li a {
			padding: 0px 15px 0px 0px;
			margin: 0px 10px 0px -5px;
			border: 0px;
		}
		.footer .content2 {
			padding: 0px 15px 0px 5px;
		}
		.footer .copyright {
			padding: 0px;
			font-size: smaller;
		}
		#btn-scroll-up {
			display: none;
			position: fixed;
			bottom: 5px;
			right: 5px;
		}
	</style>

@stop



@section('footer')

	<!-- Layout Footer -->
	<footer class="navbar navbar-default footer">
		<!--<div class="{{ $container }}">
			<div class="row content1">
				<div class="col-lg-12X">
					<div class="col-md-3 col-sm-4">
						<ul class="nav navbar-nav">
							<li class="navbar-brand">GitHub</li>
							<li><a href="#">About us</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">Contact & support</a></li>
							<li><a href="#">Enterprise</a></li>
							<li><a href="#">Site status</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-4">
						<ul class="nav navbar-nav">
							<li class="navbar-brand">Applications</li>
							<li><a href="#">Product for Mac</a></li>
							<li><a href="#">Product for Windows</a></li>
							<li><a href="#">Product for Eclipse</a></li>
							<li><a href="#">Product mobile apps</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-4">
						<ul class="nav navbar-nav">
							<li class="navbar-brand">Services</li>
							<li><a href="#">Web analytics</a></li>
							<li><a href="#">Presentations</a></li>
							<li><a href="#">Code snippets</a></li>
							<li><a href="#">Job board</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-12">
						<ul class="nav navbar-nav">
							<li class="navbar-brand">Documentation</li>
							<li><a href="#">Product Help</a></li>
							<li><a href="#">Developer API</a></li>
							<li><a href="#">Product Markdown</a></li>
							<li><a href="#">Product Pages</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<hr>-->

		<div class="{{ $container }}">
			<div class="row content2">
				<div class="col-md-8">
					<!--<ul class="nav navbar-nav">
						<li><a href="#">Terms of Service</a></li>
						<li><a href="#">Privacy</a></li>
						<li><a href="#">Security</a></li>
					</ul>-->
				</div>
				<div class="col-md-4 copyright">
					<p class="muted pull-right">Copyright {{{ date(Y) }}} {{{ Config::get('mrcore.company') }}}</p>
				</div>
			</div>
		</div>
	</footer>

	<a href="#" id="btn-scroll-up" class="btn btn-sm btn-primary">
		<i class="fa fa-angle-double-up"></i>
	</a>


@stop