<div class="col-12 table-responsive mt-4">
    <table class="table align-middle">
        <thead>
            <tr>
                <td>ID</td>
                <td>Usuário</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($legalPerson as $person)
                <tr id="person-{{ $person->id }}">
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->corporate_name }}</td>
                    <td class="d-flex">
                        <a class="mr-3 btn btn-sm btn-outline-success"
                            href="{{ route('legalPerson.edit', ['legalPerson' => $person->id]) }}">Editar</a>
                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete"
                            data-id-person="{{ $person->id }}" data-bs-toggle="modal"
                            data-bs-target="#modal-delete">Excluir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
