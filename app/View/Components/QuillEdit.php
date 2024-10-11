<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuillEdit extends Component
{
    public $content;  // Conteúdo inicial (equivalente ao 'observations')
    public $theme;    // Tema do Quill (bubble ou snow)
    public $wireModel; // Nome da variável do wire:model

    /**
     * Create a new component instance.
     */
    public function __construct($content = '', $theme = 'bubble', $wireModel = 'content')
    {
        $this->content = $content;
        $this->theme = $theme;
        $this->wireModel = $wireModel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Use addslashes para escapar corretamente o conteúdo HTML
        $escapedContent = addslashes($this->content);


        return <<<HTML
            <div class="mt-4">
                <div

                    x-data
                    x-ref="quillEditor"
                    x-init="
                        quill = new Quill(\$refs.quillEditor, {
                            theme: '{$this->theme}',
                            placeholder: 'Escreva algo...'
                        });
                        quill.on('text-change', function () {
                            \$dispatch('input', quill.root.innerHTML);
                        });
                    "
                    wire:model.debounce="{$this->wireModel}"

                >
                {$escapedContent}
                </div>
            </div>
        HTML;
    }
}
