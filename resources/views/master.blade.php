<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{app_config('AppTitle')}}</title>
    <link rel="icon" type="image/x-icon"  href="<?php echo asset(app_config('AppFav')); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{--Global StyleSheet Start--}}
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    {!! Html::style("assets/libs/bootstrap/css/bootstrap.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-toggle/css/bootstrap-toggle.min.css") !!}
    {!! Html::style("assets/libs/font-awesome/css/font-awesome.min.css") !!}
    {!! Html::style("assets/libs/alertify/css/alertify.css") !!}
    {!! Html::style("assets/libs/alertify/css/alertify-bootstrap-3.css") !!}
    {!! Html::style("assets/libs/bootstrap-select/css/bootstrap-select.min.css") !!}

    {{--Custom StyleSheet Start--}}

    @yield('style')

    {{--Global StyleSheet End--}}

    {!! Html::style("assets/css/style.css") !!}
    {!! Html::style("assets/css/admin.css") !!}
    {!! Html::style("assets/css/responsive.css") !!}


</head>



<body class="has-left-bar has-top-bar">

<nav id="left-nav" class="left-nav-bar">
    <div class="nav-top-sec">
        <div class="app-logo">
            <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo">
        </div>

        <a href="#" id="bar-setting" class="bar-setting"><i class="fa fa-bars"></i></a>
    </div>
    <div class="nav-bottom-sec">
        <ul class="left-navigation" id="left-navigation">

            {{--Dashboard--}}
            <li @if(Request::path()== 'dashboard') class="active" @endif><a href="{{url('dashboard')}}"><span class="menu-text">{{language_data('Dashboard')}}</span> <span class="menu-thumb"><i class="fa fa-dashboard"></i></span></a></li>

			 @if(menu_access('Employees'))
            {{--Employee--}}
            <li class="has-sub @if(Request::path()== 'departments' OR Request::path()=='designations' OR Request::path()=='sgklar') sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">Tanımlar</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-users"></i></span></a>
                <ul class="sub">

                     <li @if(Request::path()== 'departments') class="active" @endif><a href={{url('departments')}}><span class="menu-text">{{language_data('Departments')}}</span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li>

                    <li @if(Request::path()== 'designations') class="active" @endif><a href={{url('designations')}}><span class="menu-text">{{language_data('Designations')}}</span> <span class="menu-thumb"><i class="fa fa-user-plus"></i></span></a></li>

                    <li @if(Request::path()== 'sgklar')  class="active" @endif><a href={{url('sgklar')}}><span class="menu-text">SGK Tanımları</span> <span class="menu-thumb"><i class="fa fa-user-secret"></i></span></a></li>
					  </ul>
            </li>
            @endif
			

            @if(menu_access('Employees'))
            {{--Employee--}}
            <li class="has-sub @if(Request::path()== 'employees/all' OR Request::path()=='employees/add' OR Request::path()=='employees/view/'.view_id()) sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">{{language_data('Employees')}}</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-users"></i></span></a>
                <ul class="sub">

                    <li @if(Request::path()== 'employees/all' OR Request::path()=='employees/view/'.view_id()) class="active" @endif><a href={{url('employees/all')}}><span class="menu-text">{{language_data('All Employees')}}</span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li>

                    <li @if(Request::path()== 'employees/add') class="active" @endif><a href={{url('employees/add')}}><span class="menu-text">{{language_data('Add Employee')}}</span> <span class="menu-thumb"><i class="fa fa-user-plus"></i></span></a></li>

                    

                </ul>
            </li>
            @endif

           @if(menu_access('Training'))
            {{--Training--}}
            <li class="has-sub @if(Request::path()=='training/employee-training' OR Request::path()=='training/view-employee-training/'.view_id() OR Request::path()== 'training/trainers' OR Request::path()== 'training/trainingdetails' OR Request::path()=='training/view-trainers-info/'.view_id() ) sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">{{language_data('Training')}}</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a>
                <ul class="sub">
                    <li @if(Request::path()== 'training/employee-training' OR Request::path()=='training/view-employee-training/'.view_id()) class="active" @endif><a href={{url('training/employee-training')}}><span class="menu-text">Yapılan eğitimler</span> <span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a></li>
					<li @if(Request::path()== 'training/trainingdetails' OR Request::path()=='training/trainingdetails/'.view_id()) class="active" @endif><a href={{url('training/trainingdetails')}}><span class="menu-text">Eğitim Tanımları</span> <span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a></li>

                    <li @if(Request::path()== 'training/trainers' OR Request::path()=='training/view-trainers-info/'.view_id()) class="active" @endif><a href={{url('training/trainers')}}><span class="menu-text">{{language_data('Trainers')}}</span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li>

                  


                </ul>
            </li>
            @endif

			
			   @if(menu_access('Saglik'))
            {{--Leave--}}
             <li class="has-sub @if(Request::path()== 'saglik' OR Request::path()=='muayene' OR Request::path()=='muayeneturler') sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">Sağlık Raporları</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-users"></i></span></a>
                <ul class="sub">
			<li @if(Request::path()== 'saglik'  OR Request::path()=='saglik/edit/'.view_id()) class="active" @endif><a href="{{url('saglik')}}"><span class="menu-text">ISG Raporu</span> <span class="menu-thumb"><i class="fa fa-bed"></i></span></a></li>
					<li @if(Request::path()== 'muayene'  OR Request::path()=='muayene/edit/'.view_id()) class="active" @endif><a href="{{url('muayene')}}"><span class="menu-text">Sağlık Raporu</span> <span class="menu-thumb"><i class="fa fa-bed"></i></span></a></li>
										<li @if(Request::path()== 'muayeneturler') class="active" @endif><a href="{{url('muayeneturler')}}"><span class="menu-text">Muayene Türleri</span> <span class="menu-thumb"><i class="fa fa-bed"></i></span></a></li>

					</ul>
				 </li>
            @endif

            @if(menu_access('Holiday'))
            {{--Holiday--}}
            <li class="has-sub @if(Request::path()== 'holiday' OR Request::path()=='holiday/add' OR Request::path()== 'holiday/view-holiday/'.view_id()) sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">{{language_data('Holiday')}}</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-plane"></i></span></a>
                <ul class="sub">

                    <li @if(Request::path()== 'holiday'  OR Request::path()=='holiday/view-holiday/'.view_id()) class="active" @endif><a href={{url('holiday')}}><span class="menu-text">{{language_data('Holiday Calender')}}</span> <span class="menu-thumb"><i class="fa fa-calendar"></i></span></a></li>

                    <li @if(Request::path()== 'holiday/add') class="active" @endif><a href={{url('holiday/add')}}><span class="menu-text">{{language_data('Add New Holiday')}}</span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>

                </ul>
            </li>
            @endif

            

            @if(menu_access('Notice Board'))
            {{--Notice Board--}}
            <li @if(Request::path()== 'notice-board'  OR Request::path()=='notice-board/edit/'.view_id()) class="active" @endif><a href="{{url('notice-board')}}"><span class="menu-text">{{language_data('Notice Board')}}</span> <span class="menu-thumb"><i class="fa fa-sticky-note"></i></span></a></li>
            @endif

           


            @if(menu_access('Settings'))
            {{--Setting--}}
            <li class="has-sub @if(Request::path()== 'settings/general' OR Request::path()=='settings/localization'  OR Request::path()=='settings/tax-rules' OR Request::path()=='tax-rules/set-rules/'.view_id() OR Request::path()=='settings/email-templates'  OR Request::path()=='settings/email-template-manage/'.view_id() OR Request::path()=='settings/language-settings' OR Request::path()=='settings/language-settings-translate/'.view_id()) sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">{{language_data('Settings')}}</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-cogs"></i></span></a>
                <ul class="sub">

                    <li @if(Request::path()== 'settings/general') class="active" @endif><a href={{url('settings/general')}}><span class="menu-text">{{language_data('System Settings')}}</span> <span class="menu-thumb"><i class="fa fa-cog"></i></span></a></li>

                    <li @if(Request::path()== 'settings/localization') class="active" @endif><a href={{url('settings/localization')}}><span class="menu-text">{{language_data('Localization')}}</span> <span class="menu-thumb"><i class="fa fa-globe"></i></span></a></li>

                    <li @if(Request::path()== 'settings/email-templates' OR Request::path()=='settings/email-template-manage/'.view_id()) class="active" @endif><a href={{url('settings/email-templates')}}><span class="menu-text">{{language_data('Email Templates')}}</span> <span class="menu-thumb"><i class="fa fa-envelope"></i></span></a></li>

                    <li @if(Request::path()== 'settings/tax-rules' OR Request::path()=='settings/tax-rules-manage/'.view_id() OR Request::path()=='tax-rules/set-rules/'.view_id()) class="active" @endif><a href={{url('settings/tax-rules')}}><span class="menu-text">{{language_data('Tax Rules')}}</span> <span class="menu-thumb"><i class="fa fa-calculator"></i></span></a></li>

                    <li @if(Request::path()== 'settings/language-settings' OR Request::path()=='settings/language-settings-manage/'.view_id() OR Request::path()=='settings/language-settings-translate/'.view_id()) class="active" @endif><a href={{url('settings/language-settings')}}><span class="menu-text">{{language_data('Language Settings')}}</span> <span class="menu-thumb"><i class="fa fa-language"></i></span></a></li>

                    <li @if(Request::path()== 'settings/sms-gateways' OR Request::path()=='settings/sms-gateways-manage/'.view_id()) class="active" @endif><a href={{url('settings/sms-gateways')}}><span class="menu-text">{{language_data('SMS Gateways')}}</span> <span class="menu-thumb"><i class="fa fa-mobile-phone"></i></span></a></li>

                    <li @if(Request::path()== 'settings/disable-menus' OR Request::path()=='settings/disable-menus-manage/'.view_id()) class="active" @endif><a href={{url('settings/disable-menus')}}><span class="menu-text">{{language_data('Disable Menu/Module')}}</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                </ul>
            </li>
            @endif



        </ul>
    </div>
