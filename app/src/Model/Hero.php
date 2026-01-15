<?php
namespace App\Model;

use Juzdy\Model;

class Hero extends Model
{
    const TABLE = 'heroes';

    const COLUMN_ID = 'id';
    
    protected string $table = self::TABLE;


    public function getAbilities(): array
    {
        $abilities = $this->get('abilities');
        return $abilities ? explode(',', $abilities) : [];
    }

}
