# Laravel UI Kit

Blade-first UI components for Laravel. Includes a full set of atoms, molecules, organisms, and templates with Tailwind + Alpine.

## Install

```bash
composer require chriskelemba/laravel-ui-kit
```

No publishing required. Components, Alpine, and the bundled UI Kit stylesheet are auto-registered.

## Usage

### Hyphenated tags (recommended)

```blade
<x-ui-kit-button>Primary</x-ui-kit-button>
<x-ui-kit-input name="email" placeholder="you@example.com" />
<x-ui-kit-modal title="Confirm">
    <x-slot:trigger>
        <x-ui-kit-button>Open</x-ui-kit-button>
    </x-slot:trigger>
    Modal content here.
</x-ui-kit-modal>
```

### Namespaced tags

```blade
<x-ui-kit::atoms.button>Primary</x-ui-kit::atoms.button>
<x-ui-kit::atoms.input name="email" />
```

## Component Inventory

### Atoms

- `ui-kit-button`
- `ui-kit-input`
- `ui-kit-action-button`
- `ui-kit-badge`
- `ui-kit-avatar`
- `ui-kit-tag`
- `ui-kit-divider`

### Molecules

- `ui-kit-form-field`
- `ui-kit-modal`
- `ui-kit-alert`
- `ui-kit-toast`
- `ui-kit-tooltip`
- `ui-kit-popover`
- `ui-kit-dropdown`
- `ui-kit-tabs`
- `ui-kit-breadcrumb`
- `ui-kit-pagination`
- `ui-kit-steps`
- `ui-kit-toggle`
- `ui-kit-checkbox`
- `ui-kit-radio-group`
- `ui-kit-select`
- `ui-kit-textarea`
- `ui-kit-date-input`
- `ui-kit-file-upload`
- `ui-kit-search-bar`
- `ui-kit-filter-chips`
- `ui-kit-sort-control`

### Organisms

- `ui-kit-form`
- `ui-kit-auth-form`
- `ui-kit-panel`
- `ui-kit-table`
- `ui-kit-stat-card`
- `ui-kit-primary-rail`
- `ui-kit-sidebar`
- `ui-kit-line-chart`
- `ui-kit-bar-chart`
- `ui-kit-pie-chart`
- `ui-kit-calendar`
- `ui-kit-drawer`
- `ui-kit-empty-state`
- `ui-kit-progress`
- `ui-kit-skeleton`
- `ui-kit-section-header`
- `ui-kit-timeline`
- `ui-kit-activity-list`
- `ui-kit-task-list`

### Templates

- `ui-kit-app-shell`
- `ui-kit-dashboard`
- `ui-kit-crud-page`
- `ui-kit-resource-index`
- `ui-kit-context-shell`
- `ui-kit-auth-page`

## Config (optional)

You can publish config and views if you want to customize:

```bash
php artisan vendor:publish --tag=ui-kit-config
php artisan vendor:publish --tag=ui-kit-views
```

## Theming

UI Kit supports per-project brand theming through config, so different consumers can use different color schemes without editing package views.

Publish the config:

```bash
php artisan vendor:publish --tag=ui-kit-config
```

Then set your project colors in `config/ui-kit.php`:

```php
'theme' => [
    'colors' => [
        'primary' => '#ec4899',
        'primary_hover' => '#db2777',
        'primary_soft' => 'rgba(236, 72, 153, 0.14)',
        'primary_contrast' => '#ffffff',
        'accent' => '#f9a8d4',
    ],
],
```

If you use the package layout, theme styles load automatically.

If you use your own app layout, add this once inside `<head>`:

```blade
<x-ui-kit-theme />
```

Then package components like `primary` buttons, active steps, charts, progress bars, sidebars, and focus states will use your project colors automatically.

## Icon Aliases

Navigation-style components can resolve simple icon names to Font Awesome automatically.

```php
[
    'label' => 'Navigation',
    'href' => route('showcase.navigation'),
    'icon' => 'navigation',
]
```

If `icon` is omitted, UI Kit will also try to map the icon from the item label. Raw SVG or HTML icons still work and take precedence.

## Dual Sidebar Layouts

The app shell supports optional left and right navigation regions.

For a right-side mirrored setup, render the rail and sidebar using the right slots and pass `side="right"`:

```blade
<x-ui-kit-app-shell
    right-sidebar-collapse-mode="hidden"
    active-right-primary-section="reports"
>
    <x-slot:rightSidebar>
        <x-ui-kit-sidebar side="right" :items="$rightItems" />
    </x-slot:rightSidebar>

    <x-slot:rightPrimaryRail>
        <x-ui-kit-primary-rail side="right" :items="$rightRailItems" />
    </x-slot:rightPrimaryRail>
</x-ui-kit-app-shell>
```

If the right side should behave like a contextual helper section instead of another nav list, switch the sidebar organism into `panel` mode:

