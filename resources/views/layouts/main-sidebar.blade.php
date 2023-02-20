<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth::User()->name}}</h4>
							<span class="mb-0 text-muted">{{Auth::User()->email}}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category" >برنامج الفواتير</li>

                    <a class="text-black" href="{{ url('home') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z"/></svg><span>القائمة الرئيسية</span></a>

                    @can('الفواتير')
                    <li class="side-item side-item-category">الفواتير</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" ><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3"/><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/></svg><span class="side-menu__label"> الفواتير</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">

                            @can('قائمة الفواتير')
							    <li><a class="slide-item" href="{{ url('invoices') }}">قائمة الفواتير</a></li>
                            @endcan

                            @can('الفواتير المدفوعة')
							    <li><a class="slide-item" href="{{ url('/' . $page='Invoice_Paid') }}">الفواتير المدفوعة</a></li>
                            @endcan

                            @can('الفواتير الغير مدفوعة')
							<li><a class="slide-item" href="{{ url('/' . $page='Invoice_UnPaid') }}">الفواتير غير المدفوعة</a></li>
                            @endcan

                            @can('الفواتير المدفوعة جزئيا')
							<li><a class="slide-item" href="{{ url('/' . $page='Invoice_Partial') }}">الفواتير المدفوعة جزئيا</a></li>
                            @endcan

                            @can('ارشيف الفواتير')
							<li><a class="slide-item" href="{{ url('invoices_archive') }}">الفواتير المؤرشفة</a></li>
                            @endcan

						</ul>
					</li>
                    @endcan

                    @can('التقارير')
                        <li class="side-item side-item-category">التقارير</li>
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" opacity=".3"/><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg><span class="side-menu__label">التقارير</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('تقرير الفواتير')
                                     <li><a class="slide-item" href="{{ url('/' . $page='report_invoice') }}">تقارير الفواتير</a></li>
                                @endcan

                                @can('تقرير العملاء')
                                    <li><a class="slide-item" href="{{ url('/' . $page='report_custom') }}">تقارير العملاء</a></li>
                                @endcan
                            </ul>
                        </li>

                    @endcan
                    @can('المستخدمين')
					<li class="side-item side-item-category">المستخدمين</li>


					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z"/></svg><span class="side-menu__label">المستخدمين</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">

                            @can('قائمة المستخدمين')
							<li><a class="slide-item" href="{{ url('/' . $page='users') }}">المستخدمين</a></li>
                            @endcan

                            @can('صلاحيات المستخدمين')
							<li><a class="slide-item" href="{{ url('/' . $page='roles') }}">صلاحيات المستخدمين</a></li>
                            @endcan
						</ul>
					</li>
                    @endcan


                    @can('الاعدادات')
                    <li class="side-item side-item-category">الأعدادات</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg><span class="side-menu__label">الأعدادات</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">

                            @can('الاقسام')
							<li><a class="slide-item" href="{{url('section')}}">الأقسام</a></li>
                            @endcan

                            @can('المنتجات')
							<li><a class="slide-item" href="{{url('products')}}">المنتجات</a></li>
                           @endcan

						</ul>
					</li>
                    @endcan

				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
