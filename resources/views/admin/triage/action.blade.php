<div class="dropdown">
    <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="triageDropdownButton"
        data-bs-toggle="dropdown" aria-expanded="false"> Action </a>
    <ul class="dropdown-menu" aria-labelledby="triageDropdownButton">
        <li>
            <a class="dropdown-item edit-triage-modal" href="#" data-id="{{ $row->id }}">Edit</a>
        </li>
        <li>
            <a class="dropdown-item delete-triage-action" href="#" data-id="{{ $row->id }}">Delete</a>
        </li>
    </ul>
</div>
