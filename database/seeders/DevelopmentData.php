<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DevelopmentData extends Seeder
{
    public function run(): void
    {
        // User.csv einlesen
        $userData = $this->readCsv('user.csv');
        foreach ($userData as $user) {
            DB::table('ab_user')->insert([
                'ab_name' => $user['ab_name'],
                'ab_password' => $user['ab_password'],
                'ab_mail' => $user['ab_mail'],
            ]);
        }

        // ArticleCategory.csv einlesen
        $categoryData = $this->readCsv('articlecategory.csv');
        foreach ($categoryData as $cat) {
            DB::table('ab_articlecategory')->insert([
                'ab_name' => $cat['ab_name'],
                //da hier in den Dateien die NULL Werte als Strings gelesen werden
                'ab_parent' => (strtolower(trim($cat['ab_parent'])) === 'null' || trim($cat['ab_parent']) === '')
                    ? null
                    : (int) $cat['ab_parent']
            ]);
        }

        // Article.csv einlesen
        $articleData = $this->readCsv('articles.csv');
        foreach ($articleData as $article) {
            DB::table('ab_article')->insert([
                'ab_name' => $article['ab_name'],
                //str_replace, da wir in den Dateien Integer Werten als Strings Werte mit einem Punkt gefunden haben
                'ab_price' => (int) str_replace('.', '', $article['ab_price']),
                'ab_description' => $article['ab_description'],
                'ab_creator_id' => $article['ab_creator_id'],
                'ab_createdate' => $article['ab_createdate'],
            ]);
        }
        // article_has_articlecategory.csv einlesen
        $data = $this->readCsv('article_has_articlecategory.csv');
        foreach ($data as $art_has_cat) {
            DB::table('ab_article_has_articlecategory')->insert([
                'ab_articlecategory_id' => $art_has_cat['ab_articlecategory_id'],
                'ab_article_id' => $art_has_cat['ab_article_id'],
            ]);
        }
    }

    /**
     * @throws Exception
     */
    private function readCsv(string $filename): array
    {
        $filePath = database_path('seeders/data/'. $filename);
        $data = [];

        if (!file_exists($filePath)) {
            throw new Exception("Datei nicht gefunden: $filePath");
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            // 0 für eine unbegrenzte Anzahl an Zeichen beim Lesen, da man beim Lesen nicht genau weißt, wie viel Zeichen in Zeile gibt
            $header = fgetcsv($handle, 0, ';');
            $header = array_map('trim', $header); // Header bereinigen z.B aus Leerzeichen

            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                $row = array_map('trim', $row);    //Werte bereinigen z.B aus Leerzeichen
                $data[] = array_combine($header, $row);
            }

            fclose($handle);
        }

        return $data;
    }

}
