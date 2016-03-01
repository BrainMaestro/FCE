<?php
/**
 * Created by BrainMaestro
 * Date: 11/2/2016
 * Time: 10:38 PM
 */

namespace Fce\Repositories\Contracts;

interface KeyRepository
{
    public function getKeysBySection($sectionId);

    public function createKeys(array $section);

    public function setGivenOut($id);

    public function setUsed($id);

    public function deleteKeys($sectionId);
}