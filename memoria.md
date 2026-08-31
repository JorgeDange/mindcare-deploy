# Memoria de Projeto — MindCare Deploy

> Ultima actualizacao: 31 Agosto 2026

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
- Host: `srv2-lad.host2africa.ao`
- Port: 465 (SSL)
- User: `noreply@mindcare.ao`
- Password: `WD=hX+Wu0@%w;98Z`

---

## 3. Historico de Alteracoes

### Feito

1. **Analise do projecto** — Criado `ctx.md` com documentacao completa
2. **Formulario de contacto** — `ContactController.php`, `ContatoMail.php`, `contact.blade.php`, rota `POST /contacto` com throttle (5/min), formulario actualizado em `welcome.blade.php`
3. **Limpeza de InfinityFree** — 98+ ficheiros de cache Blade eliminados, `laravel.log` limpo, `info.php` eliminado
4. **Correccao do Vite manifest** — `build/` na raiz do projecto (nao em `public/build/`)
5. **AllowOverride activado** — Suporte do Host2Africa activou `mod_rewrite` + `AllowOverride All`
6. **Mensagem de suporte** — Enviada em português ao Host2Africa para activar AllowOverride

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
```

---

## 4. Estado Actual

### Onde paramos AGORA

| Item | Estado |
|---|---|
| AllowOverride | ✅ ACTIVO (suporte activou, site ja da 500 em vez de "Index of /") |
| .htaccess | ✅ Correcto e a ser processado |
| build/ | ✅ Na raiz do projecto |
| .env | ❌ VAZIO — eliminado do git no commit 86169a9 |
| .env.example | ❌ VAZIO — limpo no commit bae2268 |
| Site | ❌ Erro 500 (por causa do .env vazio) |
| SMTP | ⚠️ Pendente — 535 Incorrect authentication data |
| build/ no servidor | ⚠️ Pode ainda ter public/build/ no servidor |

### O .env que FALTA (do commit 66566cf)

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
MAIL_HOST=srv2-lad.host2africa.ao
MAIL_PORT=465
MAIL_USERNAME=noreply@mindcare.ao
MAIL_PASSWORD=WD=hX+Wu0@%w;98Z
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

1. **Restaurar o .env** — Repor o conteudo do .env (copiar do commit 66566cf)
2. **Nao committar .env ao git** — Manter .env no .gitignore (ja estava)
3. **Fazer push** — Enviar .env restaurado para o servidor
4. **No servidor:** Executar `php artisan view:clear && php artisan cache:clear`
5. **Verificar build/ no servidor** — Confirmar que build/ esta na raiz (nao public/build/)
6. **Eliminar public/build/ no servidor** se ainda existir
7. **Testar site** — Deveria carregar a pagina principal
8. **Testar formulario de contacto**
9. **Resolver SMTP** — Verificar credenciais de noreply@mindcare.ao (erro 535)

---

## 6. Regras Importantes

- **Nao modificar nada sem ordem explicita do utilizador**
- Repositorio original (`MindCareao`) e apenas referencia
- `build/` deve ficar na RAIZ do projecto (nao em `public/build/`)
- O servidor NAO suporta `public/` como directorio publico — a raiz IS o directorio publico
- **.env NUNCA deve ser committado ao git** — usar .gitignore
- Guardar contexto em memoria.md sempre que houver dialogo

---

## 7. Ficheiros Relevantes

| Ficheiro | Descricao |
|---|---|
| `index.php` | Entry point do Laravel (raiz) |
| `.htaccess` | Regras de rewrite Apache |
| `.cpanel.yml` | Configuracao de deploy automatico |
| `build/manifest.json` | Manifest Vite pre-compilado |
| `.env` | Configuracao completa do projecto (NAO committar) |
| `.env.example` | Template do .env (vazio) |
| `ctx.md` | Documentacao completa do projecto |
| `memoria.md` | Este ficheiro — memoria de contexto |
| `app/Http/Controllers/ContactController.php` | Controller do formulario |
| `app/Mail/ContatoMail.php` | Mailable |
| `resources/views/emails/contact.blade.php` | Template do email |
| `routes/web.php` | Rota de contacto (linha 22) |

---

## 8. Notas Tecnicas

### Porque o build/ esta na raiz e nao em public/build/
O servidor da Host2Africa tem o document root como `/home/cpsess9742955477/public_html/`. O `index.php` esta na raiz do projecto. O `vite.config.js` faz output para `public/build` por padrao, mas como a raiz e o directorio publico, os assets devem estar em `build/` na raiz para serem acessiveis via `/build/assets/...`.

### Porque o .env nao pode ir ao git
O .env contem password da base de dados, APP_KEY e credenciais SMTP. Deve ficar apenas no servidor, nunca no repositorio.