</nav>

<main id="wrapper" class="wrapper">

    <div class="top-bar clearfix">
        <ul class="top-info-bar">
            <li class="dropdown bar-notification @if(count(latest_five_leave_application())>0) active @endif">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bed"></i></a>
                <ul class="dropdown-menu user-dropdown arrow" role="menu">
                    <li class="title">{{language_data('Recent 5 Leave Applications')}}</li>

                    @foreach(latest_five_leave_application() as $l)
                    <li>
                        <a href="{{url('leave/edit/'.$l->id)}}">
                            @if($l->employee_id->avatar!='')
                                <img class="user-thumb" src="<?php echo asset('assets/employee_pic/'.$l->employee_id->avatar); ?>" alt="{{$l->employee_id->fname}} {{$l->employee_id->lname}}">
                            @else
                                <img class="user-thumb" src="<?php echo asset('assets/employee_pic/user.png'); ?>" alt="{{$l->employee_id->fname}} {{$l->employee_id->lname}}">
                            @endif

                            <div class="user-name">{{$l->employee_id->fname}} {{$l->employee_id->lname}}</div>
                        </a>
                    </li>

                    @endforeach

                    <li class="footer"><a href="{{url('leave')}}">{{language_data('See All Applications')}}</a></li>
                </ul>
            </li>

            <li class="dropdown bar-notification @if(count(latest_five_tasks())>0) active @endif">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cloud-download"></i></a>
                <ul class="dropdown-menu arrow" role="menu">
                    <li class="title">{{language_data('Recent 5 Pending Tasks')}}</li>

                    @foreach(latest_five_tasks() as $t)
                        <li><a href="{{url('task/view/'.$t->id)}}">{{$t->task}}</a></li>
                    @endforeach

                    <li class="footer"><a href="{{url('task')}}">{{language_data('See All Tasks')}}</a></li>
                </ul>
            </li>

            <li class="dropdown bar-notification @if(count(latest_five_tickets())>0) active @endif">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                <ul class="dropdown-menu arrow message-dropdown" role="menu">
                    <li class="title">{{language_data('Recent 5 Pending Tickets')}}</li>
                    @foreach(latest_five_tickets() as $st)
                    <li>
                        <a href="{{url('support-tickets/view-ticket/'.$st->id)}}">
                            <div class="name">{{$st->name}} <span>{{$st->date}}</span></div>
                            <div class="message">{{$st->subject}}</div>
                        </a>
                    </li>
                    @endforeach

                    <li class="footer"><a href="{{url('support-tickets/all')}}">{{language_data('See All Tickets')}}</a></li>
                </ul>
            </li>
        </ul>


        <div class="navbar-right">

            <div class="clearfix">


                <div class="dropdown user-profile pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="user-info">{{Auth::user()->fname}} {{Auth::user()->lname}}</span>

                        @if(Auth::user()->avatar!='')
                            <img class="user-image" src="<?php echo asset('assets/employee_pic/'.Auth::user()->avatar); ?>" alt="{{Auth::user()->fname}} {{Auth::user()->lname}}">
                        @else
                            <img class="user-image" src="<?php echo asset('assets/employee_pic/user.png'); ?>" alt="{{Auth::user()->fname}} {{Auth::user()->lname}}">
                        @endif

                    </a>
                    <ul class="dropdown-menu arrow right-arrow" role="menu">
                        <li><a href="{{url('user/edit-profile')}}"><i class="fa fa-edit"></i>{{language_data('Update Profile')}}</a></li>
                        <li><a href="{{url('user/change-password')}}"><i class="fa fa-lock"></i>{{language_data('Change Password')}}</a></li>
                        <li class="bg-dark">
                            <a href="{{url('user/logout')}}" class="clearfix">
                                <span class="pull-left">{{language_data('Logout')}}</span>
                                <span class="pull-right"><i class="fa fa-power-off"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>



                @if(Auth::user()->user_name!='admin')
                <div class="top-info-bar m-r-10">

                    <div class="pull-right">
                        <a href="{{url('employee/dashboard')}}" target="_blank" class="btn btn-success btn-sm" aria-expanded="false">{{language_data('My Portal')}}</a>
                    </div>
                </div>
                @endif

                <div class="top-info-bar m-r-10">

                    <div class="dropdown pull-right bar-notification">
                        <a href="#" class="dropdown-toggle text-success" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="<?php echo asset('assets/country_flag/'.\App\Language::find(app_config('Language'))->icon); ?>" alt="Language">
                        </a>
                        <ul class="dropdown-menu lang-dropdown arrow right-arrow" role="menu">
                            @foreach(get_language() as $lan)
                                <li>
                                    <a href="{{url('language/change/'.$lan->id)}}" @if($lan->id==app_config('Language')) class="text-complete" @endif>
                                        <img class="user-thumb" src="<?php echo asset('assets/country_flag/'.$lan->icon); ?>" alt="user thumb">
                                        <div class="user-name">{{$lan->language}}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>



            </div>

        </div>
    </div>

    {{--Content File Start Here--}}

    @yield('content')

    {{--Content File End Here--}}

    <input type="hidden" id="_url" value="{{url('/')}}">
    <input type="hidden" id="_DatePicker" value="{{app_config('DateFormat')}}">
</main>

{{--Global JavaScript Start--}}
{!! Html::script("assets/libs/jquery-1.10.2.min.js") !!}
{!! Html::script("assets/libs/jquery.slimscroll.min.js") !!}
{!! Html::script("assets/libs/smoothscroll.min.js") !!}
{!! Html::script("assets/libs/bootstrap/js/bootstrap.min.js") !!}
{!! Html::script("assets/libs/bootstrap-toggle/js/bootstrap-toggle.min.js") !!}
{!! Html::script("assets/libs/alertify/js/alertify.js") !!}
{!! Html::script("assets/libs/bootstrap-select/js/bootstrap-select.min.js") !!}
{!! Html::script("assets/js/scripts.js") !!}
{{--Global JavaScript End--}}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });
</script>

{{--Custom JavaScript Start--}}

@yield('script')

{{--Custom JavaScript End Here--}}
</body>

</html>
