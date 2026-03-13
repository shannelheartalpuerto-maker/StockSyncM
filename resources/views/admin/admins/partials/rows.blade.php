@foreach($admins as $admin)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark">{{ $admin->name }}</div>
        <div class="text-muted small">Admin Account</div>
    </td>
    <td>{{ $admin->email }}</td>
    <td>
        @if($admin->status == 'active')
            <span class="status-badge status-success">Active</span>
        @else
            <span class="status-badge status-danger">Suspended</span>
        @endif
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
            @if($admin->status == 'active')
                <button type="button" class="btn btn-white btn-sm border-end" data-bs-toggle="modal" data-bs-target="#ajax-suspendAdminModal{{ $admin->id }}" title="Suspend">
                    <i class="fa-solid fa-user-lock text-warning"></i>
                </button>
            @else
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="active">
                    <button type="submit" class="btn btn-white btn-sm border-end" title="Activate">
                        <i class="fa-solid fa-user-check text-success"></i>
                    </button>
                </form>
            @endif
            
            <button type="button" class="btn btn-white btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#ajax-deleteAdminModal{{ $admin->id }}" title="Delete">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
