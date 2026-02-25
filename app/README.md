# Instalando composer
[Composer Documentação](https://getcomposer.org/)

```
Instalar o composer
> Use o instalador se estiver usando XAMPP

> Provavelmente na finalização da instalação o instalador deve apresentar algo assim:
    > PHP version 8.x.x
    > Proxy: xxxx
    > Add to System path:
        > C:\ProgramData\ComposerSetup\bin
    > Remove from System path:
        > C:\xampp\php
> Vamos adicionar novamente o caminho C:\xampp\php ao sistema

> Pressionar Win + R
    > Digitar: sysdm.cpl
    > Avançado -> Variáveis de Ambiente
        > Em variáveis do sistema, encontre:
            > Path
                > Editar
                    > Novo
                        > C:\xampp\php
                        > Clique em OK em tudo

> Feche:
    > PowerShell
    > VS Code
    > Qualquer terminal aberto
    > Abra novamente o PowerShell.

> Teste PHP primeiro:
    > php -v

> Teste composer:
    > composer -V
    > Validar o ambiente:
        > composer diagnose
            
```
# Variaveis de ambiente
```
> cd [DIRETÓRIO_RAIZ_DO_PROJETO]
    > Ex.: C:\xampp\htdocs\5_estudando_php\app
> Rodar comando no terminal:
    > composer require vlucas/phpdotenv
> Estrutura:
    5_estudando_php/
    └── app/
        ├── vendor/
        ├── .env
        ├── composer.json
        ├── composer.lock
        ├── index.php
        └── conexao.php

> Criar arquivo .env
    > DB_HOST=localhost
    > DB_USER=root
    > DB_PASS=1234
        > IMPORTANTE: Não pode haver espaços nem comentários nos valores

> Adicionar em diretório conexao.php
    > $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    > $dotenv->load();

> Testar:
    echo var_dump($_ENV);

