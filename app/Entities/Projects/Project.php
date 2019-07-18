<?php


namespace App\Entities\Projects;


use App\Entities\CustomModel;
use App\Entities\Groups\Group;
use App\Entities\Languages\Language;
use App\Entities\Translations\Entries\TranslationEntry;
use App\Entities\Translations\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Class Project
 * @package App\Entities\Projects
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * Relations:
 * @property Collection $groups
 */
class Project extends CustomModel
{
    protected $table = 'projects';

    public function getShortDescription()
    {
        $desc = $this->description;

        if (strlen($desc) >= 100)
            return substr($desc, 0, 100) . " ... ";

        return $desc;
    }

    public function getLanguages()
    {
        $query = Language::join('translations_entries', 'translations_entries.language_code', '=', 'languages.code');

        $query = $this->filterThroughTranslationEntries($query, [
            'languages.code', 'languages.name',
        ])->distinct('code');

        return $query->get();
    }

    public function getTranslations()
    {
        $query = Translation::join('translations_entries', 'translations_entries.translation_id', '=', 'translations.id');

        $query = $this->filterThroughTranslationEntries($query, [
            'translations.id', 'translations.key',
            'groups.id as group_id',
            'groups.name as group_name',
            'translations_entries.entry as entry',
            'translations_entries.language_code as language_code',
        ]);

        return $query->get();
    }

    public function getTranslationEntries()
    {
        $query = TranslationEntry::query();

        $query = $this->filterThroughTranslationEntries($query, [
            'translations_entries.id', 'translations_entries.entry', 'translations_entries.language_code',
            'groups.id as group_id',
            'groups.name as group_name',
        ]);

        return $this->filterThroughTranslationEntries(TranslationEntry::query())->get();
    }

    private function filterThroughTranslationEntries(Builder $query, array $columns = ['*']): Builder
    {
        return $query->select($columns)
            ->join('ref_groups_translations', 'translations_entries.translation_id', '=', 'ref_groups_translations.translation_id')
            ->join('ref_projects_groups', 'ref_projects_groups.group_id', '=', 'ref_groups_translations.group_id')
            ->join('groups', 'groups.id', '=', 'ref_groups_translations.group_id')
            ->where('ref_projects_groups.project_id', '=', $this->id);
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'ref_projects_groups',
            'project_id',
            'group_id'
        );
    }
}
