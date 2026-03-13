@foreach($staff as $member)
    <!-- Suspend Confirmation Modal -->
    <div class="modal confirm-modal" id="ajax-suspendStaffModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-warning bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-user-lock text-warning fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Suspend Staff?</h5>
                        <p class="text-muted small mb-0">Suspend <strong>{{ $member->name }}</strong>? They will lose POS access immediately.</p>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button type="button" class="btn btn-light px-4 flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.staff.update', $member->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="suspended">
                            <button type="submit" class="btn btn-warning w-100 px-4 text-white">Suspend</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal confirm-modal" id="ajax-deleteStaffModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-trash-can text-danger fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Delete Staff?</h5>
                        <p class="text-muted small mb-0">This action cannot be undone. Are you sure you want to delete <strong>{{ $member->name }}</strong>?</p>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button type="button" class="btn btn-light px-4 flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 px-4">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
