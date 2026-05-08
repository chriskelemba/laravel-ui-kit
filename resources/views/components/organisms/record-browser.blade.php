@props([
    'title' => null,
    'items' => [],
    'detailHeaders' => [],
    'detailPanels' => [],
    'initialSelectedKey' => null,
    'infoSidebarEnabled' => false,
    'infoSidebarTitle' => 'Info',
    'infoSidebarSubtitle' => 'Side panel',
    'infoSidebarPromptTitle' => 'Click on data',
    'infoSidebarPromptDescription' => 'Open an item to load its detail here.',
    'primaryActionLabel' => null,
    'secondaryActionLabel' => null,
])

<div
    x-data="{
        items: @js($items),
        detailHeaders: @js($detailHeaders),
        detailPanels: @js($detailPanels),
        infoSidebarEnabled: @js($infoSidebarEnabled),
        selectedKey: @js($initialSelectedKey),
        infoSidebarOpen: false,
        infoKey: null,
        selectItem(key) {
            this.selectedKey = key;

            if (this.infoSidebarOpen) {
                this.infoKey = key;
            }
        },
        toggleInfoSidebar() {
            this.infoSidebarOpen = !this.infoSidebarOpen;

            if (!this.infoSidebarOpen) {
                this.infoKey = null;
            }
        },
        selectedItem() {
            for (let index = 0; index < this.items.length; index += 1) {
                if (this.items[index].key === this.selectedKey) {
                    return this.items[index];
                }
            }

            return null;
        },
        selectedBlocks() {
            if (!this.selectedKey || !this.detailPanels[this.selectedKey]) {
                return [];
            }

            return this.detailPanels[this.selectedKey].blocks || [];
        },
        infoHeader() {
            return this.infoKey && this.detailHeaders[this.infoKey]
                ? this.detailHeaders[this.infoKey]
                : null;
        },
        infoBlocks() {
            if (!this.infoKey || !this.detailPanels[this.infoKey]) {
                return [];
            }

            return this.detailPanels[this.infoKey].blocks || [];
        },
    }"
    class="grid gap-6"
    :class="infoSidebarEnabled ? 'xl:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)_minmax(18rem,0.75fr)]' : 'xl:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)]'"
