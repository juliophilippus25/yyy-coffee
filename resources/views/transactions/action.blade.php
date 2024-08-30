@if ($data->status == 'Pending')
    <a href="#" id="{{ $data->id }}" data-toggle="tooltip" data-original-title="Edit"
        class="btn btn-warning btn-sm editIcon" title="Edit" data-bs-toggle="modal" data-bs-target="#editProductModal">
        <i class="ti ti-edit"></i>
    </a>
    <a href="#" id="{{ $data->id }}" data-toggle="tooltip" data-original-title="Delete"
        class="btn btn-danger btn-sm deleteIcon" title="Delete">
        <i class="ti ti-trash"></i>
    </a>
@elseif ($data->status == 'Completed')
    <a href="#" id="{{ $data->id }}" data-toggle="tooltip" class="btn btn-success btn-sm downloadIcon"
        title="Download">
        <i class="ti ti-download"></i>
    </a>
@endif
