<?php

namespace Grafite\Forms\Fields;

class PasswordWithReveal extends Field
{
    protected static function getType()
    {
        return 'password';
    }

    protected static function getFactory()
    {
        return 'password';
    }

    public static function scripts($options)
    {
        return [
            '//cdn.jsdelivr.net/npm/password-revealer@1.1.1/dist/password-revealer.min.js',
        ];
    }

    public static function onLoadJs($id, $options)
    {
        return '_formsjs_passwordWithRevealField';
    }

    public static function onLoadJsData($id, $options)
    {
        return $options['toggle-selector'] ?? 'PasswordRevealer-trigger';
    }

    public static function js($id, $options)
    {
        return <<<JS
            _formsjs_passwordWithRevealField = function (element) {
                if (! element.getAttribute('data-formsjs-rendered')) {
                    let _selector = '.' + element.getAttribute('data-formsjs-onload-data');
                    PasswordRevealer(element, { trigger: { selector: _selector, eventListener: 'click' } }).init();
                }
            }
JS;
    }

    public static function getTemplate($options)
    {
        $toggle = $options['toggle'] ?? 'Toggle';
        $toggleClasses = $options['toggle-classes'] ?? 'btn btn-outline-primary bmx-rounded-left-0';
        $toggleSelector = $options['toggle-selector'] ?? 'PasswordRevealer-trigger';

        return <<<HTML
<div class="{rowClass}">
    <label for="{id}" class="{labelClass}">{name}</label>
    <div class="{fieldClass}">
        <div class="input-group mb-3">
            {field}
            <button type="button" class="{$toggleSelector} {$toggleClasses}">{$toggle}</button>
        </div>
    {errors}
    </div>
</div>
HTML;
    }
}
