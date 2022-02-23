<table class="table table-hover table-bordered table-user">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">USER ID</th>
            <th class="text-center">NAME</th>
            <th class="text-center">EMAIL</th>
            <th class="text-center">PHONE</th>
            <th class="text-center">ADMIN NAME</th>
            <th class="text-center">LEVEL</th>
            <th class="text-center">ACTION</th>
        </tr>
    </thead>
    <body>
        @if(count($user)*1==0)
        <tr>
            <td colspan="100%" class="text-center text-danger"><b>No Data</b></td>
        </tr>
        @else
        <?php $no=($user->currentpage()-1) * $user->perpage() + 1 ?>
        @foreach($user as $val)
            <tr>
                <td class="text-center" >{{$no}}</td>
                <td class="text-center" >{{$val->UserID}}</td>
                <td >{{$val->UserName}}</td>
                <td >{{$val->Email}}</td>
                <td class="text-center" >{{$val->Phone}}</td>
                <td class="text-center" >{{$val->AdminName}}</td>
                <td class="text-center" >{{$val->IndexLevel}}</td>
                <td class="text-center">
                    <div class="btn-group ">
                        <div class="dropdown">
                            <button class="btn btn-info me-1" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bi bi-life-preserver"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" data-action="view" data-id="{{$val->IndexUser}}" onclick="btn_action(this)">View</a>
                                <a class="dropdown-item" data-action="edit" data-id="{{$val->IndexUser}}" onclick="btn_action(this)">Edit</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php $no++; ?>
        @endforeach
        <tr>
            <td colspan="8" class="text-center table-footer"><span class="badge bg-info"><b>{{count($user)}} DATA FOUND </b></span></td>
        </tr>
        @endif
    </body>
</table>