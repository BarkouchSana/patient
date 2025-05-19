<?php
 
 namespace App\Application\DTOs;

class VitalSignItemDto
{
    public string $label;
    public string $value;
    public string $unit;
    // L'icône sera gérée par la couche Présentation (API Resource)

    public function __construct(string $label, string $value, string $unit)
    {
        $this->label = $label;
        $this->value = $value;
        $this->unit = $unit;
    }
}