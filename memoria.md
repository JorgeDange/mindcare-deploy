# Memoria de Projeto — MindCare Deploy

> Ultima actualizacao: 2 Setembro 2026

---

## 1. Visao Geral do Projeto

- **Repositorio:** `C:\Users\JORGE DANGE\Documents\Github\mindcare-deploy`
- **Branch:** `main`
- **Framework:** Laravel 12
- **Dominio:** https://mindcare.ao/
- **Tipo:** Plataforma de saude mental (dois repositorios, mesma base de dados MySQL)

### Repositorio original (referencia, nao alterar)
- `C:\Users\JORGE DANGE\Documents\Github\MindCareao` (Laravel 11, com Admin Panel)

---

## 2. Ambiente de Producao

| Item | Valor |
|---|---|
| Hosting | Host2Africa (cPanel) |
| Path do servidor | `/home/cpsess9742955477/public_html/` |
| public_path() | `/home/mindcare/public_html/` |
| PHP | 8.2 (ea-php82) |
| Entry point | `index.php` na RAIZ (nao em `public/`) |
| Document root | A raiz DO projecto e o directorio publico |
| Deploy | `.cpanel.yml` — copia tudo para `/public_html/` |

### Base de Dados
- DB_CONNECTION=mysql
- DB_HOST=localhost
- DB_PORT=3306
- DB_DATABASE=mindcare_devbd
- DB_USERNAME=mindcare_devbd
- DB_PASSWORD=mindcare@otimize

