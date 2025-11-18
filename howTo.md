# Criar páginas

  De início, note a existência de um template, modelo, este modelo não é para ser copiado,  
toda página é carregada dentro dele, substituindo \<!-- Main Content --\>, ou seja, só  
precisarás fazer o que realmente será característico da página, importante, veja como é  
o molde para maior compreensão.  
  Em teses o molde se baseia para as trẽs seções principais da página, a página base, o estilo  
base a ser aplicado e as funções básicas de carregamento dinâmico de conteúdo. É esperado que  
nestes não sejam necessárias alterações, sendo evitadas ao máximo.

## 1. Do HTML

  A criação das páginas html deve ser pura, havendo somente html, referências para arquivos  
scripts (js e funções) ou folhas de estilo (css e estilização inline) devem ser feitas  
externamente (veja: 2. Referências).  
  Este não deve conter as seguintes tags, por já serem contidas no template ou já terem sido  
utilizadas (tags semânticas): 
* doctype;
* html;
* head;
* body;
* header;
* main;
* footer.
  Para fazer a página considere que toda estrutura está pronta (está) para focar apenas no conteúdo  
que será necessário, exemplo:
Invés de:
```
<html>
    <head>
        ...
    </head>
    <body>
        <header> ... </header>
        <main>
            <p> chamados abertos: </p>
            ...
        </main>
        <footer> ... </footer>
    </body>
</html>
```
Faça apenas:
```
<p> chamados abertos: </p>
...
```
## 2. Do CSS

  A criação das folhas de estilo serão feitas de maneira normal, com diferença de uso de cores  
de acordo com as variáveis definidas no css padrão.  

## 3. Do JS

  A criação de scripts seguirá uma regra simples, criação de blocos de funções com funcionalidades  
específicas, uma função que irá chamá-las ou ligá-las a um elemento html, e ao fim chamar essa final  
exemplo:
```
function a() {
    ...
}
function b() {
    ...
} 
function c() {
    element.addEventListener('click', () => {a();});
    b();
}
c();
```

## 4. Referências

  As referências a arquivos externos ao HTML deverão ser feitas de dois modos, para folhas de  
estilo e scripts, pela sua adição no arquivo em assets/data/app/pageAssets.json, e para imagens  
e outros arquivos será feito via scripts.  
  As referências do pageAssets serão feitas da seguinte forma, apenas escrevendo o nome do  
arquivo (sem extensão) na página e campo específico, exemplo:
ARQUIVO ANTES DA ADIÇÂO:
```
{
    "default": {
        ...
    },
    "chat": {
        "title": "chat",
        "css": [],
        "js": []
    }
}
```
ARQUIVO DEPOIS DA ADIÇÃO
```
{
    "default": {
        ...
    },
    "chat": {
        "title": "chat",
        "css": ["chat"],
        "js": ["AIIntegration"]
    
}
```
  Já as feitas via script serão feitas usando o caminho absoluto do arquivo, fornecido por uma  
das funções padrões já programadas do molde (javascript padrão), como exemplo:
```
function putImage() {
    let img = document.getElementById('logoImage');
    img.src = absoluteUrl('../assets/img/logo.png');
}
```

## 5. Interação com os dados (Backend)

  A forma como serão pegos os dados do "servidor", arquivos de documento, serão feitas por chamadas  
fetch a arquivos .php (já desenvolvidos) que irão solicitar esses dados e retornar uma resposta
contendo um objeto com os delimitados campos, exemplo de uso:
```
async function hideLoggedOptions() {
    let response = await fetch(absoluteUrl('src/backend/control/getAcess.php')); // Fazer a requisição de dados.
    let userAcess = await response.json(); // Traduzir os dados para json, objeto.
    if (!userAcess.logged) {
        let loggedOptions = document.querySelectorAll('.logged');
        loggedOptions.forEach(element => {
            element.style.display = 'none';
        });
    }
}
```
  Caso haja necessidade de parâmetros a serem oferecidos ao arquivo .php será este feito da seguinte  
maneira:
* Dado ao absolute url uma string com o caminho do arquivo, seguido de uma interrogação, o nome do  
parâmetro e o valor a ser dado, no caso de mais de um parâmetro requerido devem estes ser separados  
pelo e comercial, &.
* Nota, uma boa prática é encapsular os valores de entrada na função encodeURIComponent, para evitar  
problemas ao passar caracteres especiais pela url.
* absoluteUrl('src/backend/control/ARQUIVO.php?PARÂMETRO1=VALOR1&PARÂMETRO2=VALOR2');
* Ex.: absoluteUrl('src/backend/control/getUser.php?mail=usuario@gmail.com')
* Ex.: absoluteUrl('src/backend/control/login.php?mail=usuario@gmail.com&password=aluno123&according=1')
* Estes parâmetros e o tipo de valor esperado estará especificado dentro do arquivo .php como comentário  
nas primeiras linhas, tal qual a formação do seu objeto de saída.
* Ex.:
```
function login() {
    let mail = encodeURIComponent(document.getElementById('mail').value);
    let pass = encodeURIComponent(document.getElementById('pass').value);
    let okay = encodeURIComponent(document.getElementById('privacyPolicyCheckbox').value);

    fetch(absoluteUrl(`src/backend/control/login.php?mail=${mail}&pass=${pass}&according=${okay}`));
}
```
