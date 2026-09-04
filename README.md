# MindCare — Plataforma de Saude Mental

> Plataforma de saude mental para Angola — planos, consultas, acompanhamento psicologico e gestao de pacientes.

## Visao Geral

O MindCare e uma plataforma web completa para gestao de saude mental, composta por dois paineis:

- **Portal do Paciente** — Acesso a planos, consultas, ficha clinica, mensagens e documentos
- **Painel Profissional** — Gestao de pacientes, consultas, agenda, ficha clinica e mensagens
- **Painel Administrativo** — (repositorio separado: `MindCareao`)

### Stack Tecnico

| Componente | Tecnologia |
|------------|------------|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Tailwind 4, Vite 7, Blade |
| Base de Dados | MySQL (Host2Africa) |
| Hosting | Host2Africa (cPanel) |
| Dominio | https://mindcare.ao/ |

---

## Estrutura do Projecto

```
mindcare-deploy/
├── app/
│   ├── Http/Controllers/
│   │   ├── PortalController.php          # Portal do paciente
│   │   ├── ProfissionalController.php    # Painel do profissional
│   │   ├── ContactController.php         # Formulario de contacto
│   │   └── Concerns/HasMessaging.php     # Trait de messaging
│   ├── Models/
│   │   ├── Paciente.php                  # Modelo de paciente (com sinais vitais)
│   │   ├── Conversa.php                  # Modelo de conversa
│   │   └── ...
│   └── Mail/
│       └── ContatoMail.php               # Email de contacto
├── database/migrations/                  # Migrations da BD
├── resources/
│   ├── css/                              # CSS customizado
│   ├── views/
│   │   ├── portal/                       # Views do paciente
│   │   ├── profissional/                 # Views do profissional
│   │   ├── layouts/                      # Layouts principais
│   │   └── components/                   # Componentes Blade
│   └── js/                               # JavaScript
├── routes/
│   ├── web.php                           # Rotas principais
│   └── profissional.php                  # Rotas do profissional
├── css/chat-layout.css                   # CSS do chat
├── UI-chat.md                            # Documentacao do design do chat
├── .cpanel.yml                           # Deploy hook
└── index.php                             # Entry point (raiz)
```

---

## Funcionalidades

### Portal do Paciente

| Funcionalidade | Descricao |
|----------------|-----------|
| Dashboard | Visao geral de consultas, proxima consulta, profissional |
| Ficha Clinica | Dados pessoais, motivos, condicoes, medicacao |
| Sinais Vitais | Freq. cardiaca, pressao arterial, peso (visualizacao) |
| Mensagens | Chat em tempo real com profissional (polling 3s) |
| Documentos | Visualizacao de documentos clinicos |
| Consultas | Historico e estado das consultas |
| Perfil | Edicao de dados pessoais |

### Painel Profissional

| Funcionalidade | Descricao |
|----------------|-----------|
| Dashboard | Vista geral de pacientes, consultas pendentes |
| Pacientes | Lista, busca, ficha clinica de cada paciente |
| Ficha Clinica | Edicao de diagnostico, medicacao, historico, **sinais vitais** |
| Agenda | Gestao de consultas e estados |
| Mensagens | Chat com pacientes + "Nova Conversa" |
| Documentos | Upload e gestao de documentos |

### Sinais Vitais (Dados Clinicos)

Campos disponiveis na ficha do paciente:

| Campo | Tipo | Validacao | Quem edita |
|-------|------|-----------|------------|
| Freq. Cardiaca | INT | 30-250 bpm | Profissional |
| Pressao Sistolica | INT | 60-300 mmHg | Profissional |
| Pressao Diastolica | INT | 30-200 mmHg | Profissional |
| Peso | DECIMAL(5,2) | 1-500 kg | Profissional |

**Nota:** O paciente visualiza os valores na sua ficha, mas nao pode edita-los.

---

## Design System — Chat

O chat segue o padrao **Material Design 3** com classes Tailwind CSS.

### Estrutura

```
┌─────────────────────────────────────────────────────────┐
│  Section (flex h-full p-stack-md gap-stack-md)          │
│  ┌──────────────────┬──────────────────────────────────┐│
│  │ Sidebar (1/3)    │ Chat Area (2/3)                  ││
│  │ - Header         │ - Header (avatar, nome, status)  ││
│  │ - Lista de       │ - Mensagens (bg radial)          ││
│  │   conversas      │ - Input (anexo + texto + enviar) ││
│  └──────────────────┴──────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
```

### Componentes Principais

- **Sidebar** — Lista de conversas com avatar, nome, badge de nao lidas
- **Header** — Avatar, nome, status "Online agora", botoes de accao
- **Mensagens** — Background radial, bolhas sent/received, anexos
- **Input** — Caixa de texto, botao anexo, botao enviar