>
    <x-ui-kit::organisms.panel :title="$title" :class="$infoSidebarEnabled ? 'xl:col-span-2' : ''">
        <div
            @class([
                'mb-6 flex items-center justify-between gap-4 rounded-[28px] border border-slate-200 bg-slate-50 px-4 py-3' => $infoSidebarEnabled,
                'mb-6 hidden' => ! $infoSidebarEnabled,
            ])
        >
            <div>
                <p class="text-sm font-semibold text-slate-900">Board focus</p>
                <p class="mt-1 text-sm text-slate-600">Click any item card to open it directly in the main detail view.</p>
            </div>

            <button
                type="button"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-600 shadow-sm transition hover:border-sky-300 hover:text-sky-600"
                :class="infoSidebarOpen ? 'border-sky-500 bg-sky-50 text-sky-700' : ''"
                @click="toggleInfoSidebar()"
                :aria-pressed="infoSidebarOpen.toString()"
                aria-label="Toggle info sidebar"
                title="Toggle info sidebar"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </button>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)]">
            <div class="space-y-3">
                @foreach ($items as $item)
                    <article
                        class="cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 px-4 py-4 transition hover:border-amber-300 hover:bg-white"
                        @click="selectItem(@js($item['key']))"
                        :class="selectedKey === @js($item['key']) ? 'border-amber-300 bg-white shadow-sm ring-1 ring-amber-100' : ''"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                @if (! empty($item['subtitle']))
                                    <p class="mt-1 text-sm text-slate-600">{{ $item['subtitle'] }}</p>
                                @endif
                                @if (! empty($item['meta']))
                                    <p class="mt-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-500">{{ $item['meta'] }}</p>
                                @endif
                            </div>
                            @if (! empty($item['badge']))
                                <x-ui-kit::atoms.badge>{{ $item['badge'] }}</x-ui-kit::atoms.badge>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-5">
                <template x-if="selectedItem()">
                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500" x-text="detailHeaders[selectedKey] ? detailHeaders[selectedKey].eyebrow : ''"></p>
                            <h3 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900" x-text="selectedItem() ? selectedItem().title : ''"></h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600" x-text="detailHeaders[selectedKey] ? detailHeaders[selectedKey].description : ''"></p>
                        </div>

                        <template x-for="(block, index) in selectedBlocks()" :key="selectedKey + '-detail-' + index">
                            <article class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <template x-if="block.type === 'stat-grid'">
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <template x-for="item in block.items" :key="item.label">
                                            <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500" x-text="item.label"></p>
                                                <p class="mt-2 text-lg font-semibold text-slate-900" x-text="item.value"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <template x-if="block.type === 'key-value'">
                                    <div>
                                        <p class="text-base font-semibold text-slate-900" x-text="block.title"></p>
                                        <div class="mt-4 space-y-3">
                                            <template x-for="item in block.items" :key="item.label">
                                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                                    <span class="text-sm text-slate-600" x-text="item.label"></span>
                                                    <span class="text-sm font-semibold text-slate-900" x-text="item.value"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </article>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </x-ui-kit::organisms.panel>

    @if ($infoSidebarEnabled)
        <aside
            x-cloak
            x-show="infoSidebarOpen"
            x-transition.opacity.duration.200ms
            class="rounded-[32px] border border-slate-200 bg-white shadow-sm xl:sticky xl:top-6 xl:h-fit"
        >
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <div>
                    <p class="text-sm font-semibold text-slate-900">{{ $infoSidebarTitle }}</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $infoSidebarSubtitle }}</p>
                </div>

                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                    @click="toggleInfoSidebar()"
                    aria-label="Close info sidebar"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-5 py-5">
                <template x-if="!infoKey">
                    <div class="rounded-[28px] border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-slate-900">{{ $infoSidebarPromptTitle }}</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $infoSidebarPromptDescription }}</p>
                    </div>
                </template>

                <template x-if="infoKey">
                    <div class="space-y-4">
                        <div class="rounded-[28px] border border-slate-200 bg-slate-50 px-4 py-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500" x-text="infoHeader() ? infoHeader().eyebrow : ''"></p>
                            <p class="mt-2 text-lg font-semibold text-slate-900" x-text="infoHeader() ? infoHeader().title : ''"></p>
                            <p class="mt-2 text-sm leading-6 text-slate-600" x-text="infoHeader() ? infoHeader().description : ''"></p>
                        </div>

                        <template x-for="(block, index) in infoBlocks()" :key="infoKey + '-sidebar-' + index">
                            <article class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <template x-if="block.type === 'stat-grid'">
                                    <div class="grid gap-3">
                                        <template x-for="item in block.items" :key="item.label">
                                            <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500" x-text="item.label"></p>
                                                <p class="mt-2 text-base font-semibold text-slate-900" x-text="item.value"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <template x-if="block.type === 'key-value'">
                                    <div>
                                        <p class="text-base font-semibold text-slate-900" x-text="block.title"></p>
                                        <div class="mt-4 space-y-3">
                                            <template x-for="item in block.items" :key="item.label">
                                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                                    <p class="text-sm text-slate-600" x-text="item.label"></p>
                                                    <p class="mt-1 text-sm font-semibold text-slate-900" x-text="item.value"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </article>
                        </template>

                        @if ($primaryActionLabel || $secondaryActionLabel)
                            <div class="space-y-3 border-t border-slate-200 pt-4">
                                @if ($primaryActionLabel)
                                    <button
                                        type="button"
                                        class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                    >
                                        {{ $primaryActionLabel }}
                                    </button>
                                @endif

                                @if ($secondaryActionLabel)
                                    <button
                                        type="button"
                                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-white"
                                    >
                                        {{ $secondaryActionLabel }}
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </template>
            </div>
        </aside>
    @endif
</div>
