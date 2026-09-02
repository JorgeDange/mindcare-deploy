# MindCare - Problemas Detetados e Soluções (Sistema 1)

> Este documento documenta todos os problemas encontrados durante o deploy e configuração do Sistema 1 (Portal de Pacientes + Portal de Profissionais) no Host2Africa cPanel, bem como as soluções aplicadas. Serve como referência para futuros problemas semelhantes.

---

## 1. Ambiente

| Item | Detalhe |
|------|---------|
| **Servidor** | Host2Africa cPanel |
| **PHP** | 8.2 |
| **Banco de Dados** | MySQL (`mindcare_devbd`) |
| **Document Root** | `/home/mindcare/public_html/` (é a raiz do projeto) |
| **Repo** | GitHub → cPanel Git Deployment |
| **URL** | https://mindcare.ao/ |
| **Laravel** | 12 |
| **Sem SSH** | Não é possível executar `php artisan` no servidor |

### Restrições Importantes
- Não existe acesso SSH ao servidor
- Deploy é feito via git push (cPanel auto-deploy com `.cpanel.yml`)
- Alterações na DB devem ser feitas via phpMyAdmin (SQL direto)
- Variáveis de ambiente (`APP_KEY`, `DB_*`) são geridas pelo utilizador no `.env`

---

## 2. Problema: Erro 500 "Please provide a valid cache path"

### Sintoma
Todas as páginas retornavam erro 500. No `storage/logs/laravel.log`:
```
LogicException: Please provide a valid cache path.
at vendor/laravel/framework/src/Illuminate/View/Compilers/Compiler.php:75
```

### Causa
As pastas de cache do Laravel (`storage/framework/views/`, `storage/framework/cache/`, etc.) **não existiam no servidor**. O Git não rastreia pastas vazias, e o deploy não as criava automaticamente.

### Solução (3 partes)

#### 2.1 Criar `.gitkeep` nas pastas de storage
Adicionar arquivos `.gitkeep` (vazios) nas pastas para o Git as rastrear:

```
storage/framework/views/.gitkeep
storage/framework/cache/.gitkeep
storage/framework/cache/data/.gitkeep
storage/sessions/.gitkeep
storage/logs/.gitkeep
```

#### 2.2 Atualizar `.gitignore`
Adicionar exceções para os `.gitkeep` no `.gitignore`:

```gitignore
/storage/framework/views/*
!/storage/framework/views/.gitkeep
/storage/framework/cache/*
!/storage/framework/cache/.gitkeep
!/storage/framework/cache/data/
/storage/framework/cache/data/*
!/storage/framework/cache/data/.gitkeep
/storage/sessions/*
!/storage/sessions/.gitkeep
/storage/logs/*
!/storage/logs/.gitkeep
```

#### 2.3 Criar diretórios no `bootstrap/app.php`
**Porque o deploy pode falhar em criar as pastas a tempo**, adicionar criação automática no `bootstrap/app.php` **antes** de `Application::configure()`:

```php
$storageDirs = [
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/framework/cache',
    __DIR__.'/../storage/framework/cache/data',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/logs',
];
foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}
```

**Porquê aqui?** Porque o Blade compiler tenta aceder ao cache path logo no arranque — se as pastas não existirem quando a config é carregada, o erro já dispara. A criação no `bootstrap/app.php` garante que existem antes de qualquer config ser lida.

### Verificação
No phpMyAdmin, o log deve começar a escrever erros novos (em vez do erro "cache path"). No File Manager, verificar que as pastas existem.

---

## 3. Problema: Deploy não executava após push

### Sintoma
Commits eram enviados para o GitHub mas o servidor continuava com código antigo. O `laravel.log` continuava a mostrar os mesmos timestamps de erro antigos.

### Causa
O ficheiro `.cpanel.yml` (que define as tarefas de deploy do cPanel) tinha sido **apagado** durante uma sessão anterior. Sem ele, o cPanel não executa nada quando o repositório é atualizado.

### Solução
Recriar o `.cpanel.yml` na raiz do projeto:

```yaml
---
deployment:
  tasks:
    - export DEPLOYPATH=/home/mindcare/public_html/
    - /bin/cp -R * $DEPLOYPATH
```

**Nota:** O `cp -R *` copia todos os ficheiros do repo para o `public_html/`. Como a raiz do repo É o `public_html/`, isto atualiza os ficheiros no local. Não inclui `.env` porque este está no `.gitignore`.

### Lição
Nunca apagar o `.cpanel.yml` sem替代 (substituir) mecanismo de deploy. Se o `.cpanel.yml` for removido, o push ao git não faz nada no servidor.

---

