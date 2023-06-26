<?php
function enviarEmail($deEmail, $deNome, $paraEmail, $paraNome, $assunto, $mensagem){
    $urlEnvio = URL."enviaremail.php";
    // URL:
    $ch = curl_init($urlEnvio);
    // Obter retorno em $resultado:
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // -F
    // Definir como POST:
    curl_setopt($ch, CURLOPT_POST, true);
    // -F
    // Definir corpo, como multipart/form-data:
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'deEmail' => ($deEmail),
        'deNome' => ($deNome),
        'paraEmail' => ($paraEmail),
        'paraNome' => ($paraNome),
        'assunto' => ($assunto),
        'mensagem' => ($mensagem)
    ]);
    // -u
    $resultado = curl_exec($ch);
    curl_close ($ch);
    return $resultado;
}
function retiraAcentos($name){
    $caracteres_sem_acento = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Â'=>'Z', 'Â'=>'z', 'À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Å'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'Å'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
        'Ä'=>'a', 'î'=>'i', 'â'=>'a', 'È'=>'s', 'È'=>'t', 'Ä'=>'A', 'Î'=>'I', 'Â'=>'A', 'È'=>'S', 'È'=>'T', ' / '=>'-',
    );
    $nova_string = strtolower(strtr($name, $caracteres_sem_acento));
    return $nova_string;
}
function validaCPF($cpf) {
 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}
function validaCNPJ($cnpj = null) {
    // Verificar se foi informado
  if(empty($cnpj))
    return false;
  // Remover caracteres especias
  $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
  // Verifica se o numero de digitos informados
  if (strlen($cnpj) != 14)
    return false;
      // Verifica se todos os digitos são iguais
  if (preg_match('/(\d)\1{13}/', $cnpj))
    return false;
  $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);
    if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
        return false;
    }
    for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);
    if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
        return false;
    }
  return true;
}
?>
