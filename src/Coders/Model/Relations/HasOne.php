<?php

/**
 * Created by Cristian.
 * Date: 11/09/16 09:26 PM.
 */

namespace Reliese\Coders\Model\Relations;

use Illuminate\Support\Str;

class HasOne extends HasOneOrMany
{
    /**
     * @return string
     */
    public function hint(): string
    {
        return $this->related->getQualifiedUserClassName();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        if ($this->parent->usesSnakeAttributes()) {
            return Str::snake($this->related->getClassName());
        }

        return Str::camel($this->related->getClassName());
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return 'hasOne';
    }
}
