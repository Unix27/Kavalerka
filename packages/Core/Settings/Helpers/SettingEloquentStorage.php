<?php

namespace Core\Settings\Helpers;

use Core\Settings\Contracts\SettingStorage;
use Core\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Cache;

class SettingEloquentStorage implements SettingStorage
{
    /**
     * Group name.
     *
     * @var string
     */
    protected $settingsGroupName = 'default';

    /**
     * Cache key.
     *
     * @var string
     */
    protected $settingsCacheKey = 'settings';

    /**
     * {@inheritdoc}
     */
    public function all($locale, $fresh = false)
    {

        $fresh = true;
        $locale = app()->getLocale();

        if ($fresh) {
            return $this->modelQuery()->where(function ($query) use ($locale) {
                return $query->where('locale', $locale)
                    ->orWhere('locale', null);
            })
                ->pluck('value', 'name');
        }

        dd($fresh);

        return Cache::rememberForever($this->getSettingsCacheKey(), function () use($locale) {
            return $this->modelQuery()->where(function ($query) use ($locale) {
                return $query->where('locale', $locale)
                    ->orWhere('locale', null);
            })
                ->pluck('value', 'name');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null, $locale = null, $fresh = false)
    {
        return $this->all($locale, $fresh)->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $val = null, $locale = null)
    {
        // if its an array, batch save settings
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }

            return true;
        }

        $setting = $this->getSettingModel()->firstOrNew([
            'name' => $key,
            'group' => $this->settingsGroupName,
            'locale' => $locale,
        ]);

        $setting->value = $val;
        $setting->group = $this->settingsGroupName;
        $setting->locale = $locale;
        $setting->save();

        $this->flushCache();

        return $val;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->all()->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $deleted = $this->getSettingModel()->where('name', $key)->delete();

        $this->flushCache();

        return $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function flushCache()
    {
        return Cache::forget($this->getSettingsCacheKey());
    }

    /**
     * Get settings cache key.
     *
     * @return string
     */
    protected function getSettingsCacheKey()
    {
        return $this->settingsCacheKey.'.'.$this->settingsGroupName;
    }

    /**
     * Get settings eloquent model.
     *
     * @return Builder
     */
    protected function getSettingModel()
    {
        return app(Setting::class);
    }

    /**
     * Get the model query builder.
     *
     * @return Builder
     */
    protected function modelQuery()
    {
        return $this->getSettingModel()->group($this->settingsGroupName);
    }

    /**
     * Set the group name for settings.
     *
     * @param string $groupName
     * @return $this
     */
    public function group($groupName)
    {
        $this->settingsGroupName = $groupName;

        return $this;
    }
}
