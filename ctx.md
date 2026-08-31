# MindCare - Contextualização do Projeto

## Visão Geral

O **MindCare** é uma plataforma de saúde mental online, desenvolvida em Laravel, que conecta pacientes a profissionais de psicologia/psiquiatria. O sistema permite agendamento de consultas, gestão de planos de subscrição, mensagens, documentos clínicos e um chatbot de apoio.

---

## Arquitetura: Dois Projetos, Mesmo Banco

O sistema foi **dividido em 2 repositórios** para hospedagem separada, mas ambos consomem o **mesmo banco de dados MySQL**.

### 1. Projeto Original — `MindCareao`
- **Caminho**: `C:\Users\JORGE DANGE\Documents\Github\MindCareao`
- **Laravel**: 11.x
- **Pacotes**: Breeze (auth), Reverb (WebSockets), Google2FA, ActivityLog, BaconQRCode
- **Contém**: Tudo — Portal Paciente, Portal Profissional, **Admin Panel completo**
- **Status**: Código fonte completo, referência para funcionalidades

### 2. Projeto Deploy — `mindcare-deploy`
- **Caminho**: `C:\Users\JORGE DANGE\Documents\Github\mindcare-deploy`
- **Laravel**: 12.x
- **Pacotes**: Google2FA, ActivityLog, BaconQRCode (**sem Breeze, sem Reverb**)
- **Contém**: Portal Paciente, Portal Profissional (**sem Admin Panel**)
- **Status**: Em produção, funcional para pacientes e profissionais

> **Regra**: Não alterar nada no deploy sem ordem explícita. O original é referência.

---

## Stack Tecnológica

| Componente | Tecnologia |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade + Tailwind CSS + Material Symbols |
| Banco | MySQL (partilhado entre os dois projetos) |
| Auth | Custom (sem Breeze no deploy) |
| 2FA | pragmarx/google2fa-laravel |
| Chatbot | Ollama / Gemini (via API) |
| Broadcast | Reverb (original) / Log (deploy) |
| Queue | Database |
| Session | File |
| Activity Log | spatie/laravel-activitylog |

---

## Modelo de Dados (Tabelas Principais)

```
users
  ├── id, name, email, password, role (paciente|profissional|admin)
  ├── telefone, telefone_alt, data_nascimento, genero, bi_numero
  ├── morada, provincia, foto_perfil
  ├── two_factor_secret, two_factor_confirmed_at
  └── deleted_at (SoftDeletes)

profissionais
  ├── id, user_id (FK → users)
  ├── especialidade, registro_profissional, bio
  ├── areas_actuacao (JSON), activo
  └── SoftDeletes

pacientes
  ├── id, user_id (FK → users)
  ├── profissional_id (FK → profissionais) — profissional atribuído
  ├── motivo_consulta, condicoes, diagnostico, medicacao
  ├── medicacao_atual, observacoes, observacoes_profissional
  ├── historico_familiar, plano_terapeutico
  ├── data_inicio, preferencias (JSON)
  └── SoftDeletes

planos
  ├── id, nome, slug, publico (individual|familia|empresa)
  ├── descricao, sessoes_total, preco, moeda
  ├── beneficios (JSON), activo

plano_subscricoes
  ├── id, paciente_id (FK), plano_id (FK)
  ├── sessoes_usadas, data_inicio, data_validade
  └── estado (Activo|Pendente|Cancelado|Expirado)

consultas
  ├── id, paciente_id (FK), profissional_id (FK)
  ├── data, hora, modalidade (online|presencial)
  ├── tipo (Individual|Casal|Familiar|Avaliação Inicial|Grupo)
  ├── estado (Agendada|Confirmada|Realizada|Cancelada|Faltou)
  ├── confirmada (bool), link_videocall, observacoes
  └── SoftDeletes

pagamentos
  ├── id, paciente_id (FK), plano_id (FK)
  ├── plano_subscricao_id (FK)
  ├── valor, moeda, metodo, estado (Pendente|aprovado|recusado|Pago|Cancelado)
  ├── data_pagamento, referencia, comprovativo_path
  ├── aprovado_por (FK → users), aprovado_em, notas_admin

conversas
  ├── id, paciente_id (FK), profissional_id (FK)
  ├── contacto, iniciais
  └── (profissional_id = null → conversa de suporte/admin)

mensagens
  ├── id, conversa_id (FK), remetente_id (FK → users)
  ├── texto, lida (bool), anexo_path

documentos
  ├── id, paciente_id (FK), partilhado_por (FK → users)
  ├── nome, tipo, categoria, descricao
  ├── caminho, tamanho, novo (bool)
  └── SoftDeletes

notifications (Laravel built-in)
activity_log (Spatie)
```

