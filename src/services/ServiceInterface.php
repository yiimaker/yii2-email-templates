<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\services;

/**
 * Base interface for service
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
interface ServiceInterface
{
    /**
     * Returns model object
     *
     * @return mixed
     */
    public function getModel();

    /**
     * Returns translation model object
     *
     * @param integer|null $modelId
     * @param string|null $language
     * @return mixed
     */
    public function getTranslationModel($modelId = null, $language = null);

    /**
     * Create model with translation
     *
     * @param array $data Array with data for models
     * @return mixed
     */
    public function create($data);

    /**
     * Update models data
     *
     * @param mixed $model
     * @param mixed $translation
     * @param array $data
     * @return mixed
     */
    public function update($model, $translation, $data);
}
