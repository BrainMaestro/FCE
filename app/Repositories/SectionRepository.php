<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:24 PM
 */

namespace Fce\Repositories;

interface SectionRepository
{
    public function getSections();

    public function getSectionById($id);

    public function updateSection(array $attributes);

    public function createSection(array $attributes);
}