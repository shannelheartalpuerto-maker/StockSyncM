@foreach($staff as $member)
<tr>
    <td class="ps-4">
        <div class="fw-bold text-dark">{{ $member->name }}</div>
        <div class="text-muted small">Staff Member</div>
    </td>
    <td>{{ $member->email }}</td>
    <td>
        @if($member->status == 'active')
            <span class="status-badge status-success">Active</span>
        @else
            <span class="status-badge status-danger">Suspended</span>
        @endif
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm rounded-3 overflow-hidden">
            @if($member->status == 'active')
                <button type="button" class="btn btn-white btn-sm border-end" data-bs-toggle="modal" data-bs-target="#ajax-suspendStaffModal{{ $member->id }}" title="Suspend">
                    <i class="fa-solid fa-user-lock text-warning"></i>
                </button>
            @else
                <form action="{{ route('admin.staff.update', $member->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="active">
                    <button type="submit" class="btn btn-white btn-sm border-end" title="Activate">
                        <i class="fa-solid fa-user-check text-success"></i>
                    </button>
                </form>
            @endif
            
            <button type="button" class="btn btn-white btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#ajax-deleteStaffModal{{ $member->id }}" title="Delete">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
