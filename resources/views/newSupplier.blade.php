@extends('master.layout')
@section('content')
<style>
#textarea {overflow:scroll; max-height:500px}
</style>
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
                <li class="breadcrumb-item active"><a href="{{env('APP_URL')}}usuario">Fornecedores</a></li>
            </ol>
            </div>
        </div>
    </div>
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cadastro de Fornecedor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{env('APP_URL')}}fornecedores/cadastrar" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosFornecedor'); mudaImg('btnDadosFornecedor')" id="btnDadosFornecedor"></i></button></div>
                  <h5>Dados do Fornecedor</h5>
                  <div id="dadosFornecedor">
                    <label for="tpForn">Tipo do Fornecedor: <span class="required"><sup>*</sup></span></label><br>
                    <input type="radio" name="tpForn" value="J" id="jur" onclick="selecionaTpForn('J', '{{env('APP_URL')}}')" checked> <label for="jur">Pessoa Juridica</label>
                    <input type="radio" name="tpForn" value="F" id="fis" onclick="selecionaTpForn('F', '{{env('APP_URL')}}')"> <label for="fis">Pessoa Fisica</label>
                    <br>
                    <div id="pessoa">
                    <div class="col-3" style="float:left">
                      <label for="cnpj">CNPJ: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Informe o cnpj do fornecedor..." onkeypress="formataCampo(this, '##.###.###/####-##', event);" onkeyup="verificaCnpj(this.value, '{{env('APP_URL')}}')" maxlength="18" required>
                    </div>
                    <div class="col-6" style="float:left">
                      <label for="razaoSocial">Razão Social: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" placeholder="Informe a razão social do fornecedor..." required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="nomeFantasia">Nome Fantasia: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" placeholder="Informe o nome fantasia do fornecedor..." required>
                    </div><br><br>
                    <div class="col-3" style="float:left">
                      <label for="indInscrEst">Indicador de Inscrição Estadual: <span class="required"><sup>*</sup></span></label>
                      <select class="form-control" id="indInscrEst" name="indInscrEst" required onchange="selecionaIndicadoInscrEst(this.value)">
                        <option value="">Selecione...</option>
                        <option value="contribuinte">Contribuinte</option>
                        <option value="contribuinte_isento">Contribuinte Isento</option>
                        <option value="nao_contribuinte">Não Contribuinte</option>
                      </select>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="inscrEst">Inscrição Estadual: <span class="required" id="obrigatorioInscrEst"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="inscrEst" name="inscrEst" placeholder="Informe a inscrição estadual do fornecedor..." required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="inscrMun">Inscrição Municipal:</label>
                      <input type="text" class="form-control" id="inscrMun" name="inscrMun" placeholder="Informe a inscrição municipal do fornecedor...">
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="status">Situação CNPJ:</label>
                      <input type="text" name="status" id="status" class="form-control" readonly="">
                    </div><br><br>
                    <div class="col-3" style="float:left">
                      <label for="gathering">Recolhimento:</label>
                      <select name="gathering" id="gathering" class="form-control not-required-cnpj" style="width: 100%" required>
                        <option value="">Selecione...</option>
                        <option value="recolher">A Recolher pelo Prestador</option>
                        <option value="retido">Retido pelo Tomador</option>
                      </select>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="active">Ativo: <span class="required"><sup>*</sup></span></label>
                      <select name="active" class="form-control" style="width: 100%" required>
                        <option value="">Selecione</option>
                        <option value="0">Não</option>
                        <option value="1" selected>Sim</option>
                      </select>
                    </div><br>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosContato'); mudaImg('btnDadosContato')" id="btnDadosContato"></i></button></div>
                  <h5>Contato Principal</h5>
                  <div id="dadosContato" style="padding:0; margin: 0;">
                  <div class="col-6" style="float:left; padding:0; margin: 0;">
                      <div class="col-6" style="float:left">
                        <label for="telefone0">Telefone: <span class="required"><sup>*</sup></span></label>
                        <input type="tel" name="telefone0" id="telefone0" class="form-control phone" required placeholder="Informe o telefone do fornecedor..." onkeypress="formataCampo(this, '(##)#####-####', event);"  maxlength="15">
                      </div>
                      <div class="col-6" style="float:left">
                        <label for="tipo0">Tipo: <span class="required"><sup>*</sup></span></label>
                        <select name="tipo0" id="tipo0" class="form-control" style="width: 100% !important" required><option value="">Selecione</option><option value="residential">Residencial</option><option value="commercial">Comercial</option><option value="cellphone">Celular</option></select>
                      </div>
                      <input type="hidden" value="0" name="qualEsta" id="qualEsta">
                      <span class="col-12"><a onclick="adicionarTelefone()" style="cursor:pointer">Adicionar</a></span>
                      <div class="col-12" id="telefoneAdicional1" style="padding:0; margin: 0;"></div>
                    </div>
                    <div class="col-6" style="float:left; padding:0; margin: 0;">
                      <div class="col-6" style="float:left">
                        <label for="email0">Email:</label>
                        <input type="email" name="email0" id="email0" class="form-control phone" placeholder="Informe o email do fornecedor..." >
                      </div>
                      <div class="col-6" style="float:left">
                        <label for="tipoEmail0">Tipo:</label>
                        <select name="tipoEmail0" id="tipoEmail0" class="form-control type-email" style="width: 100% !important"><option value="">Selecione</option><option value="personal">Pessoal</option><option value="commercial">Comercial</option><option value="other">Outro</option></select>
                      </div>
                      <input type="hidden" value="0" name="qualEstaEmail" id="qualEstaEmail">
                      <span class="col-12"><a onclick="adicionarEmail()" style="cursor:pointer">Adicionar</a></span>
                      <div class="col-12" id="emailAdicional1" style="padding:0; margin: 0;"></div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="col-12" style="text-align:right;"><a style="cursor:pointer" onclick="adicionaContato()">ADICIONAR</a></div>
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosContatosAdicionais'); mudaImg('btnDadosContatosAdicionais')" id="btnDadosContatosAdicionais"></i></button></div>
                  <h5>Contatos Adicionais</h5>
                  <div id="dadosContatosAdicionais">
                    <input type="hidden" name="contatosAdicionais" id="contatosAdicionais" value="1">
                    <div style="text-align:center" id="contatoAdicional1"><h6>NÃO HÁ CONTATOS ADICIONAIS</h6></div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosEndereco'); mudaImg('btnDadosEndereco')" id="btnDadosEndereco"></i></button></div>
                  <h5>Endereço</h5>
                  <div id="dadosEndereco">
                    <div class="col-3" style="float:left">
                      <label for="cep">CEP: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="cep" name="cep" placeholder="Informe o CEP do fornecedor..." onkeypress="formataCampo(this, '#####-###', event);" onkeyup="verificaCep(this.value, '{{env('APP_URL')}}')" maxlength="9" required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="address">Logradouro: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="Informe o logradouro do fornecedor..." required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="number">Número: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="number" name="number" placeholder="Informe o número do endereço do fornecedor..." required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="complement">Complemento:</label>
                      <input type="text" class="form-control" id="complement" name="complement" placeholder="Informe o complemento do endereço do fornecedor...">
                    </div><br><br>                    
                    <div class="col-3" style="float:left">
                      <label for="neighborhood">Bairro: <span class="required"><sup>*</sup></span></label>
                      <input type="text" class="form-control" id="neighborhood" name="neighborhood" placeholder="Informe o bairro do fornecedor..." required>
                    </div>
                    <div class="col-3" style="float:left">
                      <label for="referencia">Ponto de Referência:</label>
                      <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Informe a referência do endereço do fornecedor...">
                    </div>                    
                    <div class="col-3" style="float:left">
                      <label for="state">Estado: <span class="required"><sup>*</sup></span></label>
                      <select class="form-control" id="state" name="state" required onchange="selecionaEstado(this.value, '{{env('APP_URL')}}')">
                        <option value="">UF</option>
                        @foreach ($states as $key => $value)
                        <option value="{{$value->uf}}">{{$value->uf}}</option>
                        @endforeach
                      </select>
                    </div>              
                    <div class="col-3" style="float:left">
                      <label for="city">Cidade: <span class="required"><sup>*</sup></span></label>
                      <span id="cidades">
                      <select class="form-control" id="cidade" name="cidade" required>
                        <option value="">Selecione o estado corretamente...</option>
                      </select>
                    </span>
                    </div><br><br>                
                    <div class="col-3" style="float:left">
                      <label for="condominio">É condomínio?: <span class="required"><sup>*</sup></span></label>
                      <select class="form-control" id="condominio" name="condominio" required onchange="selecionaCondomínio(this.value, '{{env('APP_URL')}}')">
                        <option value="">Selecione</option>
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                      </select>
                    </div> 
                    <div id="condomoinioHTML" class="col-9" style="float:left"></div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="box-tools pull-right" style="position:absolute; float: left; left:95%"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa bt-plus fa-minus" onclick="abreFecha('dadosObservacao'); mudaImg('btnDadosObservacao')" id="btnDadosObservacao"></i></button></div>
                  <h5>Observação</h5>
                  <div id="dadosObservacao">
                    <textarea name="observacao" id="observacao"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
                  <button type="button" class="btn btn-danger" onclick="location.href='{{env('APP_URL')}}fornecedores'">&laquo; Voltar</button>
                </div>
              </form>
            </div>
  @endsection