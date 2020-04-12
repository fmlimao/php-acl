# ACL PHP - Simples ACL em PHP para todos os projetos.

E quando eu digo simples, é simples mesmo!

## Instalação

    composer require fmlimao/php-acl

## Como usar

    $acl = new Fmlimao\Acl;

Basicamente, basta você associar um Papel a um Recurso e a um Privilégio no momento de dar a permissão ou
de remover a permissão:

    $acl->allow('Papel', 'Recurso', 'Privilégio');
    
    // ou
    
    $acl->deny('Papel', 'Recurso', 'Privilégio');

    
Também é possivel enviar um array em qualquer um dos três parâmetros:

    $acl->allow(['Papel 1', 'Papel 2'], ['Recurso 1', Recurso 2', Recurso 3'], ['Privilégio 1']);

    
Podemos passar `null` como valor em qualquer um dos parâmetros.

- Se o Papel for `null`, então os Recursos e seus Provilégios serão atribuidos a todos os Papeis.
- Se o Recurso for `null`, então os Privilégios serão dados a todos os Recursos.
- Se o Privilégio for `null`, então os Papeis terão todos os Privilégios deste Recurso.


    // Todos os Papeis terão esses Privilégios nestes Recursos.
    $acl->allow(null, ['products', 'categories'], ['list', 'update']);

    // O papel "admin" terá esses Privilégios em todos os Recursos
    $acl->allow('admin', null, ['create', 'delete']);
    
    // O papel "member" terá todos os Privilégios no recurso "orders"
    $acl->allow('member', 'orders', null);

    
E para verificar se tem ou não a permissão, basta chamar assim:

    $isAllowed = $acl->isAllowed('Papel', 'Recurso', 'Privilégio');


Aqui também é permitido passar arrays como parâmetros: 
    
    $isAllowed = $acl->isAllowed(['Papel 1', 'Papel 2'], ['Recurso 1', Recurso 2', Recurso 3'], ['Privilégio 1']);


Também é possível passar um array nos argumentos:

    $isAllowed = $acl->isAllowed(['Papel 1', 'Papel 2'], ['Recurso 1', Recurso 2', Recurso 3'], ['Privilégio 1']);
    

## Herança de Papeis

Os Papeis poderão estar vinculadas umas as outras, gerando uma herança entre elas.

    $acl = new Fmlimao\Acl;
    
    $acl->addRole('Papel 1');
    
    // Papel 2 é filho do Papel 1.
    $acl->addRole('Papel 2', 'Papel 1');
    
    // Papel 3 é filho do Papel 2.
    $acl->addRole('Papel 3', 'Papel 2');
    
    // Papel 4 é filho do Papel 3.
    $acl->addRole('Papel 4', 'Papel 3');
    
    $acl->allow('Papel 1', 'Recurso 1', 'Listar');
    $acl->allow('Papel 2', 'Recurso 1', 'Criar');
    $acl->allow('Papel 3', 'Recurso 1', 'Exibir');
    $acl->allow('Papel 4', 'Recurso 1', ['Alterar', 'Deletar']);
    $acl->deny('Papel 4', 'Recurso 1', 'Listar');
    
    $alloweds = [];
    
    // Retorna TRUE por causa do Papel 2.
    $alloweds[] = $acl->isAllowed('Papel 4', 'Recurso 1', 'Criar');
    
    // Retorna TRUE por causa do Papel 3.
    $alloweds[] = $acl->isAllowed('Papel 4', 'Recurso 1', 'Exibir');
    
    // Retorna TRUE por causa do próprio Papel 4.
    $alloweds[] = $acl->isAllowed('Papel 4', 'Recurso 1', 'Alterar');
    
    // Retorna FALSE pois nem o papel atual e nem seus pais tem esse privilégio.
    $alloweds[] = $acl->isAllowed('Papel 4', 'Recurso 1', 'Vincular');
    
    // Retorna FALSE. Apesar do Papel 1 ter esse privilégio, foi retirado do Papel 4
    $alloweds[] = $acl->isAllowed('Papel 4', 'Recurso 1', 'Listar');
    
    var_dump($alloweds);

