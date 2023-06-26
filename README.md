Olá Pessoal da Vercan, sejam mais do que bem-vindos ao sistena de Teste do Henrique Marcandier.

O site completo pode ser baixado em https://www.bhcommerce.com.br/vercan.zip.

Baixem desse endereço pq aqui, não sei o pq, mas não vai todos os arquivos corretamente não.

Mas enfim, aí vcs baixam pra sua máquina aí e dezipem em uma pasta dentro do servidor web de vcs. Eu usei a pasta "vercan", mas vcs podem baixar pra qualquer pasta dentro do "htdocs" de vcs ou pasta similar.

Aí reparem que na raíz do projeto existe o arquivo "vercan.sql". Baixem esse arquivo dentro do mysqli de vcs, eu usei o bd "vercan", mas vcs podem usar o que desejarem aí.

Aí tem 2 arquivos que deve se configurar, visando o bom funcionamento do projeto. São eles, o '.env' da raíz da pasta, e o arquivo "connect.php" que está dentro da pasta "public", esse arquivo é para o funcionamento correto do ajax utilizado no site. Aí nesse arquivos tem as configuralçoes das pastas e do bd. Caso utilizem um nome diferente para a pasta e o bd é muito importante que se atentem na alteração das pastas e do bd.

Aí é só executar o projeto aí, no caminho "http://localhost/vercan/public", no meu caso. Se vocês utilizarem uma pasta diferente se atentem para alterar esse endereço nos arquivos ".env" e "connect.php" para o funcionamento correto do sistema. 

Eu mexi basicamente no arquivo "web.php", dentro da pasta "routes" e em alguns outros arquivos tbm, como por ex o "public/storage/scripts.js" e no "public/ajax.php", que contém todas os ajax utilizados no site.

Aí quando você se loga no sistema com o mesmo login e senha do sistema de vocês, vc vai na página inicial, que contém alguns gráficos que não tem nada haver com o sistema em si, é só pra vcs verem mesmo. Aí tem a página "Cadastros" => "Fornecedores" que é a página que vcs me solicitaram. Ela está bem completa e funcional também. Além disso, reparem que tem o Módulo de "Usuários", que nesse módulo contém 6 sub-menus lá, todos funcionais tbm. Reparem que tudo desse sistema funciona perfeitamente.

ah eh mesmo, eu não tinha feito a paginação lá. Mas agora está com tudo lá. Só ver aí e qualquer coisa só me falar. Foi adicionada o campo "Registros por página" no filtro lá da página. Aí tem 3 registros na base de dados que foi enviada a vocês. É só modificar o campo "Registros por Página", que começa com 15, para "2" ou "1" lá e fazer os testes. 

Espero que gostem.

Um Grande Abraço.

Henrique Marcandier
Desenvolvedor WEB
Belo Horizonte - 26/06/2023