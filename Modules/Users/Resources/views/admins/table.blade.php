<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body table-responsive">
                <div class="load-items">
                    <table class="table m-b-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>@include('users::admins.actions',['id'=>$user->id])</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                {!! $links !!}
            </div>
        </div>
    </div>
</div>
