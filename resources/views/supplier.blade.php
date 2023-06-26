@extends('master.layout')
@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
            <h1>Fornecedores</h1>
            </div>
            <div class="col-sm-4">
              @if ($permissao[0]->edit)
              <button class="btn btn-primary" onclick="location.href='{{env('APP_URL')}}fornecedores/add'">Criar Novo</button>
              @endif
            </div>
            <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{env('APP_URL')}}">Home</a></li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}fornecedores">Fornecedores</a></li>
            </ol>
            </div>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header" style="cursor:pointer" onclick="abreFecha('filtro')">
        <h3 class="card-title">Filtro</h3>
        </div>
        <!-- /.card-header -->
    </div>
    <div id="filtro" style="display:none">
      <form method="get" action="">
        <label for="nomeFiltro">Por Nome:</label>
        <input type="text" class="form-control" name="nomeFiltro" id="nomeFiltro" value="{{(isset($_REQUEST['nomeFiltro'])) ? $_REQUEST['nomeFiltro'] : ''}}">
        <label for="emailFiltro">Por documento:</label>
        <input type="text" class="form-control" name="documentoFiltro" id="documentoFiltro" value="{{(isset($_REQUEST['documentoFiltro'])) ? $_REQUEST['documentoFiltro'] : ''}}">
        <label for="emailFiltro">Registros por página:</label>
        <input type="number" min="1" class="form-control" name="totalPaginacao" id="totalPaginacao" value="{{(isset($_REQUEST['totalPaginacao'])) ? $_REQUEST['totalPaginacao'] : '15'}}">
        <div style="text-align:center"><button type="submit" class="btn btn-primary">Filtrar</button></div>
      </form>
    </div>
    <div class="card card-success">
        <div class="card-header" style="cursor:pointer" onclick="abreFecha('registros')">
        <h3 class="card-title">Registros</h3>
        </div>
        <!-- /.card-header -->
    </div>
    <div id="registros" class="card-body table-responsive p-0">
      @if (count($suppliers))
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>ID</th>
            <th>Razão Social / Nome</th>
            <th>Nome Fantasia / Apelido</th>
            <th>CNPJ / CPF</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($suppliers as $key => $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{($value->name) ? $value->name : $value->razao_social}}</td>
            <td>{{($value->surname) ? $value->surname : $value->nome_fantasia}}</td>
            <td>{{($value->cpf) ? $value->cpf : $value->cnpj}}</td>
            <td>
              <img src="{{env('APP_URL')}}storage/images/visualizar.svg" style="cursor:pointer" onclick="location.href='{{env('APP_URL')}}fornecedores/visualizar/{{$value->id}}'" width="18">
              @if ($permissao[0]->edit)
              <img src="{{env('APP_URL')}}storage/images/editar.svg" style="cursor:pointer" onclick="location.href='{{env('APP_URL')}}fornecedores/editar/{{$value->id}}'" width="18">
              @endif
              @if ($permissao[0]->delete)
              <img src="{{env('APP_URL')}}storage/images/excluir.svg" style="cursor:pointer" onclick="if (confirm('Tem certeza que deseja excluir esse fornecedor?')){ location.href='{{env('APP_URL')}}fornecedores/excluir/{{$value->id}}'; }" width="18">
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="ion pagination mr-1"></i>
            Paginação
          </h3>

          <div class="card-tools">
            <ul class="pagination pagination-sm" style="width:100%; text-align:center">
              <li class="page-item"><a class="page-link" style="cursor:pointer" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina=1"'>&laquo;</a></li>
              <li class="page-item"><a class="page-link" style="cursor:pointer" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina={{$anterior}}"'>&leftarrow;</a></li>
              <li class="page-item"><a class="page-link" style="cursor:pointer;@if ($_REQUEST['pagina'] == 1) background-color:#CCCCCC @endif" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina=1"'>1</a></li>
              @for ($i = 2; $i <= $suppliersPaginas; $i++)
              <li class="page-item"><a class="page-link" style="cursor:pointer;@if ($_REQUEST['pagina'] == $i) background-color:#CCCCCC @endif" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina={{$i}}"'>{{$i}}</a></li>
              @endfor
              <li class="page-item"><a class="page-link" style="cursor:pointer" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina={{$proxima}}"'>&rightarrow;</a></li>
              <li class="page-item"><a class="page-link" style="cursor:pointer" onClick='location.href="{{env('APP_URL')}}fornecedores?nomeFiltro{{$_REQUEST['nomeFiltro']}}&documentoFiltro={{$_REQUEST['documentoFiltro']}}&totalPaginacao={{$_REQUEST['totalPaginacao']}}&pagina={{$suppliersPaginas}}"'>&raquo;</a></li>
            </ul>
          </div>
        </div>
      </div>                      
      @else
      <div class="btn btn-danger" onclick="location.href='{{env('APP_URL')}}fornecedores/add'">Sem nenhum registro encontrado! Cadastre um agora mesmo!</div>
      @endif
    </div>
  @endsection