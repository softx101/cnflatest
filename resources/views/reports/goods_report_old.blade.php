@extends('layouts.admin')

@section('content')

    <h2 id="tr" class="text-center">Assessment Report Per Day</h2>
    <div class="card-header">
        <form action = "" >
            <div class="form-row">
                <div class="col-2 d-flex align-items-center">
                    <strong class="card-title m-0">All Available Report</strong>
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end">
                    <label>Date(Lodgement)</label>
                </div>
                <div class="col-5">
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 4px 20px; border: 1px solid #ccc; width: 100%">
                        <i class="mdi  mdi-calendar-clock"></i>&nbsp;
                        <span></span> <i class="mdi mdi-arrow-down"></i>
                    </div>

                    <div class="input-daterange d-none">
                        <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                        <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                    </div>
                </div>

                <div class="col ">
{{--                    {{Form::select('agent_id', $agents, null, ['id' => 'agent_id', 'class' => 'select2_op form-control','placeholder' => 'Select Agent', 'required'])}}--}}
                </div>

                <div class="col text-center">
                    <button type="button" name="filter" id="filter" class="btn btn-primary" style="padding: .3rem 1rem;">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-success" style="padding: .3rem 1rem;">Refresh</button>
                </div>
            </div>
        </form>
    </div>

    <table id="all_report" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Date</th>
                <th>Total File</th>
                <th>Perishable </th>
                <th>Wating G.F </th>
                <th>(T - P)</th>
                <th>{(T - P) - W.G.F}</th>
                <th>%</th>
            </tr>
        </thead>
        @foreach($assReport as $goodreport)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$goodreport['name']}}</td>
            <td>{{$goodreport['lodgement_date']}}</td>
            <td>{{$goodreport['totalFiles']}}</td>
            <td>{{$goodreport['TotalPerishable']}}</td>
            <td>{{$goodreport['Waiting_G_F']}}</td>
            <td>{{$goodreport['tp']}}</td>
            <td>{{$goodreport['tpwgf']}}</td>
            <td>{{$goodreport['prsnt']}}</td>
        </tr>
        @endforeach
        <tfoot>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Date</th>
            <th>Total File</th>
            <th>Perishable </th>
            <th>Wating G.F </th>
            <th>(T - P)</th>
            <th>{(T - P) - W.G.F}</th>
            <th>%</th>
        </tr>
        </tfoot>
    </table>
@endsection


@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.20/filtering/row-based/range_dates.js"></script>

    <script !src="">
        // load_data();
        // date rang picker
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                var from_date = start.format('YYYY-MM-DD');
                var to_date = end.format('YYYY-MM-DD');
                $("#from_date").val(from_date);
                $("#to_date").val(to_date);
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
        });

        //ajux data with date range

        $(function() {
            var customer_name = '';
            load_data();

            function load_data(from_date = '', to_date = '', agent_id = '')
            {
                $('#all_report').DataTable({

                    processing: true,
                    serverSide: true,
                    dom: 'lBftip',
                    buttons: [
                        {
                            extend: 'pdf',
                            messageTop: 'File Report',
                            footer: true
                        },
                        'csv',
                        'excel',
                        {
                            extend: 'print',
                            messageTop: '<h2>File Report ' +customer_name+ '</h2>',
                            footer: true
                        }
                    ],
                    ajax: {
                        url:'{!! route("get_goods_report") !!}',
                        data:{from_date:from_date, to_date:to_date, agent_id:agent_id}
                    },
                    columns: [
                        {
                            title: "No",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        { data: 'name', name: 'name' },
                        { data: 'lodgement_date', name: 'lodgement_date' },
                        { data: 'totalFiles', name: 'totalFiles', className: 'sum' },
                        { data: 'TotalPerishable', name: 'TotalPerishable', className: 'sum' },
                        { data: 'Waiting_G_F', name: 'Waiting_G_F', className: 'sum' },
                        { data: 'tp', name: 'tp', className: 'sum' },
                        { data: 'tpwgf', name: 'tpwgf', className: 'sum' },
                        { data: 'prsnt', name: 'prsnt', className: 'sum' }
                    ],

                    "footerCallback": function(row, data, start, end, display) {
                        var api = this.api();
                        api.columns('.sum', { page: 'current' }).every(function () {
                            var sum = this
                            .data()
                            .reduce(function (a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                            console.log(sum);
                            // Update footer
                            $(this.footer()).html('Total = '+sum);
                        });
                    }


                });

            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var agent_id = $("#agent_id option:selected").val();

                if (agent_id != ''){
                    // customer_name = '-'+ $("#agent_id option:selected").text();
                    customer_name = '';
                    document.getElementById("tr").innerHTML = 'Assessment Report Per Day'+customer_name;
                }else {
                    customer_name = '';
                    document.getElementById("tr").innerHTML = 'Assessment Report Per Day'+customer_name;
                }


                if( from_date != '' &&  to_date != '')
                {
                    $('#all_report').DataTable().destroy();
                    load_data(from_date, to_date, agent_id);
                }
                else
                {
                    alert('Both Date is required');
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $("#agent_id").select2().val('').trigger("change");
                $('#all_report').DataTable().destroy();
                customer_name = '';
                document.getElementById("tr").innerHTML = 'Assessment Report Per Day '+customer_name;
                load_data();
            });

        });
    </script>


@endsection