### SMTP
- Host: `mail.mindcare.ao`
- Port: 465 (SSL)
- User: `noreply@mindcare.ao`
- Password: `yQ#d+=#@rogyN!pu` (precisa de aspas no .env por causa do #)

---

## 3. Historico de Alteracoes

### Feito

1. **Analise do projecto** — Criado `ctx.md` com documentacao completa
2. **Formulario de contacto** — `ContactController.php`, `ContatoMail.php`, `contact.blade.php`, rota `POST /contacto` com throttle (5/min), formulario actualizado em `welcome.blade.php`
3. **Limpeza de InfinityFree** — 98+ ficheiros de cache Blade eliminados, `laravel.log` limpo, `info.php` eliminado
4. **Correccao do Vite manifest** — `build/` na raiz do projecto (nao em `public/build/`)
5. **AllowOverride activado** — Suporte do Host2Africa activou `mod_rewrite` + `AllowOverride All`
6. **Mensagem de suporte** — Enviada em português ao Host2Africa para activar AllowOverride
7. **Colunas em falta nas tabelas** — Adicionadas via phpMyAdmin: `deleted_at`, `created_at`, `updated_at` em `pacientes` e `profissionais`; `activo` em `profissionais`; `activo`, `created_at`, `updated_at` em `planos`
8. **Correccao de `pacientes.id`** — Tornada `PRIMARY KEY AUTO_INCREMENT`
9. **Correccao do `PortalController::updatePerfil`** — Agora guarda `bi_numero` e `preferencias` no perfil do profissional
10. **Correccao do filesystem config** — `config/filesystems.php`: public disk root mudado de `storage_path('app/public')` para `public_path('storage')`
11. **Correccao do cache path (bootstrap)** — Directories de storage criados em `bootstrap/app.php` **antes** do config ser carregado — resolve o timing do `Please provide a valid cache path`
12. **`.gitignore` actualizado** — Excepcoes `.gitkeep` para `storage/framework/views`, `cache`, `cache/data`, `sessions`, `logs`
13. **`.gitkeep` criados** — Directories de storage trackeados pelo git
14. **`.cpanel.yml` eliminado** — Deploy via git push (hooks do cPanel), nao mais via ficheiro de deploy

### Commits relevantes

```
86169a9 Merge branch 'main' — eliminou .env e .env.example do git
bb16bfb Delete info.php
bae2268 Clear .env.example of environment variable settings
63de4cb Update .env
4756ca0 removido relacioanamento com hosting antigo (moveu build/ de volta para raiz)
f3b5153 alteracao dos arquivos de public (moveu build/ para public/build/)
66566cf update email corrigido em $data
28e3398 updagre email send
24db399 nova atualizacao
600e14f fix: create storage subdirectories and set permissions on deploy
6c4aff7 fix: create storage directories in bootstrap before config loads to prevent cache path error
```

---

## 4. Estado Actual

### Onde paramos AGORA

| Item | Estado |
|---|---|
| AllowOverride | ✅ ACTIVO (suporte activou, site ja da 500 em vez de "Index of /") |
| .htaccess | ✅ Correcto e a ser processado |
| build/ | ✅ Na raiz do projecto |
| .env | ✅ Restaurado pelo utilizador (nao committado) |
| .cpanel.yml | ✅ Eliminado (deploy via git push) |
| Cache path | ✅ CORRIGIDO — directories criados em `bootstrap/app.php` antes do config |
| Site | ⚠️ Ainda 500 — `users.id` falta AUTO_INCREMENT |
| SMTP | ✅ ACTIVO — mail.mindcare.ao:465, testado e funcional |
| DB tables | ✅ Pacientes, profissionais, planos com todas as colunas |
| users.id | ❌ FALTA AUTO_INCREMENT — registro de utilizadores falha |

### Erro actual: `users.id` sem AUTO_INCREMENT

A tabela `users` foi criada manualmente no phpMyAdmin com o `id` como `INT UNSIGNED NOT NULL` **sem AUTO_INCREMENT**. Quando alguem tenta registar-se, dá:

```
SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value
```

**Correccao (phpMyAdmin > SQL):**
```sql
ALTER TABLE `users` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
```

### O .env que FALTA (do commit 66566cf)

> NOTA: O .env ja foi restaurado pelo utilizador. Esta seccao fica como referencia.

```env
APP_NAME=MindCare
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mindcare.ao/
APP_KEY=base64:WKmwIxHoRLnEah5z8n9s3OHAh56EBnVwo2a+q25iPTY=
APP_TIMEZONE=UTC
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
FAKER_LOCALE=pt_PT

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=mindcare_devbd
DB_USERNAME=mindcare_devbd
DB_PASSWORD=mindcare@otimize

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_COOKIE=mindcare_portal_session
SESSION_DOMAIN=.mindcare.ao

CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=mail.mindcare.ao
MAIL_PORT=465
MAIL_USERNAME=noreply@mindcare.ao
MAIL_PASSWORD="yQ#d+=#@rogyN!pu"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@mindcare.ao"
MAIL_FROM_NAME="MindCare"

GEMINI_API_KEY=
OLLAMA_URL=https://ollama.com/
OLLAMA_MODEL=gpt-oss:120b
OLLAMA_API_KEY=aa92a5e20db147caadef6a9c16940130.Fa4e-BA-i_j1uE61KPKHiN4a

CHATBOT_DRIVER=ollama
```

---

## 5. Proximos Passos

1. **Corrigir `users.id` no phpMyAdmin** — `ALTER TABLE users MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;`
2. **Testar registo** — Criar novo utilizador em https://mindcare.ao/register
3. **Testar login** — Entrar no portal com credenciais criadas
4. **Testar perfil** — Verificar que `bi_numero` e `preferencias` sao guardados
5. **Testar upload de foto** — Verificar que a foto aparece no perfil
6. **Verificar logs** — Confirmar que nao ha mais erros de cache path
7. **Limpar log** — `TRUNCATE TABLE laravel_log;` ou apagar `storage/logs/laravel.log` pelo cPanel

---

## 6. Regras Importantes

- **Nao modificar nada sem ordem explicita do utilizador**
- Repositorio original (`MindCareao`) e apenas referencia
- `build/` deve ficar na RAIZ do projecto (nao em `public/build/`)
- O servidor NAO suporta `public/` como directorio publico — a raiz IS o directorio publico
- **.env NUNCA deve ser committado ao git** — usar .gitignore
- **.cpanel.yml NAO existe mais** — deploy e via git push (hooks cPanel)
- Guardar contexto em memoria.md sempre que houver dialogo
- **Storage directories** sao criados em `bootstrap/app.php` antes do config — necessario porque `storage_path()` retorna path que o servidor nao tem

---

## 7. Ficheiros Relevantes

| Ficheiro | Descricao |
|---|---|
| `index.php` | Entry point do Laravel (raiz) |
| `bootstrap/app.php` | Cria storage dirs ANTES do config — corrige cache path error |
| `.htaccess` | Regras de rewrite Apache |
| `build/manifest.json` | Manifest Vite pre-compilado |
| `.env` | Configuracao completa do projecto (NAO committar) |
| `.env.example` | Template do .env (vazio) |
| `ctx.md` | Documentacao completa do projecto |
| `memoria.md` | Este ficheiro — memoria de contexto |
| `app/Http/Controllers/ContactController.php` | Controller do formulario |
| `app/Http/Controllers/PortalController.php` | Perfil do profissional (`updatePerfil`) |
| `app/Providers/AppServiceProvider.php` | Regras de acesso e policies |
| `app/Mail/ContatoMail.php` | Mailable |
| `resources/views/emails/contact.blade.php` | Template do email |
| `resources/views/portal/perfil.blade.php` | Formulario de perfil |
| `routes/web.php` | Rotas principais |
| `config/filesystems.php` | Public disk corrigido para `public_path('storage')` |
| `.gitignore` | Excepcoes `.gitkeep` para storage |

---

## 8. Notas Tecnicas

### Porque o build/ esta na raiz e nao em public/build/
O servidor da Host2Africa tem o document root como `/home/cpsess9742955477/public_html/`. O `index.php` esta na raiz do projecto. O `vite.config.js` faz output para `public/build` por padrao, mas como a raiz e o directorio publico, os assets devem estar em `build/` na raiz para serem acessiveis via `/build/assets/...`.

### Porque o .env nao pode ir ao git
O .env contem password da base de dados, APP_KEY e credenciais SMTP. Deve ficar apenas no servidor, nunca no repositorio.

### Porque o cache path dava erro (resolvido em 2026-09-02)
O `config/cache.php` usa `storage_path('framework/cache/data')`. No servidor, os directories de storage nao existem porque o git so trackeia `.gitkeep` (ficheiros vazios, nao directorios). O `AppServiceProvider::boot()` criava as pastas, mas o config e avaliado ANTES do boot — por isso o `CacheManager` falhava.

**Solucao:** Criar directories em `bootstrap/app.php` com `mkdir` antes de `$app = Application::configure(...)`. Isto garante que existem antes do config ser carregado.

### Users.id sem AUTO_INCREMENT
A tabela `users` foi criada manualmente no phpMyAdmin sem `AUTO_INCREMENT` no `id`. Qualquer tentativa de INSERT falha com `Field 'id' doesn't have a default value`. Corrigir com:
```sql
ALTER TABLE `users` MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
```
