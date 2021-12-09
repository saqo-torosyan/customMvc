<?php

namespace app\core\form;

use app\core\Model;

/**
 * Class Field
 *
 * @package app\core\form
 */
class Field
{
    const TYPE_TEXT = 'text';
    const TYPE_EMAIL = 'email';
    const TYPE_PASSWORD = 'password';

    public Model $model;
    public string $attribute;
    public string $type;

    /**
     * Field constructor.
     *
     * @param Model $model
     * @param string $attribute
     * @param string $type
     */
    public function __construct(Model $model, string $attribute, string $type)
    {
        $this->type = $type;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('<div class="mb-3">
                <label>%s</label>
                <input type="%s" class="form-control%s" name="%s" value="%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->attribute,
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->getFirstError($this->attribute)
        );
    }
}