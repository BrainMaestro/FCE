<?php
/**
 * Created by BrainMaestro
 * Date: 11/2/2016
 * Time: 10:38 PM
 */

namespace Fce\Repositories\Contracts;

use Fce\Models\Section;

interface KeyRepository
{
    public function getKeysBySection($sectionId);

    public function updateKey($id, array $attributes);

    public function createKeys(Section $section);
}