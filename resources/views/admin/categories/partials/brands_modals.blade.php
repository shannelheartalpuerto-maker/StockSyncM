@foreach($brands as $brand)
    <!-- Edit Modal -->
    <div class="modal fade" id="ajax-editBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="fa-solid fa-pen-to-square text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold">Edit Brand</h5>
                                <p class="text-muted small mb-0">{{ $brand->name }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-0">
                            <label for="brand_name{{ $brand->id }}" class="form-label fw-bold">Brand Name</label>
                            <div class="input-group search-input-group border">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-copyright text-muted"></i></span>
                                <input type="text" class="form-control border-0 bg-transparent" id="brand_name{{ $brand->id }}" name="name" value="{{ $brand->name }}" required placeholder="Enter brand name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="ajax-deleteBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <div class="bg-danger bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
                            <i class="fa-solid fa-trash-can text-danger fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Delete Brand?</h5>
                        <p class="text-muted small mb-2">Delete <strong>{{ $brand->name }}</strong>? Products linked to this brand will be unlinked.</p>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button type="button" class="btn btn-light px-4 flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="flex-grow-1">
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
