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
- `ui-kit::templates.workspace-shell`
- `ui-kit::templates.module-workspace`
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

For dynamic module or tenant theming, you can also generate a workspace palette from a single hex color:

```php
use ChrisKelemba\LaravelUiKit\Support\ThemePalette;

$themeColors = ThemePalette::fromColor('#0EA5E9');
```

Pass the result into `theme-colors` on `ui-kit::templates.workspace-shell` or `ui-kit::templates.module-workspace`.

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

### Custom Profile Menu Actions

Consumers can customize the profile dropdown menu in `ui-kit::templates.module-workspace` instead of being limited to the built-in profile and logout links.

```blade
<x-ui-kit::templates.module-workspace
    :profile-user="auth()->user()"
    :profile-menu-items="[
        ['label' => 'My account', 'href' => route('account.settings'), 'icon' => 'fa-solid fa-user-gear'],
        ['label' => 'Team switcher', 'href' => route('teams.index'), 'icon' => 'fa-solid fa-people-group'],
        ['label' => 'Sign out', 'href' => route('logout'), 'icon' => 'fa-solid fa-right-from-bracket', 'tone' => 'danger'],
    ]"
>
    ...
</x-ui-kit::templates.module-workspace>
```

Each menu item supports:

- `label`: visible text
- `href`: destination URL
- `icon`: optional Font Awesome class
- `tone`: use `'danger'` for destructive-style actions

If `profileMenuItems` is not provided, the package keeps the current fallback behavior and builds the menu from `profileEditHref` and `profileLogoutHref`.

### Module Workspace

`x-ui-kit::templates.module-workspace` is the first-class Blade entry point for app-style modules like dashboards, inventory screens, and operations workspaces.

The recommended pattern is to shape one page contract in your controller and let the Blade layout render it, instead of querying models or inferring route state inside the view.

```php
return view('operations.index', [
    'workspacePage' => [
        'title' => 'Northwind Ops',
        'subtitle' => 'operations workspace',
        'section' => 'inventory',
        'subnav' => 'catalog',
        'page_eyebrow' => 'Operations workspace',
        'page_heading' => 'Inventory and fulfillment',
        'page_description' => 'Track catalog records, stock movement, and fulfillment tasks from one shared workspace.',
        'navigation' => $navigation,
        'navigation_badges' => $navigationBadges,
        'theme_colors' => [
            'accent' => '#0f766e',
            'accent_soft' => '#ccfbf1',
        ],
        'brand' => [
            'initials' => 'NW',
            'name' => 'Northwind Ops',
            'tagline' => 'inventory, fulfillment, reporting',
        ],
        'profile' => [
            'user' => auth()->user(),
            'edit_href' => route('profile.edit'),
            'logout_href' => route('logout'),
        ],
    ],
    'spotlightCards' => $spotlightCards,
    'asideBlocks' => $asideBlocks,
]);
```

Then render the shell from your layout:

```blade
<x-ui-kit::templates.module-workspace
    :title="$workspacePage['title']"
    :subtitle="$workspacePage['subtitle']"
    :section="$workspacePage['section']"
    :subnav="$workspacePage['subnav']"
    :page-eyebrow="$workspacePage['page_eyebrow']"
    :page-heading="$workspacePage['page_heading']"
    :page-description="$workspacePage['page_description']"
    :navigation="$workspacePage['navigation']"
    :navigation-badges="$workspacePage['navigation_badges']"
    :theme-colors="$workspacePage['theme_colors']"
    :profile-user="$workspacePage['profile']['user']"
    :profile-edit-href="$workspacePage['profile']['edit_href']"
    :profile-logout-href="$workspacePage['profile']['logout_href']"
>
    {{ $slot }}
</x-ui-kit::templates.module-workspace>
```

This keeps the frontend contract explicit, makes pages easier to hand off between backend and frontend teammates, and makes it easier to reuse the same backend data in Vue or another client later.

