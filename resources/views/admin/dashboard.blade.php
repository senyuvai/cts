@extends('master')

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30"></div>
        <div class="p-15 p-t-none p-b-none m-l-10 m-r-10">
        @include('notification.notify')
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row text-center">

                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-success text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-users"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$employee}} Kayıtlı Çalışan</span>
                                        <br>
									    <span class="small m-b-5 font-15">{{$employee}} Aktif Çalışan</span>
										<br />
                                        <a href="{{url('employees/add')}}" class="btn btn-complete btn-xs text-uppercase">{{language_data('Add New')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-complete text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-bed"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$leave}} {{language_data('Leave Application')}}</span>
                                        <br>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-primary text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-bar-chart"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <br>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-complete-darker text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-envelope"></i></span>

                                    

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="p-15 p-t-none p-b-none">
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel-body">
                        <div class="row">
                            

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel">
                                
                                .
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>



    </section>

@endsection


{{--External Style Section--}}
@section('script')

    {!! Html::script("assets/js/highcharts.js")!!}

    <script>
        $(document).ready(function () {

            var get_expense = <?php echo $get_expense; ?>;

            var get_expense_data = [
                { month: 'Jan', val: [] },
                { month: 'Feb', val: [] },
                { month: 'Mar', val: [] },
                { month: 'Apr', val: [] },
                { month: 'May', val: [] },
                { month: 'Jun', val: [] },
                { month: 'Jul', val: [] },
                { month: 'Aug', val: [] },
                { month: 'Sep', val: [] },
                { month: 'Oct', val: [] },
                { month: 'Nov', val: [] },
                { month: 'Dec', val: [] }
            ];

            get_expense.forEach( function( item ) {
                get_expense_data[new Date(item.purchase_date).getMonth()].val.push( Number(item.amount) );
            });


            get_expense_data = get_expense_data.map( function( item ) {
                if ( item.val.length > 0 ) {
                    item.val = item.val.reduce(function(a, b) {
                        return a+b;
                    });
                } else {
                    item.val = 0;
                }

                return item;
            });

            var get_expense_months = get_expense_data.map(function(item){
                return item.month;
            });

            var get_expense_amounts = get_expense_data.map(function(item){
                return item.val;
            });


            Highcharts.chart('supportTickets', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'SupportTickets',
                    colorByPoint: true,
                    data: [{
                        name: 'Pending',
                        y: <?php echo $st_pending;?>
                    }, {
                        name: 'Closed',
                        y: <?php echo $st_closed;?>
                    }, {
                        name: 'Customer Reply',
                        y: <?php echo $st_replied; ?>
                    }, {
                        name: 'Answered',
                        y: <?php echo $st_answered; ?>
                    }]
                }]
            });


            Highcharts.chart('expense', {

                title: {
                    text: ''
                },

                credits: {
                    enabled: false
                },

                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },

                yAxis: {
                    title: {
                        text: 'Expense Amount'
                    }
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: false,
                            borderRadius: 5,
                            backgroundColor: 'rgba(252, 255, 197, 0.7)',
                            borderWidth: 1,
                            borderColor: '#AAA',
                            y: -6
                        }
                    }
                },

                series: [{
                    name: 'Expense',
                    data: get_expense_amounts
                }]

            });

        });
    </script>
@endsection