---

## Rotas e Portais

### Rotas Públicas (`web.php`)
```
GET  /                    → Home
GET  /sobre               → Sobre
GET  /servicos            → Serviços
GET  /planos              → Planos
GET  /planos/particular   → Planos Particulares
GET  /planos/familiar     → Planos Familiares
GET  /planos/corporativo  → Planos Corporativos
GET  /faq                 → FAQ
POST /chatbot/enviar      → Chatbot (throttle: 10/min)
```

### Portal Paciente (`/portal`) — middleware: auth, verified, role:paciente, 2fa
```
GET  /portal/dashboard
GET  /portal/perfil       → PUT /portal/perfil
GET  /portal/consultas    → POST /portal/consultas
PUT  /portal/consultas/{id}/confirmar
PUT  /portal/consultas/{id}/cancelar
PUT  /portal/consultas/{id}/reagendar
GET  /portal/documentos
GET  /portal/documentos/{id}/download
GET  /portal/documentos/{id}/preview
GET  /portal/mensagens    → POST /portal/mensagens
GET  /portal/mensagens/{conversa}/novas (polling)
GET  /portal/plano
POST /portal/plano/aderir
POST /portal/plano/trocar
GET  /portal/ficha        → PUT /portal/ficha
GET  /portal/notificacoes
GET  /portal/notificacoes/nao-lidas
POST /portal/notificacoes/{id}/ler
POST /portal/notificacoes/ler-todas
```

### Portal Profissional (`/profissional`) — middleware: auth, verified, role:profissional, 2fa
```
GET  /profissional/dashboard
GET  /profissional/agenda
POST /profissional/consultas
PUT  /profissional/consultas/{id}/estado
GET  /profissional/pacientes
GET  /profissional/pacientes/{id}
GET  /profissional/pacientes/{id}/ficha → PUT
GET  /profissional/documentos
POST /profissional/documentos
GET  /profissional/documentos/{id}/download
GET  /profissional/mensagens → POST /profissional/mensagens
GET  /profissional/mensagens/{conversa}/novas
GET  /profissional/perfil
```

### Admin Panel (`/admin`) — **SÓ NO PROJETO ORIGINAL**
```
Rotas em routes/admin.php
Prefixo configurável via ADMIN_PREFIX (default: /cc/Kjadjd8272849JANDMA8284)
Middleware: auth, verified, role:admin, 2fa

GET  /admin/dashboard
GET  /admin/pesquisa (JSON global)
CRUD /admin/utilizadores
CRUD /admin/profissionais
CRUD /admin/pacientes (+ exportar CSV)
CRUD /admin/planos
     /admin/pagamentos (index, show, aprovar, recusar)
     /admin/subscricoes (index, show, store, exportar)
     /admin/consultas (index, store, confirmar, cancelar, faltou, exportar)
     /admin/mensagens (index, start, store, novas)
     /admin/relatorios/financeiro
     /admin/relatorios/consultas
     /admin/audit-log
     /admin/configuracoes
```

---

## Autenticação e Rotas de Auth (`routes/auth.php`)