```blade
<x-slot:rightSidebar>
    <x-ui-kit-sidebar
        side="right"
        variant="panel"
        eyebrow="Helper panel"
        title="Upcoming moments"
        subtitle="Show unique content in a Gmail-style side section."
    >
        <x-slot:actions>
            <button type="button">...</button>
        </x-slot:actions>

        <div>Custom panel content</div>

        <x-slot:footer>
            <button type="button">Create action</button>
        </x-slot:footer>
    </x-ui-kit-sidebar>
</x-slot:rightSidebar>
```

## Shell Templates

UI Kit also includes a higher-level shell template for multi-pane layouts where you want a primary rail, contextual navigation, a top bar, and an optional helper panel without wiring each region by hand:

```blade
<x-ui-kit-context-shell
    :section="$section"
    :subnav="$subnav"
    :search-query="$searchQuery"
    :navigation="$navigation"
    :navigation-badges="$navigationBadges"
    :helper-rail-items="$helperRailItems"
    :helper-panels="$helperPanels"
    brand-logo="{{ asset('logo.svg') }}"
    brand-name="Operations"
    brand-subtitle="Manage your module"
>
    {{-- Page content --}}
</x-ui-kit-context-shell>
```

You can pass your own navigation arrays, branding, labels, badges, helper rail items, and helper panel blocks to shape the shell for any module in your app.

## Auth Pages

UI Kit includes an auth template that gives consumers a flexible shell for login, register, forgot-password, and other auth views without forcing one fixed design.

It supports:

- solid or image backgrounds
- left, center, or right auth card placement
- shared branding from config or auth-specific branding
- optional custom logo, custom background layer, and supporting content slots
- fully custom form/card contents inside the main slot

Set shared branding once in `config/ui-kit.php`:

```php
'branding' => [
    'logo' => asset('images/logo.svg'),
    'name' => 'Acme',
    'subtitle' => 'Workspace portal',
    'href' => '/',
],
```

Then render an auth page:

```blade
<x-ui-kit-auth-page
    title="Welcome back"
    subtitle="Sign in to continue to your workspace."
    background-type="image"
    background-image="{{ asset('images/auth-bg.jpg') }}"
    card-position="right"
>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-sm font-medium">Email</label>
            <x-ui-kit-input id="email" name="email" type="email" required />
        </div>

        <div class="space-y-2">
            <label for="password" class="text-sm font-medium">Password</label>
            <x-ui-kit-input id="password" name="password" type="password" required />
        </div>

        <x-ui-kit-button type="submit" class="w-full">Sign in</x-ui-kit-button>
    </form>

    <x-slot:aside>
        <div class="max-w-lg">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-white/70">Secure access</p>
            <h2 class="mt-4 text-4xl font-semibold tracking-tight text-white">Build an auth screen that still feels like your product.</h2>
            <p class="mt-4 text-base text-white/75">Consumers can swap the background, move the card, reuse their navbar logo, or inject a custom logo for auth only.</p>
        </div>
    </x-slot:aside>
</x-ui-kit-auth-page>
```

Placement and size are now package-level options, so a consumer can shift the auth content without rebuilding the template:

```blade
{{-- Right-side half-screen panel --}}
<x-ui-kit-auth-page
    content-variant="panel"
    content-side="right"
    content-width="half"
/>

{{-- Left floating bubble --}}
<x-ui-kit-auth-page
    content-variant="bubble"
    content-side="left"
    content-width="sm"
/>

{{-- Centered modal-style card --}}
<x-ui-kit-auth-page
    content-variant="card"
    content-side="center"
    content-width="md"
/>

{{-- Full-screen auth surface --}}
<x-ui-kit-auth-page
    content-variant="full"
    content-width="xl"
/>

{{-- Flush left panel with custom CSS width --}}
<x-ui-kit-auth-page
    content-variant="flush"
    content-side="left"
    content-width="28rem"
/>
```

If a consumer wants a different auth logo than the main app brand, they can override it per page:

```blade
<x-ui-kit-auth-page
    logo-src="{{ asset('images/auth-logo.svg') }}"
    brand-name="Client portal"
    brand-subtitle="For partners only"
/>
```

If they want total visual control, they can replace the background or logo regions with slots:

```blade
<x-ui-kit-auth-page title="Sign in">
    <x-slot:background>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,#1e3a8a,transparent_40%),linear-gradient(135deg,#020617,#0f172a,#1d4ed8)]"></div>
    </x-slot:background>

    <x-slot:logo>
        <div class="rounded-full bg-white/10 px-4 py-2 text-white backdrop-blur">Custom brand block</div>
    </x-slot:logo>

    {{-- Custom auth form --}}
</x-ui-kit-auth-page>
```

## Requirements

- Laravel 12+
- Tailwind CSS is only required if you want to rebuild or override the package styles
- Alpine.js (auto-loaded by package layout)
