<?php

namespace LaravelEnso\Localisation\app\Handlers;

use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\Localisation\app\Handlers\Traits\JsonFilePathResolver;
use LaravelEnso\Localisation\app\Handlers\Traits\LegacyFolderPathResolver;

class Destroyer
{
    use JsonFilePathResolver, LegacyFolderPathResolver;

    private $localisation;

    public function __construct(Language $localisation)
    {
        $this->localisation = $localisation;
    }

    public function run()
    {
        \DB::transaction(function () {
            $this->localisation->delete();
            \File::deleteDirectory($this->legacyFolderName($this->localisation->name));
            \File::delete($this->jsonFileName($this->localisation->name));
        });
    }
}
