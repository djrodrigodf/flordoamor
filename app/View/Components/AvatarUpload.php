<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvatarUpload extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $image = '',

        // Slots
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?string $modelUpload = null,
        public ?string $photo = '/user.png'

    )
    {
        $this->uuid = "mary" . md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <div class="avatar">

                <x-file wire:model="{{ $modelUpload }}" accept="image/png, image/jpeg">
                    <img src="{{ $photo }}" class="h-40 rounded-lg" style="width: 150px" />
                </x-file>


                </div>
                @if($title || $subtitle)
                <div>
                    @if($title)
                        <div @class(["font-semibold font-lg", is_string($title) ? '' : $title?->attributes->get('class') ]) >
                            {{ $title }}
                        </div>
                    @endif
                    @if($subtitle)
                        <div @class(["text-sm text-gray-400", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]) >
                            {{ $subtitle }}
                        </div>
                    @endif
                </div>
                @endif
            </div>
            HTML;
    }
}
