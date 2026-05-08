@php
    $flashToasts = collect([
        session()->has('success') ? [
            'variant' => 'success',
            'title' => 'Success',
            'message' => session('success'),
        ] : null,
        session()->has('error') ? [
            'variant' => 'danger',
            'title' => 'Something went wrong',
            'message' => session('error'),
        ] : null,
        session()->has('warning') ? [
            'variant' => 'warning',
            'title' => 'Notice',
            'message' => session('warning'),
        ] : null,
        session()->has('info') ? [
            'variant' => 'info',
            'title' => 'Info',
            'message' => session('info'),
        ] : null,
        session()->has('status') ? [
            'variant' => 'info',
            'title' => 'Update',
            'message' => session('status'),
        ] : null,
    ])->filter()->values();
@endphp

@if ($flashToasts->isNotEmpty())
    <div id="aui-flash-toasts" style="position: fixed; top: 1.5rem; left: 50%; transform: translateX(-50%); z-index: 130; display: flex; flex-direction: column; gap: 0.75rem; width: min(26rem, calc(100vw - 2rem));">
        @foreach ($flashToasts as $toast)
            @php
                [$borderColor, $backgroundColor, $titleColor, $messageColor, $closeColor] = match ($toast['variant']) {
                    'success' => ['#22c55e', '#dcfce7', '#166534', '#166534', '#166534'],
                    'danger' => ['#f43f5e', '#ffe4e6', '#9f1239', '#9f1239', '#9f1239'],
                    'warning' => ['#f59e0b', '#fef3c7', '#92400e', '#92400e', '#92400e'],
                    default => ['#3b82f6', '#dbeafe', '#1d4ed8', '#1e3a8a', '#1d4ed8'],
                };
            @endphp
            <div class="aui-flash-toast" data-timeout="3500" style="transition: opacity 300ms ease, transform 300ms ease;">
                <div style="border-radius: 1rem; border: 1px solid {{ $borderColor }}; background: {{ $backgroundColor }}; padding: 1rem 1rem 0.95rem; box-shadow: 0 18px 48px rgba(15, 23, 42, 0.18); backdrop-filter: blur(10px);">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                        <div>
                            <p style="margin: 0; font-size: 0.875rem; font-weight: 700; color: {{ $titleColor }};">{{ $toast['title'] }}</p>
                            <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: {{ $messageColor }};">{{ $toast['message'] }}</p>
                        </div>
                        <button
                            type="button"
                            onclick="this.closest('.aui-flash-toast').remove()"
                            aria-label="Close notification"
                            style="border: 0; background: transparent; color: {{ $closeColor }}; font-size: 1rem; line-height: 1; cursor: pointer; padding: 0;"
                        >
                            ×
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        (() => {
            const container = document.getElementById('aui-flash-toasts');
            if (!container) return;

            container.querySelectorAll('.aui-flash-toast').forEach(toast => {
                const timeout = Number(toast.dataset.timeout || 3500);

                window.setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-8px)';

                    window.setTimeout(() => toast.remove(), 300);
                }, timeout);
            });
        })();
    </script>
@endif
