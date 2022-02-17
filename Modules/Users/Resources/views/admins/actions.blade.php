@can('admins.edit')
    <a href="{{route('admins.edit', ['admin' => $id])}}" class="btn btn-info btn-sm"><i class="zmdi zmdi-edit"></i></a>
@endcan
@can('admins.delete')
    <form action="{{ route('admins.destroy',['admin' => $id]) }}" method="POST" class="d-inline">
        @csrf
        @method("DELETE")
        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admin ?!')">
            <i class="zmdi zmdi-delete"></i>
        </button>
    </form>
@endcan
