<?php


namespace App\Services\Projects;


use App\Entities\Projects\ProjectRM;
use App\Entities\StatusMessage;
use App\Services\CustomService;
use Exception;
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

    public function json(ProjectRM $project, array $languages = []): string
    {
        $list = $this->formCollection($project, $languages);

        $file = sprintf('%s_%s_%d.json', $project->name, request()->user()->name, time());
        $storagePath = $this->getStoragePath($file);

        try {
            $this->createDirectory();
            File::put($storagePath, $list->toJson(JSON_UNESCAPED_UNICODE));
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $this->fireStatusMessage(StatusMessage::TYPES['danger'], "File creation error:\"$message\"");
        }

        return $storagePath;
    }

    public function archive(ProjectRM $project, array $languages = []): string
    {
        $list = $this->formCollection($project, $languages);

        $rootFolder = request()->user()->name; /** Name is unique */

        /**
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
            try {
                $this->createDirectory($path);
            } catch (Exception $exception) {
                $this->fireStatusMessage(StatusMessage::TYPES['danger'], "Directory \"$path\" was not created");
            }

            foreach ($language as $groupName => $group) {
                $pathToFile = $this->getStoragePath("$path/$groupName.php");

                try {
                    $this->createPhpFile($pathToFile, $group->toArray());
                } catch (Exception $exception) {
                    $this->fireStatusMessage(StatusMessage::TYPES['danger'], "File \"$pathToFile\" was not created");
                }
            }
        }

        return $this->createZipFile($rootFolder, $project);
    }

    protected function formCollection(ProjectRM $project, array $languages = []): Collection
    {
        $translations = $project->getTranslations();
        $languages = array_values($languages);

        /**
         * Map to language_codes
         */
        $list = $translations->mapToGroups(function ($item, $key) {
            return [$item->language_code => $item];
        });

        /**
         * Filter languages
         */
        if (!empty($languages))
            $list = $list->reject(function ($item, $key) use ($languages) {
                return !in_array($key, $languages);
            });

        foreach ($list as $key => $group) {
            /**
             * Map to Groups
             */
            $list[$key] = $list[$key]->mapToGroups(function ($item, $key) {
                return [$item->group_name => $item];
            });

            /**
             * Assign translation keys to entries
             */
            foreach ($list[$key] as $index => $item)
                $list[$key][$index] = $list[$key][$index]->mapWithKeys(function ($item, $key) {
                    return [$item->key => $item->entry];
                });
        }

        return $list;
    }

    private function createDirectory(string $dir = ''): void
    {
        $path = $this->getStoragePath($dir);

        if (!file_exists($path))
            File::makeDirectory($path, 0777, true);
    }

    public function deleteDirectory(string $dir): void
    {
        $dir = $this->getStoragePath($dir);

        if (File::exists($dir))
            File::deleteDirectory($dir);
    }

    private function createPhpFile(string $path, array $data): void
    {
        $file = sprintf("<?php return %s ?>", json_encode($data, JSON_UNESCAPED_UNICODE));

        $file = str_replace('":"', '"=>"', $file);
        $file = str_replace('{"', '["', $file);
        $file = str_replace('"}', '"]', $file);

        File::put($path, $file);
    }

    private function createZipFile(string $rootFolder, ProjectRM $project): string
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