### Documentacao Completa

Ver `UI-chat.md` para documentacao detalhada do design (para implementacao no admin panel).

---

## Performance — Lazy Loading

### LCP (Largest Contentful Paint)

- **Elemento LCP:** Imagem hero do carrossel (`Consultoria2 - Cópia.jpg`)
- **Otimizacao:** `loading="eager" fetchpriority="high"` + `<link rel="preload">` no `<head>`

### Lazy Loading

- **60 imagens** actualizadas com `loading="lazy" decoding="async"`
- **Componente Blade:** `<x-lazy-image>` para padronizacao
- **Imagens hero:** Mantidas com `loading="eager"` (sem lazy)

### Uso do Componente

```blade
<!-- Lazy loading (padrao) -->
<x-lazy-image src="{{ asset('images/foto.jpg') }}" alt="Foto" class="w-full rounded" />

<!-- Eager loading (hero/topo) -->
<x-lazy-image src="{{ asset('images/hero.jpg') }}" alt="Hero" eager />
```

---

## Base de Dados

### Tabela `pacientes`

| Coluna | Tipo | Descricao |
|--------|------|-----------|
| id | BIGINT UNSIGNED | Primary key, auto increment |
| user_id | BIGINT UNSIGNED | FK para users |
| profissional_id | BIGINT UNSIGNED | FK para profissionais |
| motivo_consulta | TEXT | Motivo da consulta |
| condicoes | TEXT | Condicoes pre-existentes |
| diagnostico | TEXT | Diagnostico clinico |
| medicacao | TEXT | Medicacao geral |
| medicacao_atual | TEXT | Medicacao actual |
| observacoes | TEXT | Observacoes gerais |
| observacoes_profissional | TEXT | Observacoes do profissional |
| historico_familiar | TEXT | Historico familiar |
| plano_terapeutico | TEXT | Plano terapeutico |
| frequencia_cardiaca | INT | Freq. cardiaca (bpm) |
| pressao_sistolica | INT | Pressao sistolica (mmHg) |
| pressao_diastolica | INT | Pressao diastolica (mmHg) |
| peso | DECIMAL(5,2) | Peso actual (kg) |
| data_inicio | DATE | Data de inicio |
| preferencias | JSON | Preferencias do paciente |
| created_at | TIMESTAMP | Data de criacao |
| updated_at | TIMESTAMP | Data de actualizacao |
| deleted_at | TIMESTAMP | Soft delete |

### Comandos SQL (Sinais Vitais)

```sql
ALTER TABLE pacientes
ADD COLUMN frequencia_cardiaca INT NULL AFTER plano_terapeutico,
ADD COLUMN pressao_sistolica INT NULL AFTER frequencia_cardiaca,
ADD COLUMN pressao_diastolica INT NULL AFTER pressao_sistolica,
ADD COLUMN peso DECIMAL(5,2) NULL AFTER pressao_diastolica;
```

---

## Deploy

### Processo

1. Fazer `git push origin main`
2. O `.cpanel.yml` copia automaticamente os ficheiros para `/public_html/`
3. NAO executa `php artisan` — migrations devem ser executadas manualmente

### Apos Deploy

```bash
# No servidor (via SSH ou phpMyAdmin)
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Migration (se houver novas colunas)
php artisan migrate
```

### IMPORTANTE

- `build/` deve ficar na RAIZ do projecto (nao em `public/build/`)
- O `.env` NUNCA deve ser committado
- `ctx.md` e `memoria.md` estao em `.gitignore`

---

## Ambiente

### Variaveis de Ambiente (.env)

```env
APP_NAME=MindCare
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mindcare.ao/
DB_DATABASE=mindcare_devbd
DB_USERNAME=mindcare_devbd
DB_PASSWORD=...
MAIL_HOST=mail.mindcare.ao
MAIL_PORT=465
MAIL_USERNAME=noreply@mindcare.ao
MAIL_PASSWORD=...
```

### Servidor

| Item | Valor |
|------|-------|
| Hosting | Host2Africa (cPanel) |
| PHP | 8.2 (ea-php82) |
| Entry point | `index.php` na raiz |
| Document root | `/home/mindcare/public_html/` |

---

## Regras Importantes

1. **Nao modificar nada sem ordem explicita do utilizador**
2. Repositorio original (`MindCareao`) e apenas referencia
3. `.env` NUNCA deve ser committado ao git
4. `ctx.md` e `memoria.md` NUNCA devem ser committados
5. `.cpanel.yml` DEVE existir — sem ele, deploy nao funciona
6. Guardar contexto em `memoria.md` sempre que houver dialogo
7. Documentar problemas em `SISTEMA_1_PROBLEMAS_E_SOLUCOES.md`
