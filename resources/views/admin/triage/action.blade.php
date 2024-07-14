<div class="dropdown">
    <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="triageDropdownButton"
        data-bs-toggle="dropdown" aria-expanded="false"> Aksi </a>
    <ul class="dropdown-menu" aria-labelledby="triageDropdownButton">
        <li>
            <a class="dropdown-item edit-triage-modal" href="{{ route("admin.triage.show", $row->id) }}">Detail</a>
        </li>
        <li>
            <a class="dropdown-item edit-triage-modal" href="{{ route("admin.triage.edit", $row->id) }}">Ubah</a>
        </li>
        <li>
            <a class="dropdown-item delete-triage-action" href="#" data-id="{{ $row->id }}">Hapus</a>
        </li>
    </ul>
</div>
