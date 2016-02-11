<?php
/**
 * Created by BrainMaestro
 * Date: 11/2/2016
 * Time: 10:38 PM
 */

namespace Fce\Repositories;

interface KeyRepository
{
    public function getKeysBySectionId($sectionId);

    public function updateKey($id, array $attributes);

    public function createSectionKeys($sectionId, $enrolled);
}