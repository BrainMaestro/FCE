<?php
/**
 * Created by BrainMaestro
 * Date: 19/2/2016
 * Time: 8:14 PM.
 */
namespace Fce\Repositories\Database;

use Fce\Models\Key;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\KeyTransformer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class EloquentKeyRepository extends Repository implements KeyRepository
{
    /**
     * Maximum number of tries allowed for failing key creation.
     */
    const MAX_TRIES = 3;

    /**
     * Create a new repository instance.
     *
     * @param Key $model
     * @param KeyTransformer $transformer
     */
    public function __construct(Key $model, KeyTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Gets all keys by the section they belong to.
     *
     * @param $sectionId
     * @return array
     */
    public function getKeysBySection($sectionId)
    {
        return $this->findBy(['section_id' => $sectionId]);
    }

    /**
     * Gets a key's details by its value.
     *
     * @param $value
     * @return array
     */
    public function getKeyByValue($value)
    {
        return $this->findBy(['value' => $value], self::ONE);
    }

    /**
     * Create keys for a section.
     *
     * @param array $section
     * @return array
     * @throws QueryException
     */
    public function createKeys(array $section)
    {
        $keys = [];

        DB::beginTransaction();
        for ($i = $tries = 0; $i < $section['enrolled']; $i++) {
            try {
                $key = $this->create([
                    'value' => strtoupper(str_random(Key::LENGTH)),
                    'section_id' => $section['id'],
                ]);

                $keys[] = $key['data'];
            } catch (QueryException $e) {
                // Throws a QueryException after too many tries
                if ($tries >= self::MAX_TRIES) {
                    DB::rollBack();
                    throw new QueryException($e->getSql(), $e->getBindings(), $e->getPrevious());
                }

                ++$tries; // Keep track of number of tries
                --$i; // So that the current iteration of the loop runs again
            }
        }
        DB::commit();

        return $keys;
    }

    /**
     * Set a particular key as given out.
     *
     * @param $value
     * @return bool
     */
    public function setGivenOut($value)
    {
        return $this->model->where('value', $value)
            ->update(['given_out' => true]) == 1;
    }

    /**
     * Set a particular key as used.
     *
     * @param $value
     * @return bool
     */
    public function setUsed($value)
    {
        return $this->model->where('value', $value)
            ->update(['used' => true]) == 1;
    }

    /**
     * Delete the keys that belong to a section.
     *
     * @param $sectionId
     * @return bool
     */
    public function deleteKeys($sectionId)
    {
        return $this->model->where('section_id', $sectionId)->delete() > 0;
    }
}