```
GET/POST /register              → RegisteredUserController
GET/POST /login                 → AuthenticatedSessionController
GET/POST /forgot-password       → PasswordResetLinkController
GET/POST /reset-password/{token} → NewPasswordController
GET    /verify-email            → EmailVerificationPromptController
GET    /verify-email/{id}/{hash} → VerifyEmailController
POST   /email/verification-notification
GET/POST /confirm-password      → ConfirmablePasswordController
PUT    /password                → PasswordController
POST   /logout
```

**Diferença crítica**: O deploy NÃO tem Breeze — o scaffolding de auth é customizado.

---

## 2FA (Two-Factor Authentication)

### Configuração
- Pacote: `pragmarx/google2fa-laravel`
- Tabela: colunas `two_factor_secret`, `two_factor_confirmed_at` na tabela `users`

### Rotas
```
GET  /2fa/ativar       → Formulário de ativação
POST /2fa/ativar       → Confirmar ativação (validar QR code)
GET  /2fa/verificar    → Formulário de verificação
POST /2fa/verificar    → Validar código 6 dígitos
DELETE /2fa/desativar  → Desativar 2FA
```

### Middleware `TwoFactorAuth`

**Projeto Original** (`MindCareao`):
```php
// Apenas redireciona para verificação se JÁ ativou 2FA
if ($user->two_factor_confirmed_at && !session('2fa_verificado')) {
    return redirect()->route('2fa.verificar');
}
// NÃO força ativação para ninguém
```

**Projeto Deploy** (`mindcare-deploy`):
```php
// Mesmo que o original, MAS também:
if ($user->role === 'admin' && !$user->two_factor_confirmed_at) {
    return redirect()->route('2fa.ativar');  // FORÇA admin a ativar
}
```

> **Implicação**: O deploy bloqueia admin até configurar 2FA. O original não faz isso.

### Middleware CheckRole
```php
// Verifica se o user autenticado tem o role necessário
// Usado como: middleware('role:paciente'), middleware('role:profissional'), etc.
```

---

## Models e Relações

### User
- `hasOne` → Paciente
- `hasOne` → Profissional
- Helpers: `isPaciente()`, `isProfissional()`, `isAdmin()`
- Accessor: `iniciais` (primeiras 2 letras do nome)
- SoftDeletes

### Paciente
- `belongsTo` → User
- `belongsTo` → Profissional (atribuído)
- `hasMany` → Consultas, Documentos, Conversas, Pagamentos, PlanoSubscricoes
- `hasOne` → SubscricaoActiva (subscrição com estado=Activo)
- SoftDeletes

### Profissional
- `belongsTo` → User
- `hasMany` → Pacientes, Consultas
- Tabela: `profissionais`
- SoftDeletes

### Consulta
- `belongsTo` → Paciente
- `belongsTo` → Profissional
- Estados: Agendada → Confirmada → Realizada | Cancelada | Faltou
- SoftDeletes

### PlanoSubscricao
- `belongsTo` → Paciente, Plano
- Métodos: `ativa()`, `esgotada()`, `sessoesDisponivel()`
- Estados: Activo, Pendente, Cancelado, Expirado

### Pagamento
- `belongsTo` → Paciente, Plano, PlanoSubscricao, User (aprovadoPor)
- Estados: Pendente → aprovado → Pago | recusado | Cancelado

### Conversa
- `belongsTo` → Paciente, Profissional
- `hasMany` → Mensagens
- **Se `profissional_id = null`** → conversa de suporte (Admin/Paciente)

### Mensagem
- `belongsTo` → Conversa
- `belongsTo` → User (remetente)
- Campos: texto, lida, anexo_path

### Documento
- `belongsTo` → Paciente, User (partilhadoPor)
- SoftDeletes

---

## Controllers Principais (Deploy)

### PortalController
- Gerencia todo o portal do paciente
- Usa trait `HasMessaging` para mensagens
- Método `getPaciente()` — cria paciente automaticamente se não existir
- Validação de subscrição antes de agendar consultas
- Validação de slot único (`UniqueConsultaSlot`)

