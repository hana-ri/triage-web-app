<div class="dropdown">
    <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="userDropdownButton"
        data-bs-toggle="dropdown" aria-expanded="false"> Action </a>
    <ul class="dropdown-menu" aria-labelledby="userDropdownButton">
        <li>
            <a class="dropdown-item edit-user-button" href="#" data-id="{{ $row->id }}">Edit informaton</a>
        </li>
        <li>
            <a class="dropdown-item change-password-user-button" href="#" data-id="{{ $row->id }}">Change password</a>
        </li>
        <li>
            <a class="dropdown-item delete-user-action" href="#" data-id="{{ $row->id }}">Delete</a>
        </li>
    </ul>
</div>
