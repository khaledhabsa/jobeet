@can('roles.edit')
    <a href="{{route('roles.edit', ['role' => $id])}}" class="btn btn-info btn-sm"><i class="zmdi zmdi-edit"></i></a>
@endcan
@can('roles.delete')
    <form action="{{ route('roles.destroy',['role' => $id]) }}" method="POST" class="d-inline">
        @csrf
        @method("DELETE")
        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role ?!')">
            <i class="zmdi zmdi-delete"></i>
        </button>
    </form>
@endcan
