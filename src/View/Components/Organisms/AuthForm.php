<?php

namespace ChrisKelemba\LaravelUiKit\View\Components\Organisms;

use ChrisKelemba\LaravelUiKit\View\Components\AbstractUiKitComponent;

class AuthForm extends AbstractUiKitComponent
{
    public function __construct(
        public mixed $action = '#',
        public mixed $method = 'POST',
        public mixed $fields = [],
        public mixed $submitLabel = 'Sign In',
        public mixed $rememberLabel = null,
        public mixed $forgotPasswordHref = null,
        public mixed $forgotPasswordLabel = 'Forgot password?',
        public mixed $formClass = null,
        public mixed $fieldGroupClass = null,
        public mixed $footerClass = null,
    ) {
    }

    protected string $view = 'ui-kit::components.organisms.auth-form';
}
