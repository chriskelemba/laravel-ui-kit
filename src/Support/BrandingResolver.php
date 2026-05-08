<?php

namespace ChrisKelemba\LaravelUiKit\Support;

use Illuminate\Support\Facades\DB;

class BrandingResolver
{
    public static function resolveLogo(mixed $logo = null): mixed
    {
        if (filled($logo)) {
            return MediaUrl::resolve($logo);
        }

        $config = config('ui-kit.branding', []);
        $configuredLogo = $config['logo'] ?? null;

        if (filled($configuredLogo)) {
            return MediaUrl::resolve($configuredLogo);
        }

        $database = $config['database'] ?? [];

        if (! ($database['enabled'] ?? false) || ! filled($database['table'] ?? null)) {
            return null;
        }

        $connection = $database['connection'] ?? config('database.default');
        $table = (string) $database['table'];
        $keyColumn = (string) ($database['key_column'] ?? 'key');
        $keyValue = (string) ($database['key_value'] ?? 'default');
        $logoPathColumn = $database['logo_path_column'] ?? 'logo_path';
        $logoBlobColumn = (string) ($database['logo_blob_column'] ?? 'logo_blob');
        $logoMimeColumn = (string) ($database['logo_mime_column'] ?? 'logo_mime');

        try {
            $schema = DB::connection($connection)->getSchemaBuilder();

            if (! $schema->hasTable($table)) {
                return null;
            }

            $columns = array_filter([
                $schema->hasColumn($table, $logoPathColumn) ? $logoPathColumn : null,
                $schema->hasColumn($table, $logoBlobColumn) ? $logoBlobColumn : null,
                $schema->hasColumn($table, $logoMimeColumn) ? $logoMimeColumn : null,
            ]);

            if ($columns === []) {
                return null;
            }

            $record = DB::connection($connection)
                ->table($table)
                ->where($keyColumn, $keyValue)
                ->first($columns);
        } catch (\Throwable) {
            return null;
        }

        if (! $record) {
            return null;
        }

        $path = filled($logoPathColumn) ? data_get($record, $logoPathColumn) : null;

        if (filled($path)) {
            return MediaUrl::resolve($path);
        }

        $blob = data_get($record, $logoBlobColumn);

        if (! filled($blob)) {
            return null;
        }

        $mime = (string) (data_get($record, $logoMimeColumn) ?: 'image/png');

        return 'data:' . $mime . ';base64,' . (string) $blob;
    }
}