### Workspace Profile Menu

The workspace shell profile menu resolves the current authenticated user automatically when auth is available. If the host app has no logged-in user, it falls back to `Default User` and uses the first letter of the resolved name as the avatar.

Consumers can support different user shapes by publishing and editing `config/ui-kit.php`:

```php
'workspace' => [
    'profile' => [
        'fields' => [
            'name' => ['name', 'username', 'full_name', 'display_name', 'Name', 'Username'],
            'email' => ['email', 'Email', 'mail'],
            'avatar_src' => ['avatar_src', 'avatar_url', 'profile_photo_url', 'photo_url'],
        ],
        'fallback' => [
            'name' => 'Default User',
            'email' => null,
        ],
        'routes' => [
            'edit' => ['name' => 'profile.edit', 'href' => null, 'parameters' => []],
            'logout' => ['name' => 'logout', 'href' => null, 'parameters' => []],
        ],
    ],
],
```

You can also override the profile per render:

```blade
<x-ui-kit::templates.workspace-shell
    :profile-user="$member"
    profile-edit-route="account.profile.edit"
    profile-logout-route="sessions.destroy"
/>
```

For apps without named routes, pass direct URLs instead:

```blade
<x-ui-kit::templates.workspace-shell
    profile-edit-href="/account"
    profile-logout-href="/logout"
/>
```

`workspace-shell` also supports two named slots for dynamic page controls:

```blade
<x-ui-kit::templates.workspace-shell ...>
    <x-slot:actions>
        <x-ui-kit::atoms.button variant="secondary">Export</x-ui-kit::atoms.button>
    </x-slot:actions>

    <x-slot:floating>
        <x-ui-kit::atoms.button>Add record</x-ui-kit::atoms.button>
    </x-slot:floating>
</x-ui-kit::templates.workspace-shell>
```

Use `actions` for header controls and `floating` for pinned corner UI such as quick-create buttons.

For a consumer-controlled details panel, `workspace-shell` also accepts a custom right sidebar body:

```blade
<x-ui-kit::templates.workspace-shell
    :show-right-sidebar="true"
    right-sidebar-view="details"
    :right-panel-headers="[
        'details' => [
            'title' => 'Details',
            'description' => 'Select an item to see the details.',
        ],
    ]"
>
    <x-slot:rightSidebarContent>
        <div class="space-y-4">
            <p class="text-sm text-slate-600">Anything can go here.</p>
        </div>
    </x-slot:rightSidebarContent>
</x-ui-kit::templates.workspace-shell>
```

Use `rightSidebarContent` when the consumer wants to fully own the sidebar body instead of relying on the package block renderer.

For consumers who do not want to build full `primaryRailItems` and `sidebarSections` arrays, UI Kit also includes a simpler workspace wrapper:

```blade
<x-ui-kit::templates.module-workspace
    title="Operations"
    subtitle="manage your module"
    section="inventory"
    subnav="pets"
    page-eyebrow="Workspace"
    page-heading="Inventory"
    page-description="Track records from one place."
    :navigation="[
        [
            'key' => 'inventory',
            'label' => 'Inventory',
            'href' => route('inventory.index'),
            'icon' => 'fa-solid fa-box',
            'items' => [
                ['key' => 'pets', 'label' => 'Pets', 'href' => route('inventory.index')],
                ['key' => 'stock', 'label' => 'Stock', 'href' => route('inventory.stock')],
            ],
        ],
    ]"
    :navigation-badges="[
        'stock' => 12,
    ]"
    :profile-user="auth()->user()"
>
    <x-slot:rightSidebarContent>
        <p class="text-sm text-slate-600">Select an item to see the details.</p>
    </x-slot:rightSidebarContent>

    {{-- Page content --}}
</x-ui-kit::templates.module-workspace>
```

Use `module-workspace` when the consumer wants a simpler entrypoint built around one `navigation` array instead of assembling the lower-level shell structure manually.

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