## 4. Problema: users.id sem AUTO_INCREMENT

### Sintoma
Ao tentar registar um novo utilizador:
```
SQLSTATE[HY000]: 1364 Field 'id' doesn't have a default value
```

### Causa
A tabela `users` foi criada manualmente no phpMyAdmin (sem migrations) e o campo `id` ficou como `bigint(20) UNSIGNED NOT NULL` **sem** `AUTO_INCREMENT`.

### Solução
No phpMyAdmin → SQL:
```sql
ALTER TABLE `users` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
```

### Lição
Quando se criam tabelas manualmente no phpMyAdmin, sempre definir `AUTO_INCREMENT` no campo `id` principal.

---

## 5. Problema: Tabela profissionais sem registros

### Sintoma
Ao aceder ao dashboard do profissional:
```
403
Perfil profissional não encontrado.
```

### Causa
O `RegisteredUserController` cria utilizadores com `role = 'paciente'` e automaticamente cria o registo na tabela `pacientes`. Mas para `role = 'profissional'`, **não existe fluxo de registo automático** — o perfil profissional tem que ser criado manualmente na base de dados.

O `ProfissionalController::getProfissional()` (linha 34) faz:
```php
$this->profissional = Auth::user()->loadMissing('profissional')->profissional;
abort_if(! $this->profissional, 403, 'Perfil profissional não encontrado.');
```

Se não existir registo em `profissionais` com o `user_id` correspondente, retorna 403.

### Solução
No phpMyAdmin, primeiro verificar o ID do profissional:
```sql
SELECT id, name, email, role FROM users WHERE role = 'profissional';
```

Depois inserir o registo em `profissionais`:
```sql
INSERT INTO profissionais (user_id, especialidade, registro_profissional, bio, activo, created_at, updated_at)
VALUES
(2, 'Psicologia Clínica', 'OP 1234', 'Psicóloga clínica', 1, NOW(), NOW()),
(3, 'Psicologia Clínica', 'OP 5678', 'Psicóloga clínica', 1, NOW(), NOW());
```

### Estrutura da tabela `profissionais` (migration)
```php
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->string('especialidade');
$table->string('registro_profissional')->nullable();
$table->text('bio')->nullable();
$table->json('areas_actuacao')->nullable();
$table->boolean('activo')->default(true);
$table->softDeletes();
$table->timestamps();
```

### Lição
Quando se criam utilizadores com `role = 'profissional'` diretamente na DB, sempre criar também o registo correspondente na tabela `profissionais`.

---

## 6. Problema: Storage paths incorretos

### Sintoma
Ficheiros guardados não eram encontrados, ou uploads de foto de perfil não funcionavam.

### Solução aplicada em `config/filesystems.php`
O disco `public` foi configurado para usar `public_path('storage')`:
```php
'public' => [
    'driver' => 'local',
    'root' => public_path('storage'),
    ...
],
```

Isto garante que os ficheiros guardados no disco `public` ficam em `/home/mindcare/public_html/storage/`, acessíveis via URL.

---

## 7. Problema: Falta de colunas na tabela profissionais

### Sintoma
O `PortalController::updatePerfil()` tentava guardar `bi_numero` e `preferencias`, mas estes campos não existiam na tabela `users` ou `pacientes`.

### Solução
Colunas adicionadas manualmente no phpMyAdmin. A `users` table precisa de:
- `bi_numero` (nullable)
- `morada` (nullable)
- `provincia` (nullable)
- `telefone_alt` (nullable)
- `foto_perfil` (nullable)
- `data_nascimento` (nullable)
- `genero` (nullable)
- `two_factor_confirmed_at` (nullable)
- `two_factor_secret` (nullable)
- `two_factor_recovery_codes` (nullable, text)

A tabela `pacientes` precisa de:
- `deleted_at` (nullable, soft deletes)
- `motivo_consulta` (nullable)
- `condicoes` (nullable)
- `medicacao` (nullable)
- `observacoes` (nullable)
- `preferencias` (nullable, json)
- `bi_numero` (nullable) — se guardado no paciente em vez do user

A tabela `profissionais` precisa de:
- `deleted_at` (nullable, soft deletes)
- `activo` (boolean, default true)

---

## 8. Proteção de Ficheiros Sensíveis

### `.gitignore` — ficheiros ignorados
```gitignore
.env              # Credenciais de banco de dados, APP_KEY, etc.
ctx.md            # Contexto do projeto com credenciais
memoria.md        # Documentação interna com dados sensíveis
```

### Nunca committar
- `.env` — contém `APP_KEY`, `DB_PASSWORD`, `MAIL_*`, etc.
- `ctx.md` — contém credenciais e dados sensíveis do projeto
- `memoria.md` — contém documentação interna com dados que não devem ser públicos

