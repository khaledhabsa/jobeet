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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$role->name}}</td>
                                <td>@include('users::roles.actions',['id'=>$role->id])</td>
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
