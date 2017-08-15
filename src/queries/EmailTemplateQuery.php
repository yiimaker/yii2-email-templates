<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\queries;

use yii\db\ActiveQuery;

/**
 * Query class for [[\ymaker\email\templates\models\entities\EmailTemplate]] model.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class EmailTemplateQuery extends ActiveQuery
{
    /**
     * Add by key condition.
     *
     * @param string $key Email template key.
     * @return EmailTemplateQuery
     */
    public function byKey($key)
    {
        return $this->where(['key' => $key]);
    }

    /**
     * Get with translation by language.
     *
     * @param string $language
     * @return EmailTemplateQuery
     */
    public function withTranslation($language)
    {
        return $this->with(['translations' => function ($query) use ($language) {
            /* @var ActiveQuery $query */
            $query->andWhere(['language' => $language]);
        }]);
    }
}