### ProfissionalController
- Gerencia todo o portal do profissional
- Usa trait `HasMessaging` para mensagens
- Método `getProfissional()` — carrega profissional autenticado
- Ao marcar consulta como "Realizada":
  - Incrementa `sessoes_usadas` na subscrição
  - Gera relatório de sessão (TXT) automaticamente
  - Cria registro na tabela `documentos`

### HasMessaging (Trait)
- Compartilhado entre PortalController e ProfissionalController
- Métodos: `mensagens()`, `storeMensagem()`, `novasMensagens()`
- Marca mensagens como lidas automaticamente
- Usa eventos `NovaMensagem` e `MensagemLida` para broadcasting

---

## Controllers Admin (Só no Original)

### AdminController
- Dashboard com métricas (pacientes, profissionais, consultas, receita)
- Pesquisa global (utilizadores, pacientes, profissionais)
- Audit Log com filtros

### PagamentoAdminController
- **Aprovar pagamento**: Usa DB::transaction
  - Ativa subscrição pendente
  - Desativa subscrições anteriores (se troca de plano)
  - Envia notificação `PagamentoAprovado`
  - Regista activity log
- **Recusar pagamento**: Envia notificação `PagamentoRecusado`

### ConsultaAdminController
- CRUD completo de consultas pelo admin
- Exportação CSV
- Gestão de estados (confirmar, cancelar, falta)

### MensagemAdminController
- Suporte: conversas com `profissional_id = null`
- Inicia conversa de suporte para qualquer paciente

### RelatorioController
- Financeiro: receita por plano, por método, evolução mensal
- Consultas: por estado, por profissional, tendência

---

## Services (Chatbot)

### Interface
```php
// App\Services\Contracts\AiServiceInterface
public function chat(string $mensagem, array $historico = []): string;
```

### Implementações
- **OllamaService** — Usa API do Ollama (modelo `gpt-oss:120b`)
- **GeminiService** — Usa API do Google Gemini

### System Prompt
- Arquivo: `app/Services/SystemPrompt.php`
- Define o comportamento do chatbot como assistente de saúde mental

### Configuração
```
CHATBOT_DRIVER=ollama|gemini
OLLAMA_URL, OLLAMA_MODEL, OLLAMA_API_KEY
GEMINI_API_KEY
```

---

## Notificações

| Notificação | Canal | Quando |
|---|---|---|
| `ConsultaConfirmada` | database | Profissional confirma consulta |
| `NovoDocumento` | database | Profissional envia documento |
| `PagamentoAprovado` | database | Admin aprova pagamento |
| `PagamentoRecusado` | database | Admin recusa pagamento |
| `SubscricaoAExpirar` | database | Subscrição prestes a expirar |

---

## Políticas (Authorization)

| Policy | Métodos |
|---|---|
| `PacientePolicy` | view, update, viewFicha, updateFicha |
| `DocumentoPolicy` | view, create, delete |
| `ConsultaPolicy` | view, create, update, delete, updateEstado |
| `PagamentoPolicy` | (não verificada) |

**Regra geral**: Admin acede a tudo. Profissional acede aos seus pacientes/pacientes. Paciente acede aos seus dados.

---

## Rate Limiting

```php
RateLimiter::for('uploads', fn() => Limit::perMinute(10));
RateLimiter::for('mensagens', fn() => Limit::perMinute(30));
Route::post('/chatbot/enviar', ...)->middleware('throttle:10,1');
```

---

## Variáveis de Ambiente Importantes

```env
# App
APP_NAME=MindCare
APP_ENV=production|local
ADMIN_PREFIX=/cc/Kjadjd8272849JANDMA8284

# Database (partilhado)
DB_CONNECTION=mysql
DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Auth
SESSION_DRIVER=file
SESSION_DOMAIN=.SEU-DOMINIO.AQUI

# Broadcast (Reverb no original)
BROADCAST_CONNECTION=reverb|log
REVERB_APP_ID, REVERB_APP_KEY, REVERB_APP_SECRET

# Chatbot
CHATBOT_DRIVER=ollama|gemini
OLLAMA_URL, OLLAMA_MODEL, OLLAMA_API_KEY
GEMINI_API_KEY

# Bank
BANK_IBAN, BANK_HOLDER, BANK_ACCOUNT_NUMBER, BANK_SWIFT
```

