
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="{{ asset('css/inv.css') }}" rel="stylesheet">
<title>BENAPOLE CUSTOMS C&F AGENTS ASSOCIATION</title>
    <div id="invoice">
        <div class="toolbar hidden-print">
            <div class="text-right">
                <button onclick="printDiv()" id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
{{--                <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>--}}
            </div>
            <hr>
        </div>

        <div id="printDiv" class="invoice">

                <main>
                    <div class="row">
                        <div class="col-6">
                            {{$file_data->lodgement_no}}
                        </div>
                        <div class="col-6">
                            {{$file_data->lodgement_date}}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{$file_data->agent->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {{$file_data->be_number}}
                        </div>
                        <div class="col-6">
                            {{$file_data->be_date}}
                        </div>
                    </div>

                </main>
{{--                <footer>--}}
{{--                    SoftxLtd--}}
{{--                </footer>--}}

            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>
    <script !src="">
        function printDiv() {
            Popup($('#printDiv').outerHTML);
            function Popup(data)
            {
                window.print();
                return true;
            }
        }
    </script>

