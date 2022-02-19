@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">Lista de Tarefas</div>
                        <div class="col-6">
                            <div class="float-end">
                                <a href="{{ route('tarefa.create') }}" class="mr-3">Nova</a>
                                <a href="{{ route('tarefa.export',['extensao' => 'xlsx']) }}">XLSX</a>
                                <a href="{{ route('tarefa.export',['extensao' => 'csv']) }}">CSV</a>
                                <a href="{{ route('tarefa.export',['extensao' => 'pdf']) }}">PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data para Conclusão</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarefas as $key => $tarefa)
                                <tr>
                                    <th scope="row">{{ $tarefa->id }}</th>
                                    <td>{{ $tarefa->tarefa }}</td>
                                    <td>{{ date('d/m/Y',strtotime($tarefa->data_limite_conclusao)) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <form id="form_{{ $tarefa->id }}" method="post" action="{{ route('tarefa.destroy',$tarefa) }}">
                                                @method('DELETE')
                                                @csrf
                                                <a type="button" href="#" class="btn btn-danger" onclick="document.getElementById('form_{{ $tarefa->id }}').submit()">
                                                Excluir
                                                </a>
                                            </form>
                                            
                                            <a type="button" class="btn btn-warning" href="{{ route('tarefa.edit',$tarefa) }}">Editar</a>
                                            <a type="button" class="btn btn-success" href="{{ route('tarefa.show',$tarefa) }}">Concluir</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href=" {{ $tarefas->previousPageUrl() }}">Voltar</a></li>
                            @for ($i =1; $i <= $tarefas->lastPage() ;$i++)
                                <li class="page-item {{ $tarefas->currentPage() ==$i ? 'active' : ''}}">
                                    <a class="page-link" href="{{ $tarefas->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{ $tarefas->nextPageUrl() }}">Avançar</a></li>
                        </ul>
                    </nav>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
