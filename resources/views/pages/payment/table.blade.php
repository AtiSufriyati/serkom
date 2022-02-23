<table class="table table-hover table-bordered table-price">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">DATE</th>
            <th class="text-center">MONTH</th>
            <th class="text-center">ADMIN CHARGE</th>
            <th class="text-center">TOTAL</th>
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
                <td class="text-center" >{{$val->PaymentDate}}</td>
                <td >{{$val->Month}}</td>
                <td >{{$val->AdminCharge}}</td>
                <td >{{$val->TotalPayment}}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn btn-info me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bi bi-life-preserver"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" data-action="view" data-id="{{$val->IndexPrice}}" onclick="btn_action(this)">View</a>
                                <a class="dropdown-item" data-action="edit" data-id="{{$val->IndexPrice}}" onclick="btn_action(this)">Edit</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $no++; ?>
        @endforeach
        <tr>
            <td colspan="8" class="text-center table-footer"><span class="badge bg-info"><b>{{count($price)}} DATA FOUND </b></span></td>
        </tr>
        @endif
    </body>
</table>