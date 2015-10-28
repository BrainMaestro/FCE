<?php
/**
 * Created by PhpStorm.
 * User: Maestro
 * Date: 27/10/2015
 * Time: 5:12 PM
 */

namespace Fce\Transformers;

use Fce\Models\Key;
use League\Fractal\TransformerAbstract;

class KeyTransformer extends TransformerAbstract
{
    public function transform(Key $key)
    {
        return [
            'id' => (int) $key->id,
            'value' => $key->value,
            'given_out' => (boolean) $key->given_out,
            'used' => (boolean) $key->used,
            'section_id' => (int) $key->section->id,
        ];
    }
}