---

## Diferenças Chave: Original vs Deploy

| Feature | Original (MindCareao) | Deploy (mindcare-deploy) |
|---|---|---|
| Laravel | 11.x | 12.x |
| Breeze | Sim | **Não** |
| Reverb | Sim | **Não** |
| Admin Panel | **Completo** | **Ausente** |
| Auth scaffolding | Breeze | Custom |
| 2FA force admin | Não | Sim |
| Broadcasting | reverb | log |
| Queue | database | sync (no dev) |
| Session | file | file |
| Layouts | admin, portal, profissional | portal, profissional |
| Views admin | 12 pastas/views | Nenhuma |

---

## Pendências para Estabilização do Deploy

1. **Admin Panel** — Não existe. Precisa ser criado ou migrado do original.
2. **Autenticação (Breeze)** — Deploy não tem Breeze. Auth é customizado, pode ter gaps.
3. **Reverb/WebSockets** — Deploy não tem. Mensagens usam polling HTTP.
4. **Middleware 2FA** — Deploy força 2FA para admin. Decidir se mantém ou alinha ao original.
5. **Relatórios** — Sem admin, não há relatórios financeiros ou de consultas.
6. **Gestão de Pagamentos** — Sem admin, pagamentos não podem ser aprovados/recusados.
7. **Gestão de Subscrições** — Sem admin, subscrições não podem ser geridas.
8. **Configurações** — Sem admin, dados bancários/clínica não podem ser alterados.

---

## Comandos Úteis

```bash
# Setup
composer setup          # Instala dependências, gera key, migra, builda assets

# Dev (todos os serviços)
composer dev            # serve + queue + pail + vite

# Migrações
php artisan migrate
php artisan migrate:fresh --seed

# Seeders
php artisan db:seed      # DatabaseSeeder (Plano, Admin, Profissional, Paciente)

# Cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Activity Log
php artisan activitylog:clean
```

---

## Estrutura de Pastas (Deploy)

```
mindcare-deploy/
├── app/
│   ├── Console/
│   ├── Events/              # NovaMensagem, MensagemLida
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/        # Breeze controllers (custom)
│   │   │   ├── Concerns/    # HasMessaging trait
│   │   │   ├── Portal/      # NotificacaoController
│   │   │   ├── ChatbotController.php
│   │   │   ├── PortalController.php
│   │   │   ├── ProfissionalController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── PublicController.php
│   │   │   └── TwoFactorController.php
│   │   ├── Middleware/       # CheckRole, TwoFactorAuth, SecurityHeaders
│   │   └── Requests/
│   ├── Mail/
│   ├── Models/              # 10 models
│   ├── Notifications/       # 5 notificações
│   ├── Policies/            # 4 policies
│   ├── Providers/           # AppServiceProvider
│   ├── Rules/               # UniqueConsultaSlot
│   ├── Services/            # OllamaService, GeminiService, SystemPrompt
│   └── View/
├── config/
│   ├── mindcare.php         # Dados bancários
│   └── ... (12 configs)
├── database/
│   ├── migrations/          # 24 migrations
│   └── seeders/             # 6 seeders
├── resources/views/
│   ├── layouts/             # app, guest, navigation, portal, profissional
│   ├── portal/              # 9 views
│   ├── profissional/        # 7 views (+ subpastas)
│   ├── auth/                # views de auth
│   └── components/          # componentes Blade
├── routes/
│   ├── web.php              # Públicas + Portal
│   ├── profissional.php     # Portal profissional
│   └── auth.php             # Autenticação
└── .env
```

---

*Documento gerado em 2026-08-31 para contextualização do projeto MindCare.*
