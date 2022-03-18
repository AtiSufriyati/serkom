<table class="table table-hover table-bordered table-price">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">CUSTOMER ID</th>
            <th class="text-center">MONTH</th>
            <th class="text-center">ADMIN CHARGE</th>
            <th class="text-center">TOTAL</th>
            <th class="text-center">DATE</th>

            <th class="text-center">ACTION</th>

        </tr>
    </thead>
    <body>
        @if(count($payment)*1==0)
        <tr>
            <td colspan="100%" class="text-center text-danger"><b>No Data</b></td>
        </tr>
        @else
        <?php $no=($payment->currentpage()-1) * $payment->perpage() + 1 ?>
        @foreach($payment as $val)
            <tr>
                <td class="text-center" >{{$no}}</td>
                <td class="text-center">{{$val->CustomerID}}</td>
                <td class="text-center">{{$val->Month}}</td>
                <td class="text-right">{{$val->AdminCharge}}</td>
                <td class="text-right">{{$val->TotalPayment}}</td>
                <td class="text-center" >{{$val->PaymentDate}}</td>
                <td class="text-center">
                    <button class="btn btn-info me-1" type="button" data-index ="{{$val->IndexPayment}}" onclick="viewPayment(this)">
                        view
                    </button>
                </td>
            </tr>
        <?php $no++; ?>
        @endforeach
        <tr>
            <td colspan="8" class="text-center table-footer"><span class="badge bg-info"><b>{{count($payment)}} DATA FOUND </b></span></td>
        </tr>
        @endif
    </body>
</table>