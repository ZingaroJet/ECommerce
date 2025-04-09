<?php

namespace App\Enums;

enum ProductVariationTypeEnum :string
{
    case Select = 'Select';
    case Radio = 'Radio';
    case Image = 'Image';

    public static function labels(): array{
        return[
            'Select' => __('Select'),
            'Radio' => __('Radio'),
            'Image' => __('Image'),
        ];
    }
}
