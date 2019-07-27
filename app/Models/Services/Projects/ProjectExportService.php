<?php


namespace App\Models\Services\Projects;


use App\Models\Entities\Projects\Project;
use App\Models\Services\CustomService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ProjectExportService extends CustomService
{
    const STORAGE_PATH = 'app/public/exports';
    const PUBLIC_PATH = '/exports';

    public static $types = [
        'json' => 'json',
        'archive' => 'archive',
    ];

    public function json(Project $project, array $languages = []): string
    {
        $list = $this->formCollection($project, $languages);

        $file = sprintf('%s_%s_%d.json', $project->name, request()->user()->name, time());
        $storagePath = $this->getStoragePath($file);

        $this->createDirectory();
        File::put($storagePath, $list->toJson(JSON_UNESCAPED_UNICODE));

        return $storagePath;
    }

    /**
     * @param Project $project
     * @param array $languages
     * @return string
     */
    public function archive(Project $project, array $languages = []): string
    {
        $list = $this->formCollection($project, $languages);

        $rootFolder = request()->user()->name; /** Name is unique */

        /*
         * [
         *  'languageName' => [
         *      'groupName' => [
         *          'key' => 'item'
         *      ]
         *  ]
         * ]
         */
        foreach ($list as $languageName => $language) {
            $path = "$rootFolder/$languageName";
            $this->createDirectory($path);

            foreach ($language as $groupName => $group) {
                $pathToFile = $this->getStoragePath("$path/$groupName.php");
                $this->createPhpFile($pathToFile, $group->toArray());
            }
        }

        return $this->createZipFile($rootFolder, $project);
    }

    /**
     * @param Project $project
     * @param array $languages
     * @return Collection
     */
    protected function formCollection(Project $project, array $languages = []): Collection
    {
        $translations = $project->getTranslations();
        $languages = array_values($languages);

        /*
         * Map to language_codes
         */
        $list = $translations->mapToGroups(function ($item, $key) {
            return [$item->language_code => $item];
        });

        /*
         * Filter languages
         */
        if (!empty($languages))
            $list = $list->reject(function ($item, $key) use ($languages) {
                return !in_array($key, $languages);
            });

        foreach ($list as $key => $group) {
            /*
             * Map to Groups
             */
            $list[$key] = $list[$key]->mapToGroups(function ($item, $key) {
                return [$item->group_name => $item];
            });

            /*
             * Assign translation keys to entries
             */
            foreach ($list[$key] as $index => $item)
                $list[$key][$index] = $list[$key][$index]->mapWithKeys(function ($item, $key) {
                    return [$item->key => $item->entry];
                });
        }

        return $list;
    }

    /**
     * @param string $dir
     */
    private function createDirectory(string $dir = ''): void
    {
        $path = $this->getStoragePath($dir);

        if (!file_exists($path))
            File::makeDirectory($path, 0777, true);
    }

    /**
     * @param string $dir
     */
    public function deleteDirectory(string $dir): void
    {
        $dir = $this->getStoragePath($dir);

        if (File::exists($dir))
            File::deleteDirectory($dir);
    }

    /**
     * @param string $path
     * @param array $data
     */
    private function createPhpFile(string $path, array $data): void
    {
        $file = sprintf("<?php return %s ?>", json_encode($data, JSON_UNESCAPED_UNICODE));

        $file = str_replace('":"', '"=>"', $file);
        $file = str_replace('{"', '["', $file);
        $file = str_replace('"}', '"]', $file);

        File::put($path, $file);
    }

    /**
     * @param string $rootFolder
     * @param Project $project
     * @return string
     */
    private function createZipFile(string $rootFolder, Project $project): string
    {
        $zipFile = $this->getStoragePath(sprintf('%s_%s_%d.zip', $project->name, request()->user()->name, time()));

        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = $this->getStoragePath($rootFolder);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        $this->deleteDirectory($rootFolder);

        return $zipFile;
    }

    private function getStoragePath(string $directory = ''): string
    {
        return storage_path(sprintf("%s/%s", self::STORAGE_PATH, $directory));
    }
}
