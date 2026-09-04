# PROMPT_MASTER — Implementação de Lazy Loading (Laravel)

## Objectivo
Reduzir o tempo de carregamento do site Laravel implementando lazy loading para imagens, iframes e componentes pesados, sem quebrar o layout ou o SEO existente.

## Contexto do projecto
- Framework: Laravel (Blade templates)
- Stack front-end: HTML/CSS/JS (indicar se usa Vite/Mix, Tailwind, Bootstrap, etc.)
- Problema actual: tempo de carregamento elevado, possivelmente relacionado com imagens/recursos não optimizados

## Tarefas a executar

### 1. Auditoria inicial
- Percorrer todas as views Blade (`resources/views/**/*.blade.php`) e identificar:
  - Todas as tags `<img>` sem atributo `loading`
  - Todos os `<iframe>` (mapas, vídeos embutidos, etc.)
  - Imagens de fundo (`background-image`) carregadas via CSS que estejam fora do viewport inicial
- Listar o resultado antes de alterar código.

### 2. Lazy loading nativo (prioridade)
- Adicionar `loading="lazy"` a todas as tags `<img>` que **não** estejam no viewport inicial (ex: não aplicar à imagem de topo/hero, que deve continuar `loading="eager"` ou sem atributo).
- Adicionar `loading="lazy"` a todos os `<iframe>` (mapas, YouTube, etc.).
- Adicionar `decoding="async"` às imagens lazy para não bloquear o thread principal.

Exemplo:
```blade
<img src="{{ asset('images/produto.jpg') }}" loading="lazy" decoding="async" alt="Descrição">
```

### 3. Componente Blade reutilizável (opcional, recomendado)
Criar um componente Blade `<x-lazy-image>` para padronizar o uso em todo o projecto:

```php
// resources/views/components/lazy-image.blade.php
@props(['src', 'alt' => '', 'class' => ''])

<img src="{{ $src }}" alt="{{ $alt }}" loading="lazy" decoding="async" class="{{ $class }}">
```

Uso:
```blade
<x-lazy-image src="{{ asset('images/foto.jpg') }}" alt="Foto do produto" class="w-full rounded" />
```

### 4. Optimização de imagens (complementar ao lazy loading)
- Verificar se as imagens em `public/images` ou `storage/app/public` estão em formatos modernos (WebP/AVIF) e comprimidas.
- Se necessário, sugerir o uso do pacote `spatie/laravel-image-optimizer` ou conversão manual para WebP.
- Não avançar com isto sem confirmação — é uma tarefa separada do lazy loading.

### 5. Lazy loading de componentes/secções pesadas (JS, se aplicável)
Se existirem secções pesadas (carrosséis, mapas interactivos, widgets de terceiros) que só devem carregar quando visíveis, usar Intersection Observer em vanilla JS:

```javascript
document.addEventListener('DOMContentLoaded', () => {
  const lazySections = document.querySelectorAll('[data-lazy-section]');

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        if (el.dataset.src) el.src = el.dataset.src;
        el.classList.add('loaded');
        obs.unobserve(el);
      }
    });
  }, { rootMargin: '100px' });

  lazySections.forEach(el => observer.observe(el));
});
```

### 6. Validação final
- Confirmar visualmente que nenhuma imagem/iframe quebrou o layout.
- Confirmar que a imagem principal (hero/topo) continua a carregar imediatamente (sem lazy).
- Testar em DevTools > Network que os recursos fora do viewport só carregam ao dar scroll.
- Não alterar lógica de backend, rotas ou controllers — esta tarefa é estritamente front-end/Blade.

## Restrições
- Não usar frameworks JS adicionais (jQuery, bibliotecas de lazy loading de terceiros) — usar apenas JS vanilla e o atributo nativo `loading="lazy"`.
- Não alterar a estrutura das views além do necessário para adicionar os atributos/componente.
- Manter compatibilidade com o restante do design actual.

## Entregável
Lista de ficheiros Blade alterados + confirmação de que todas as imagens/iframes fora do viewport inicial usam `loading="lazy"`.