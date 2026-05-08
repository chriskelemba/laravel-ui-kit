<script>
    (() => {
        const loader = document.getElementById('aui-page-loader');
        const spinner = document.getElementById('aui-page-loader-spinner');
        if (!loader || !spinner) return;

        const showLoader = () => {
            document.body.classList.add('aui-loading');
            loader.classList.remove('hidden');
            spinner.classList.remove('hidden');
            spinner.classList.add('flex');
        };

        window.addEventListener('aui:page-loading', showLoader);

        document.addEventListener('click', event => {
            const link = event.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            const target = link.getAttribute('target');
            const isHash = href.startsWith('#');
            const isJs = href.toLowerCase().startsWith('javascript:');
            const isDownload = link.hasAttribute('download');
            const isNewTab = target === '_blank';
            const isModified = event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;

            if (isHash || isJs || isDownload || isNewTab || isModified) return;

            showLoader();
        });

        document.addEventListener('submit', event => {
            if (! (event.target instanceof HTMLFormElement)) return;
            if (event.defaultPrevented) return;

            const submitter = event.submitter;

            if (submitter instanceof HTMLElement) {
                window.dispatchEvent(new CustomEvent('aui:button-loading', {
                    detail: submitter,
                }));
            }
        });

        window.addEventListener('pageshow', () => {
            document.body.classList.remove('aui-loading');
            loader.classList.add('hidden');
            spinner.classList.add('hidden');
            spinner.classList.remove('flex');
        });
    })();
</script>
