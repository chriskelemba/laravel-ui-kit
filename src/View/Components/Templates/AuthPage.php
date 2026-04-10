<?php

namespace ChrisKelemba\LaravelUiKit\View\Components\Templates;

use ChrisKelemba\LaravelUiKit\View\Components\AbstractUiKitComponent;

class AuthPage extends AbstractUiKitComponent
{
    public function __construct(
        public mixed $title = null,
        public mixed $subtitle = null,
        public mixed $theme = null,
        public mixed $layout = null,
        public mixed $contentVariant = null,
        public mixed $contentSide = null,
        public mixed $contentWidth = null,
        public mixed $cardPosition = null,
        public mixed $contentAlignment = null,
        public mixed $backgroundType = null,
        public mixed $backgroundColor = null,
        public mixed $backgroundImage = null,
        public mixed $backgroundPosition = null,
        public mixed $backgroundSize = null,
        public mixed $backgroundOverlay = null,
        public mixed $showThemeToggle = null,
        public mixed $panelWidth = null,
        public mixed $cardMaxWidth = null,
        public mixed $cardPadding = null,
        public mixed $cardSurface = null,
        public mixed $logoSrc = null,
        public mixed $logoAlt = null,
        public mixed $logoHref = null,
        public mixed $brandName = null,
        public mixed $brandSubtitle = null,
    ) {
    }

    protected string $view = 'ui-kit::components.templates.auth-page';
}
