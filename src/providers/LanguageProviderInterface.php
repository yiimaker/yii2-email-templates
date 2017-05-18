<?php
/**
 * @link https://github.com/yiimaker/yii2-email-templates
 * @copyright Copyright (c) 2017 Yii Maker
 * @license BSD 3-Clause License
 */

namespace ymaker\email\templates\providers;

/**
 * Interface for language providers
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
interface LanguageProviderInterface
{
    /**
     * Method should return a array with languages
     * Example
     * ```php
     * public function getLanguages()
     * {
     *      return [
     *          [
     *              'locale' => 'en-US,
     *              'title' => 'English'
     *          ],
     *          [
     *              'locale' => 'ru-RU',
     *              'title' => 'Русский'
     *          ],
     *          // ...
     *      ];
     * }
     * ```
     *
     * @return array
     */
    public function getLanguages();

    /**
     * Method should return a array with default language
     * Example
     * ```php
     * public function getDefaultLanguage()
     * {
     *      return [
     *          'locale' => 'en-US',
     *          'title' => 'English'
     *      ];
     * }
     * ```
     *
     * @return array
     */
    public function getDefaultLanguage();
}
