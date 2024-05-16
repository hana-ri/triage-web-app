<div class="dropdown">
    <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="rolesDropdownButton"
        data-bs-toggle="dropdown" aria-expanded="false"> Action </a>
    <ul class="dropdown-menu" aria-labelledby="rolesDropdownButton">
        <li>
            <a class="dropdown-item edit-roles-modal" href="#" data-id="{{ $row->id }}">Edit</a>
        </li>
        <li>
            <a class="dropdown-item delete-roles-action" href="#" data-id="{{ $row->id }}">Delete</a>
        </li>
    </ul>
</div>
