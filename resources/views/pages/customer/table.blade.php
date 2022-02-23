<table class="table table-hover table-bordered table-customer">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">CUSTOMER ID</th>
            <th class="text-center">NAME</th>
            <th class="text-center">ADDRESS</th>
            <th class="text-center">USERNAME</th>
            <th class="text-center">KWH NO</th>
            <th class="text-center">ACTION</th>
        </tr>
    </thead>
    <body>
        @if(count($customer)*1==0)
        <tr>
            <td colspan="100%" class="text-center text-danger"><b>No Data</b></td>
        </tr>
        @else
        <?php $no=($customer->currentpage()-1) * $customer->perpage() + 1 ?>
        @foreach($customer as $val)
            <tr>
                <td class="text-center" >{{$no}}</td>
                <td class="text-center" >{{$val->CustomerID}}</td>
                <td >{{$val->CustomerName}}</td>
                <td >{{$val->Address}}</td>
                <td class="text-center" >{{$val->UserName}}</td>
                <td >{{$val->KWHNo}}</td>
                <td class="text-center">
                    <div class="btn-group ">
                        <div class="dropdown">
                            <button class="btn btn-info me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bi bi-life-preserver"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" data-action="view" data-id="{{$val->IndexCustomer}}" onclick="btn_action(this)">View</a>
                                <a class="dropdown-item" data-action="edit" data-id="{{$val->IndexCustomer}}" onclick="btn_action(this)">Edit</a>
                                <!-- <a class="dropdown-item" data-action="inactive" data-id="{{$val->IndexCustomer}}" onclick="btn_action(this)">Inactive</a> -->
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $no++; ?>
        @endforeach
        <tr>
            <td colspan="7" class="text-center table-footer"><span class="badge bg-info"><b>{{count($customer)}} DATA FOUND </b></span></td>
        </tr>
        @endif

    </body>
</table>