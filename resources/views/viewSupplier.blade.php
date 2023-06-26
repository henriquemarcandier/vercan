@extends('master.layout')
@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
            <h1>Fornecedores</h1>
            </div>
            <div class="col-sm-4">
              <button class="btn btn-danger" onclick="location.href='{{env('APP_URL')}}fornecedores'">&laquo; Voltar</button>
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
              <div class="card-header">
                <h3 class="card-title">Visualização de Fornecedor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosFornecedor'); mudaImg('btnDadosFornecedor')" id="btnDadosFornecedor"></i></button></div>
                  <h5>Dados do Fornecedor</h5>
                  <div id="dadosFornecedor">
                    <label for="tpForn">Tipo do Fornecedor:</label>
                    @if ($supplier[0]->tp_supplier == 'J')
                    Jurídica
                    @else
                    Física
                    @endif
                    <br>
                    <div id="pessoa">
                    @if ($supplier[0]->tp_supplier == 'J')
                    <div class="col-3" style="float:left">
                      <label for="cnpj">CNPJ: </label> {{$supplier_pj[0]->cnpj}}
                    </div>
                    <div class="col-6" style="float:left">
                      <label for="razaoSocial">Razão Social: </label> {{$supplier_pj[0]->razao_social}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="nomeFantasia">Nome Fantasia: </label> {{$supplier_pj[0]->nome_fantasia}}
                    </div><br><br>
                    <div class="col-3" style="float:left">
                      <label for="indInscrEst">Indicador de Inscrição Estadual: </label> @if ($supplier_pj[0]->ind_inscr_est == 'contribuinte') Contribuinte @elseif ($supplier_pj[0]->ind_inscr_est == 'contribuinte_isento') Contribuinte Isento @elseif ($supplier_pj[0]->ind_inscr_est == 'nao_contribuinte') Não Contribuinte @endif
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="inscrEst">Inscrição Estadual: </label> {{$supplier_pj[0]->inscr_est}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="inscrMun">Inscrição Municipal: </label> {{$supplier_pj[0]->inscr_mun}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="status">Situação CNPJ:</label> {{$supplier_pj[0]->situacao}}
                    </div><br><br><br>
                    <div class="col-3" style="float:left">
                      <label for="gathering">Recolhimento:</label> @if ($supplier_pj[0]->recolhimento == 'recolher') A Recolher pelo Prestador @elseif ($supplier_pj[0]->recolhimento == 'retido') Retido pelo Tomador @endif
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="active">Ativo: </label> @if ($supplier[0]->status == 0) Não @elseif ($supplier[0]->status == 1) Sim @endif
                    </div><br>
                    @else
                    <div class="col-3" style="float:left">
                      <label for="cpf">CPF: </label> {{$supplier_pf[0]->cpf}}
                    </div>
                    <div class="col-6" style="float:left">
                      <label for="nome">Nome: </label> {{$supplier_pf[0]->name}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="apelido">Apelido: </label> {{$supplier_pf[0]->surname}}
                    </div><br><br>
                    <div class="col-3" style="float:left">
                      <label for="rg">RG: </label> {{$supplier_pf[0]->rg}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="active_pf">Ativo: </label> @if ($supplier[0]->status == 0) Não @else Sim @endif
                    </div>
                    @endif
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosContato'); mudaImg('btnDadosContato')" id="btnDadosContato"></i></button></div>
                  <h5>Contato Principal</h5>
                  <div id="dadosContato" style="padding:0; margin: 0;">
                    <div class="col-6" style="float:left; padding:0; margin: 0;">
                      @foreach ($supplier_phones as $key => $value)
                      <div class="col-6" style="float:left">
                        <label for="telefone0">Telefone: </label> {{$value->tel}}
                      </div>
                      <div class="col-6" style="float:left">
                        <label for="tipo0">Tipo: </label> @if ($value->type == 'residential') Residencial @elseif ($value->type == 'commercial') Comercial @elseif ($value->type == 'cellphone') Celular @endif
                      </div>
                      @endforeach
                    </div>
                    <div class="col-6" style="float:left; padding:0; margin: 0;">
                    @if (count($supplier_emails))
                      @foreach ($supplier_emails as $key => $value)
                        <div class="col-6" style="float:left">
                          <label for="email0">Email:</label>
                          {{(isset($value->email)) ? $value->email : ''}}
                        </div>
                        <div class="col-6" style="float:left">
                          <label for="tipoEmail0">Tipo:</label> @if (isset($value->type) && $value->type == 'personal') Pessoal @elseif (isset($value->type) && $value->type == 'commercial') Comercial @elseif (isset($value->type) && $value->type == 'other') Outro @else - @endif <br><br>
                        </div>
                      @endforeach
                    @endif
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosContatosAdicionais'); mudaImg('btnDadosContatosAdicionais')" id="btnDadosContatosAdicionais"></i></button></div>
                  <h5>Contatos Adicionais</h5>
                  <div id="dadosContatosAdicionais">
                  @if (!count($supplier_contacts))
                    <div style="text-align:center" id="contatoAdicional1"><h6>NÃO HÁ CONTATOS ADICIONAIS</h6></div>
                  @else
                    @foreach ($supplier_contacts as $key => $value)
                    <div class="col-6" style="float:left; padding:0; margin:0"><label>Nome: </label> {{$value->name}}</div>
                    <div class="col-3" style="float:left; padding:0; margin:0"><label>Empresa: </label> {{$value->company}}</div>
                    <div class="col-3" style="float:left; padding:0; margin:0"><label>Cargo: </label> {{$value->office}}</div>
                    @if (count($value->phones))
                    <div class="col-6" style="float:left; padding:0; margin:0">
                      @foreach ($value->phones as $chave => $valor)
                      <div class="col-6" style="float:left; padding:0; margin:0"><label>Telefone: </label> {{$valor->tel}}</div>
                      <div class="col-6" style="float:left; padding:0; margin:0"><label>Tipo: </label> @if (isset($valor->type) && $valor->type == 'cellphone') Celular @elseif (isset($valor->type) && $valor->type == 'commercial') Comercial @elseif (isset($valor->type) && $valor->type == 'residential') Resildencial @else - @endif </div>
                      @endforeach
                    </div>
                    @endif
                    @if (count($value->emails))
                    <div class="col-6" style="float:left; padding:0; margin:0">
                      @foreach ($value->emails as $chave => $valor)
                      <div class="col-6" style="float:left; padding:0; margin:0"><label>Email: </label> {{$valor->email}}</div>
                      <div class="col-6" style="float:left; padding:0; margin:0"><label>Tipo: </label> @if (isset($valor->type) && $valor->type == 'personal') Pessoal @elseif (isset($valor->type) && $valor->type == 'commercial') Comercial @elseif (isset($valor->type) && $valor->type == 'other') Outro @else - @endif </div><br><br><br>
                      @endforeach
                    </div>
                    @endif
                    @endforeach
                  @endif
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosEndereco'); mudaImg('btnDadosEndereco')" id="btnDadosEndereco"></i></button></div>
                  <h5>Endereço</h5>
                  <div id="dadosEndereco">
                    <div class="col-3" style="float:left">
                      <label for="cep">CEP: </label> {{$supplier[0]->zip}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="address">Logradouro: </label> {{$supplier[0]->address}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="number">Número: </label> {{$supplier[0]->number}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="complement">Complemento:</label> {{$supplier[0]->complement}}
                    </div><br><br>                    
                    <div class="col-3" style="float:left">
                      <label for="neighborhood">Bairro: </label> {{$supplier[0]->neighborhood}}
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="referencia">Ponto de Referência:</label> {{$supplier[0]->referencia}}
                    </div>                    
                    <div class="col-3" style="float:left">
                      <label for="state">Estado: </label> {{$supplier[0]->state}}
                    </div>              
                    <div class="col-3" style="float:left">
                      <label for="city">Cidade: </label> {{$city[0]->name}}
                    </span>
                    </div><br><br><br>                
                    <div class="col-3" style="float:left">
                      <label for="condominio">É condomínio?: </label> @if ($supplier[0]->condominio == 0) Não @elseif ($supplier[0]->condominio == 1) Sim @endif
                    </div> 
                    <div id="condomoinioHTML" class="col-9" style="float:left">@if ($supplier[0]->condominio == 1) <div class="col-4" style="float:left"><label for="endereco">Endereço: </label> {{$supplier[0]->endereco}}</div>
                    <div class="col-4" style="float:left"><label for="numero">Número: </label> {{$supplier[0]->numero}}</div> @endif </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosObservacao'); mudaImg('btnDadosObservacao')" id="btnDadosObservacao"></i></button></div>
                  <h5>Observação</h5>
                  <div id="dadosObservacao">
                    <textarea name="observacao" id="observacao" disabled>{{$supplier[0]->obs}}</textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-danger" onclick="location.href='{{env('APP_URL')}}fornecedores'">&laquo; Voltar</button>
                </div>
            </div>
  @endsection