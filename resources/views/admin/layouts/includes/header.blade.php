<div id="kt_header" class="header header-fixed">
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			
		</div>
		<div class="topbar">
			<div class="dropdown">
				<div class="dropdown">
					<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
						<div class="btn btn-icon btn-clean btn-dropdown w-auto align-items-center btn-lg mr-1 px-2">
							<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi {{Auth::user()->name}},</span>
							<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"></span>
							<span class="symbol symbol-35 symbol-light-success">
								<span class="symbol-label font-size-h5 font-weight-bold">
									{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', Auth::user()->name))) }}
								</span>
							</span>
						</div>
					</div>

					<div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-md dropdown-menu-right">
						<ul class="navi navi-hover py-4">
							<li class="navi-item">
								<a class="navi-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									<span class="symbol symbol-20 mr-3">
										<i class="fas fa-stroopwafel"></i>
									</span>
									<span class="navi-text">Logout</span>
								</a>
								<form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
