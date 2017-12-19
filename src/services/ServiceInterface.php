<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\services;

/**
 * Interface for email template service.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 3.0
 */
interface ServiceInterface
{
    /**
     * Returns data provider.
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider();

    /**
     * Returns model instance.
     *
     * @param null|int $id
     * @return \yii\db\ActiveRecord
     */
    public function getModel($id = null);

    /**
     * Save record.
     *
     * @param array $data
     * @return bool
     */
    public function save(array $data);

    /**
     * Removes record.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id);
}
