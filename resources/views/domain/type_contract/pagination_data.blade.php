<div class="col-12 table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <td>ID</td>
                <td>Valor</td>
                <td>Descrição</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody id="body_table">
            @foreach ($typeContracts as $typeContract)
                <tr id="type-contract-{{$typeContract->id}}">
                    <td>{{$typeContract->id}}</td>
                    <td>{{$typeContract->value}}</td>
                    <td>{{$typeContract->description}}</td>
                    <td class="d-flex">
                        <a class="mr-3 btn btn-sm btn-outline-success" href="{{route('typeContract.edit', ['typeContract'=>$typeContract->id])}}">Editar</a>
                        <a href="" class="mr-3 btn btn-sm btn-outline-danger" id="btn-delete" data-id-type="{{$typeContract->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete">Excluir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