Se algum destes ficheiros for committado acidentalmente:
```bash
git rm --cached ctx.md memoria.md
git commit -m "Remove sensitive files from tracking"
git push
```

**Nota:** Isto remove do tracking mas mantém os ficheiros localmente. Para remover do histórico completo, seria necessário `git filter-branch` (não recomendado para repositórios partilhados).

---

## 9. Estrutura de Rotas

### Rotas Públicas
| Método | URI | Controller |
|--------|-----|-----------|
| GET | `/` | `PublicController@home` (view `welcome`) |
| GET | `/sobre` | `PublicController@sobre` |
| GET | `/servicos` | `PublicController@servicos` |
| GET | `/planos` | `PublicController@planos` |
| GET | `/faq` | `PublicController@faq` |
| POST | `/chatbot/enviar` | `ChatbotController@send` |
| POST | `/contacto` | `ContactController@store` |

### Portal do Paciente (middleware: `auth`, `verified`, `role:paciente`, `2fa`)
| Método | URI | Controller |
|--------|-----|-----------|
| GET | `/portal/dashboard` | `PortalController@dashboard` |
| GET | `/portal/perfil` | `PortalController@perfil` |
| PUT | `/portal/perfil` | `PortalController@updatePerfil` |
| GET | `/portal/consultas` | `PortalController@consultas` |
| POST | `/portal/consultas` | `PortalController@storeConsulta` |
| GET | `/portal/documentos` | `PortalController@documentos` |
| GET | `/portal/plano` | `PortalController@plano` |
| GET | `/portal/ficha` | `PortalController@ficha` |
| PUT | `/portal/ficha` | `PortalController@updateFicha` |

### Portal do Profissional (middleware: `auth`, `verified`, `role:profissional`, `2fa`)
| Método | URI | Controller |
|--------|-----|-----------|
| GET | `/profissional/dashboard` | `ProfissionalController@dashboard` |
| GET | `/profissional/agenda` | `ProfissionalController@agenda` |
| GET | `/profissional/perfil` | `ProfissionalController@perfil` |
| GET | `/profissional/pacientes` | `ProfissionalController@pacientes` |
| GET | `/profissional/documentos` | `ProfissionalController@documentos` |

---

## 10. Ficheiros Modificados (commits principais)

| Commit | Descrição |
|--------|-----------|
| `6c4aff7` | Bootstrap fix — criação de diretórios storage antes da config |
| `6503cb5` | Atualização da memória.md com documentação |
| `e7e3fba` | Restauração do `.cpanel.yml` para auto-deploy |
| `1e3e747` | Adição de `ctx.md` e `memoria.md` ao `.gitignore` |

---

## 11. Checklist para Novo Deploy / Migração

Se o sistema voltar a dar erro 500 após deploy:

1. **Verificar `.cpanel.yml` existe** na raiz do repo
2. **Verificar pastas de storage** no File Manager:
   - `storage/framework/views/`
   - `storage/framework/cache/`
   - `storage/framework/cache/data/`
   - `storage/sessions/`
   - `storage/logs/`
3. **Verificar `bootstrap/app.php`** tem a criação automática de diretórios
4. **Verificar `.env`** está presente no servidor com credenciais corretas
5. **Verificar `laravel.log`** — se não se cria, falta a pasta `storage/logs/`
6. **Verificar tabela `users`** — campo `id` deve ser `AUTO_INCREMENT`
7. **Verificar tabela `profissionais`** — todo profissional com `role = 'profissional'` na `users` deve ter registo correspondente

---

## 12. Comandos Úteis (phpMyAdmin)

### Verificar estrutura de uma tabela
```sql
DESCRIBE profissionais;
```

### Verificar registros de profissionais
```sql
SELECT u.id, u.name, u.email, p.id as prof_id, p.especialidade
FROM users u
LEFT JOIN profissionais p ON p.user_id = u.id
WHERE u.role = 'profissional';
```

### Corrigir AUTO_INCREMENT
```sql
ALTER TABLE `users` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `pacientes` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
```

### Criar registo profissional faltante
```sql
INSERT INTO profissionais (user_id, especialidade, registro_profissional, bio, activo, created_at, updated_at)
SELECT id, 'Psicologia Clínica', 'OP 0000', 'Perfil profissional', 1, NOW(), NOW()
FROM users WHERE id = X AND role = 'profissional';
```

### Backup rápido de uma tabela
```sql
CREATE TABLE users_backup AS SELECT * FROM users;
```

---

*Documento gerado em 2026-09-02. Atualizar conforme novos problemas forem resolvidos.*
