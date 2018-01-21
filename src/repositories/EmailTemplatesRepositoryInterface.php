<?php

namespace ymaker\email\templates\repositories;

/**
 * Interface of email templates repository.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 4.0
 */
interface EmailTemplatesRepositoryInterface
{
    /**
     * Find email template entity by ID.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * Returns data provider for email template entity.
     *
     * @return \yii\data\DataProviderInterface
     */
    public function getDataProvider();

    /**
     * Creates new email template.
     *
     * @return mixed
     */
    public function create();

    /**
     * Save data in entity.
     *
     * @param mixed $entity
     * @param array $data
     *
     * @return mixed
     */
    public function save($entity, array $data);

    /**
     * Removes email template entity by ID.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id);
}
